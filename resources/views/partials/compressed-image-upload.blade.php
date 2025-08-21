{{-- Compressed Image Upload Component --}}
<script src="{{ asset('js/image-compression.js') }}"></script>

<script>
// Initialize image compressor with custom settings
const imageCompressor = new ImageCompressor({
    maxWidth: 1920,
    maxHeight: 1080,
    quality: 0.85 // 85% quality
});

// Updated processImage function with compression
async function processImageWithCompression(file) {
    try {
        // Show loading indicator
        showLoadingIndicator();
        
        // Compress the image
        const compressed = await imageCompressor.compressImage(file);
        
        // Create square crop from compressed image
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Square crop settings
            const size = Math.min(img.width, img.height);
            canvas.width = 300;
            canvas.height = 300;
            
            // Center crop
            const startX = (img.width - size) / 2;
            const startY = (img.height - size) / 2;
            
            // Draw cropped image
            ctx.drawImage(img, startX, startY, size, size, 0, 0, 300, 300);
            
            // Get the final image
            canvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                addImageToGrid(url, blob);
                
                // Show compression stats
                showCompressionStats(compressed);
                
                // Upload to server if needed
                if (typeof uploadToServer === 'function') {
                    uploadToServer(blob);
                }
                
                hideLoadingIndicator();
            }, 'image/jpeg', 0.9);
        };
        
        img.src = compressed.dataUrl;
        
    } catch (error) {
        console.error('Image compression failed:', error);
        hideLoadingIndicator();
        notify.error('Failed to process image. Please try again.');
    }
}

// Replace the existing file input handler
document.getElementById('cameraInput').addEventListener('change', async function(e) {
    const file = e.target.files[0];
    if (file) {
        await processImageWithCompression(file);
    }
    this.value = ''; // Reset input
});

// Helper functions
function showLoadingIndicator() {
    const loader = document.getElementById('imageLoader');
    if (loader) loader.style.display = 'block';
}

function hideLoadingIndicator() {
    const loader = document.getElementById('imageLoader');
    if (loader) loader.style.display = 'none';
}

function showCompressionStats(compressed) {
    console.log(`Image compressed: ${compressed.compressionRatio}% reduction`);
    console.log(`Original size: ${(compressed.originalSize / 1024).toFixed(1)}KB`);
    console.log(`Compressed size: ${(compressed.compressedSize / 1024).toFixed(1)}KB`);
}

// Function to upload compressed image to server
async function uploadToServer(blob) {
    const formData = new FormData();
    formData.append('image', blob, 'inspection-image.jpg');
    formData.append('type', 'visual-inspection');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
    try {
        const response = await fetch('/api/image/upload', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        if (result.success) {
            console.log('Image uploaded successfully:', result.path);
            // Store the server path for later use
            return result.path;
        }
    } catch (error) {
        console.error('Upload failed:', error);
    }
}
</script>

{{-- Loading indicator --}}
<div id="imageLoader" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Processing image...</span>
    </div>
    <p class="mt-2">Compressing image...</p>
</div>