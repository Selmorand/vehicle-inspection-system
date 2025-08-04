// Vehicle Container Responsive Scaling
class VehicleResponsive {
    constructor() {
        this.baseVehicle = null;
        this.vehicleContainer = null;
        this.vehicleWrapper = null;
        this.overlays = null;
        this.initialized = false;
        this.resizeTimeout = null;
    }

    init() {
        this.baseVehicle = document.getElementById('baseVehicle');
        this.vehicleContainer = document.querySelector('.vehicle-container');
        this.overlays = document.querySelectorAll('.panel-overlay');
        
        if (!this.baseVehicle || !this.vehicleContainer) return;
        
        // Create wrapper if it doesn't exist
        if (!this.vehicleContainer.parentElement.classList.contains('vehicle-wrapper')) {
            this.createWrapper();
        }
        
        this.vehicleWrapper = this.vehicleContainer.parentElement;
        
        // Set up event listeners
        if (this.baseVehicle.complete) {
            this.scaleVehicle();
        } else {
            this.baseVehicle.addEventListener('load', () => this.scaleVehicle());
        }
        
        window.addEventListener('resize', () => this.handleResize());
        
        // Initial scale
        this.scaleVehicle();
        this.initialized = true;
    }
    
    createWrapper() {
        const wrapper = document.createElement('div');
        wrapper.className = 'vehicle-wrapper';
        this.vehicleContainer.parentNode.insertBefore(wrapper, this.vehicleContainer);
        wrapper.appendChild(this.vehicleContainer);
    }
    
    scaleVehicle() {
        if (!this.baseVehicle || !this.vehicleContainer || !this.vehicleWrapper) return;
        
        // Add scaling class to hide during calculation
        this.vehicleContainer.classList.add('scaling');
        
        // Get card body width (container width)
        const cardBody = this.vehicleContainer.closest('.card-body');
        if (!cardBody) return;
        
        const availableWidth = cardBody.offsetWidth - (parseFloat(getComputedStyle(cardBody).paddingLeft) + parseFloat(getComputedStyle(cardBody).paddingRight));
        
        // Original dimensions
        const originalWidth = 1005;
        const originalHeight = 1353; // Approximate, will be calculated from image
        
        // Calculate scale factor
        let scaleFactor = availableWidth / originalWidth;
        
        // For tablets in landscape, apply additional constraint
        if (window.matchMedia('(min-width: 768px) and (max-width: 1024px) and (orientation: landscape)').matches) {
            const viewportHeight = window.innerHeight;
            const availableHeight = viewportHeight - 200; // Account for headers and other UI
            const heightScaleFactor = availableHeight / originalHeight;
            scaleFactor = Math.min(scaleFactor, heightScaleFactor);
        }
        
        // Ensure scale factor doesn't exceed 1 (don't enlarge beyond original)
        scaleFactor = Math.min(scaleFactor, 1);
        
        // Apply transform
        this.vehicleContainer.style.transform = `scale(${scaleFactor})`;
        
        // Calculate actual height after scaling
        const actualHeight = this.baseVehicle.naturalHeight || originalHeight;
        const scaledHeight = actualHeight * scaleFactor;
        
        // Set wrapper height to prevent overflow
        this.vehicleWrapper.style.height = `${scaledHeight}px`;
        
        // Remove scaling class and add scaled class
        this.vehicleContainer.classList.remove('scaling');
        this.vehicleContainer.classList.add('scaled');
        
        // Store scale factor for other uses
        this.vehicleContainer.dataset.scaleFactor = scaleFactor;
        
        // Dispatch custom event for other scripts
        window.dispatchEvent(new CustomEvent('vehicleScaled', { 
            detail: { scaleFactor: scaleFactor } 
        }));
    }
    
    handleResize() {
        // Debounce resize events
        clearTimeout(this.resizeTimeout);
        this.resizeTimeout = setTimeout(() => {
            this.scaleVehicle();
        }, 250);
    }
    
    getScaleFactor() {
        return parseFloat(this.vehicleContainer.dataset.scaleFactor) || 1;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const vehicleResponsive = new VehicleResponsive();
    vehicleResponsive.init();
    
    // Make instance globally available
    window.vehicleResponsive = vehicleResponsive;
});

// Handle dynamic content
document.addEventListener('turbo:load', function() {
    if (window.vehicleResponsive && !window.vehicleResponsive.initialized) {
        window.vehicleResponsive.init();
    }
});