// Assessment Container Responsive Scaling (works for both Vehicle Body Panels and Interior Components)
class AssessmentResponsive {
    constructor() {
        this.containers = [];
        this.initialized = false;
        this.resizeTimeout = null;
    }

    init() {
        // Find all assessment containers (both vehicle and interior)
        const vehicleContainers = document.querySelectorAll('.vehicle-container');
        const interiorContainers = document.querySelectorAll('.interior-container');
        
        // Process vehicle containers
        vehicleContainers.forEach(container => {
            const baseImage = container.querySelector('.base-vehicle');
            if (baseImage) {
                this.setupContainer(container, baseImage, 'vehicle');
            }
        });
        
        // Process interior containers
        interiorContainers.forEach(container => {
            const baseImage = container.querySelector('.base-interior');
            if (baseImage) {
                this.setupContainer(container, baseImage, 'interior');
            }
        });
        
        // Set up global resize listener
        window.addEventListener('resize', () => this.handleResize());
        
        // Initial scale for all containers
        this.scaleAllContainers();
        this.initialized = true;
    }
    
    setupContainer(container, baseImage, type) {
        // Check if wrapper exists, if not create it
        if (!container.parentElement.classList.contains('assessment-wrapper')) {
            this.createWrapper(container);
        }
        
        const wrapper = container.parentElement;
        
        // Store container info
        this.containers.push({
            container: container,
            wrapper: wrapper,
            baseImage: baseImage,
            type: type
        });
        
        // Set up load listener for image
        if (baseImage.complete) {
            this.scaleContainer({ container, wrapper, baseImage, type });
        } else {
            baseImage.addEventListener('load', () => {
                this.scaleContainer({ container, wrapper, baseImage, type });
            });
        }
    }
    
    createWrapper(container) {
        const wrapper = document.createElement('div');
        wrapper.className = 'assessment-wrapper';
        container.parentNode.insertBefore(wrapper, container);
        wrapper.appendChild(container);
    }
    
    scaleContainer(containerInfo) {
        const { container, wrapper, baseImage, type } = containerInfo;
        
        if (!container || !wrapper) return;
        
        // Add scaling class to hide during calculation
        container.classList.add('scaling');
        
        // Get card body width (container width)
        const cardBody = container.closest('.card-body');
        if (!cardBody) return;
        
        const cardBodyWidth = cardBody.offsetWidth;
        const cardBodyPaddingLeft = parseFloat(getComputedStyle(cardBody).paddingLeft);
        const cardBodyPaddingRight = parseFloat(getComputedStyle(cardBody).paddingRight);
        const availableWidth = cardBodyWidth - (cardBodyPaddingLeft + cardBodyPaddingRight);
        
        // Original dimensions (both layouts use 1005px width)
        const originalWidth = 1005;
        const originalHeight = type === 'vehicle' ? 1353 : 1437; // Interior is taller
        
        // Calculate scale factor based on available width
        let scaleFactor = availableWidth / originalWidth;
        
        // Limit maximum scale to 1 (don't enlarge beyond original)
        scaleFactor = Math.min(scaleFactor, 1);
        
        // For very small screens, ensure minimum visibility
        if (scaleFactor < 0.3) {
            scaleFactor = 0.3;
        }
        
        // For tablets in landscape, apply additional height constraint
        if (window.matchMedia('(min-width: 768px) and (max-width: 1024px) and (orientation: landscape)').matches) {
            const viewportHeight = window.innerHeight;
            const availableHeight = viewportHeight - 250; // Account for headers and other UI
            const heightScaleFactor = availableHeight / originalHeight;
            scaleFactor = Math.min(scaleFactor, heightScaleFactor);
        }
        
        // Apply transform with proper centering
        container.style.transform = `scale(${scaleFactor})`;
        container.style.transformOrigin = 'top left';
        
        // Calculate the scaled dimensions
        const scaledWidth = originalWidth * scaleFactor;
        const scaledHeight = originalHeight * scaleFactor;
        
        // Center the container horizontally
        const horizontalOffset = (availableWidth - scaledWidth) / 2;
        
        // Apply positioning
        if (horizontalOffset > 0) {
            container.style.left = `${horizontalOffset}px`;
            container.style.marginLeft = '0';
            container.style.marginRight = '0';
        } else {
            container.style.left = '0';
            container.style.marginLeft = '0';
            container.style.marginRight = '0';
        }
        
        // Set wrapper dimensions to match scaled content
        wrapper.style.width = '100%';
        wrapper.style.height = `${scaledHeight}px`;
        wrapper.style.position = 'relative';
        wrapper.style.overflow = 'visible';
        
        // Ensure container is positioned absolutely within wrapper
        container.style.position = 'absolute';
        container.style.top = '0';
        
        // Remove scaling class and add scaled class
        container.classList.remove('scaling');
        container.classList.add('scaled');
        
        // Store scale factor for other uses
        container.dataset.scaleFactor = scaleFactor;
        
        // Dispatch custom event for other scripts
        window.dispatchEvent(new CustomEvent('assessmentScaled', { 
            detail: { 
                scaleFactor: scaleFactor,
                type: type,
                container: container
            } 
        }));
    }
    
    scaleAllContainers() {
        this.containers.forEach(containerInfo => {
            this.scaleContainer(containerInfo);
        });
    }
    
    handleResize() {
        // Debounce resize events
        clearTimeout(this.resizeTimeout);
        this.resizeTimeout = setTimeout(() => {
            this.scaleAllContainers();
        }, 250);
    }
    
    getScaleFactor(container) {
        return parseFloat(container.dataset.scaleFactor) || 1;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const assessmentResponsive = new AssessmentResponsive();
    assessmentResponsive.init();
    
    // Make instance globally available
    window.assessmentResponsive = assessmentResponsive;
});

// Handle dynamic content (if using Turbo or similar)
document.addEventListener('turbo:load', function() {
    if (window.assessmentResponsive && !window.assessmentResponsive.initialized) {
        window.assessmentResponsive.init();
    }
});

// Also handle if content is loaded dynamically via AJAX
document.addEventListener('assessmentContentLoaded', function() {
    if (window.assessmentResponsive) {
        window.assessmentResponsive.init();
    }
});