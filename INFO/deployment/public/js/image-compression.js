// Image compression utility for vehicle inspection system
class ImageCompressor {
    constructor(options = {}) {
        this.maxWidth = options.maxWidth || 1920;
        this.maxHeight = options.maxHeight || 1080;
        this.quality = options.quality || 0.85;
        this.outputFormat = options.outputFormat || 'image/jpeg';
    }

    // Compress an image file and return a blob
    async compressImage(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            
            reader.onload = (e) => {
                const img = new Image();
                
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    
                    // Calculate new dimensions
                    let width = img.width;
                    let height = img.height;
                    
                    if (width > this.maxWidth || height > this.maxHeight) {
                        const widthRatio = this.maxWidth / width;
                        const heightRatio = this.maxHeight / height;
                        const ratio = Math.min(widthRatio, heightRatio);
                        
                        width *= ratio;
                        height *= ratio;
                    }
                    
                    // Set canvas dimensions
                    canvas.width = width;
                    canvas.height = height;
                    
                    // Draw and compress
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    canvas.toBlob((blob) => {
                        resolve({
                            blob: blob,
                            dataUrl: canvas.toDataURL(this.outputFormat, this.quality),
                            width: width,
                            height: height,
                            originalSize: file.size,
                            compressedSize: blob.size,
                            compressionRatio: ((1 - blob.size / file.size) * 100).toFixed(1)
                        });
                    }, this.outputFormat, this.quality);
                };
                
                img.onerror = () => reject(new Error('Failed to load image'));
                img.src = e.target.result;
            };
            
            reader.onerror = () => reject(new Error('Failed to read file'));
            reader.readAsDataURL(file);
        });
    }

    // Compress multiple images
    async compressMultiple(files) {
        const results = [];
        for (const file of files) {
            try {
                const compressed = await this.compressImage(file);
                results.push({ success: true, file: file, data: compressed });
            } catch (error) {
                results.push({ success: false, file: file, error: error.message });
            }
        }
        return results;
    }
}

// Lazy loading for panel images
class LazyImageLoader {
    constructor() {
        this.imageObserver = null;
        this.init();
    }

    init() {
        // Check if IntersectionObserver is supported
        if ('IntersectionObserver' in window) {
            this.imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        this.loadImage(img);
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px', // Start loading 50px before entering viewport
                threshold: 0.01
            });
        }
    }

    loadImage(img) {
        const src = img.dataset.src;
        if (src) {
            // Create a new image to preload
            const newImg = new Image();
            newImg.onload = () => {
                img.src = src;
                img.classList.add('loaded');
                
                // Add fade-in effect
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s';
                setTimeout(() => {
                    img.style.opacity = '1';
                }, 10);
            };
            newImg.src = src;
        }
    }

    observe(selector = 'img[data-src]') {
        const images = document.querySelectorAll(selector);
        
        if (this.imageObserver) {
            images.forEach(img => this.imageObserver.observe(img));
        } else {
            // Fallback for browsers without IntersectionObserver
            images.forEach(img => this.loadImage(img));
        }
    }
}

// Initialize lazy loading when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const lazyLoader = new LazyImageLoader();
    lazyLoader.observe();
});

// Export for use in other scripts
window.ImageCompressor = ImageCompressor;
window.LazyImageLoader = LazyImageLoader;