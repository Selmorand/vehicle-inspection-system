@extends('layouts.app')

@section('title', 'Service Booklet')

@section('content')
<div class="container">
    <!-- Progress Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/inspection/visual" style="color: var(--primary-color);">Visual Inspection</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/body-panel" style="color: var(--primary-color);">Body Panel Assessment</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/specific-areas" style="color: var(--primary-color);">Specific Area Images</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/interior" style="color: var(--primary-color);">Interior Assessment</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/interior-images" style="color: var(--primary-color);">Interior Specific Images</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Service Booklet</li>
                    <li class="breadcrumb-item text-muted">Final Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Service Booklet Documentation</h2>
        <p class="text-muted">Take photos of service booklet pages and add any relevant comments about the vehicle's service history.</p>
    </div>

    <form id="service-booklet-form" enctype="multipart/form-data">
        @csrf
        
        <!-- Service Booklet Images Section -->
        <div class="form-section">
            <h3>Service Booklet Images</h3>
            <p class="text-muted mb-3">Take photos of service booklet pages using your tablet camera. Photos are automatically cropped to square format.</p>
            
            <!-- Image upload grid optimized for tablets -->
            <div class="image-upload-grid" id="serviceBookletGrid">
                <!-- Initial placeholder will be created by JavaScript -->
            </div>
            
            <!-- Hidden file input optimized for tablet camera -->
            <input type="file" id="serviceBookletCameraInput" accept="image/*" capture="environment" style="display: none;">
        </div>

        <!-- Service Comments Section -->
        <div class="form-section">
            <h3>Service History Comments</h3>
            <div class="form-row">
                <label for="service_comments" class="form-label fw-bold">Service History Notes:</label>
                <textarea class="form-control" id="service_comments" name="service_comments" rows="6" 
                    placeholder="Add any relevant comments about the vehicle's service history, maintenance records, or observations from the service booklet..."></textarea>
            </div>
            
            <div class="form-row">
                <label for="service_recommendations" class="form-label fw-bold">Service Recommendations:</label>
                <textarea class="form-control" id="service_recommendations" name="service_recommendations" rows="4" 
                    placeholder="Any recommended services or maintenance based on the service history review..."></textarea>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-secondary me-3" onclick="goBack()">
                <i class="bi bi-arrow-left me-1"></i>Back to Interior Images
            </button>
            <button type="button" class="btn btn-success me-3" id="simplePreviewBtn">
                <i class="bi bi-eye me-1"></i>Simple Preview
            </button>
            <button type="button" class="btn btn-secondary me-3" onclick="saveDraft()">
                Save Draft
            </button>
            <button type="button" class="btn btn-primary" onclick="continueToFinalReport()">
                Continue to Tyres & Rims Assessment <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('additional-js')
<script>
// Image management
const maxImages = 20; // Maximum number of images allowed
let imageCount = 0;
let uploadedServiceBookletImages = [];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeServiceBookletGrid();
    loadPreviousData();
    
    // Simple Preview button handler
    document.getElementById('simplePreviewBtn').addEventListener('click', function() {
        console.log('Service Booklet Simple Preview clicked');
        
        // Collect form data
        const form = document.getElementById('service-booklet-form');
        const formData = {};
        
        // Get text fields
        const serviceComments = document.getElementById('service_comments').value;
        const serviceRecommendations = document.getElementById('service_recommendations').value;
        
        if (serviceComments) formData['service_comments'] = serviceComments;
        if (serviceRecommendations) formData['service_recommendations'] = serviceRecommendations;
        
        // Get image count
        const imageData = {
            'service_booklet_images': uploadedServiceBookletImages || []
        };
        
        console.log('Service Booklet Preview - Form Data:', formData);
        console.log('Service Booklet Preview - Images:', imageData);
        
        if (Object.keys(formData).length === 0 && uploadedServiceBookletImages.length === 0) {
            alert('No data to preview. Please add service booklet images or comments.');
            return;
        }
        
        // Prepare data for preview
        const previewData = {
            data: formData,
            images: imageData
        };
        
        // Submit to preview endpoint
        fetch('/preview/service-booklet', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(previewData)
        })
        .then(response => response.text())
        .then(html => {
            // Open preview in new window
            const previewWindow = window.open('', '_blank');
            previewWindow.document.write(html);
            previewWindow.document.close();
        })
        .catch(error => {
            console.error('Preview error:', error);
            alert('Error generating preview: ' + error.message);
        });
    });
});

function initializeServiceBookletGrid() {
    const grid = document.getElementById('serviceBookletGrid');
    // Create initial placeholder
    createServiceBookletSlot(grid);
}

function createServiceBookletSlot(container) {
    const slot = document.createElement('div');
    slot.className = 'image-upload-slot';
    slot.innerHTML = `
        <div class="upload-placeholder">
            <i class="bi bi-camera"></i>
            <small>Tap to capture photo</small>
        </div>
    `;
    
    // Optimized for tablet touch - larger touch area and immediate camera trigger
    slot.addEventListener('click', function() {
        if (!this.classList.contains('has-image')) {
            triggerServiceBookletCamera();
        }
    });
    
    // Also handle touch events for better tablet responsiveness
    slot.addEventListener('touchstart', function(e) {
        e.preventDefault(); // Prevent double-tap zoom
        if (!this.classList.contains('has-image')) {
            triggerServiceBookletCamera();
        }
    });
    
    container.appendChild(slot);
}

function triggerServiceBookletCamera() {
    const input = document.getElementById('serviceBookletCameraInput');
    input.click();
}

// Handle camera input
document.getElementById('serviceBookletCameraInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file && file.type.startsWith('image/')) {
        processServiceBookletImage(file);
    }
    
    // Clear the input to allow taking the same photo again if needed
    this.value = '';
});

function processServiceBookletImage(file) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
        // Create a canvas to crop the image to square
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Make it square by using the smaller dimension
            const size = Math.min(img.width, img.height);
            canvas.width = 300; // Fixed output size
            canvas.height = 300;
            
            // Calculate crop area (center crop)
            const startX = (img.width - size) / 2;
            const startY = (img.height - size) / 2;
            
            // Draw cropped image
            ctx.drawImage(img, startX, startY, size, size, 0, 0, 300, 300);
            
            // Convert to blob and add to interface
            canvas.toBlob(function(blob) {
                addServiceBookletImageToGrid(URL.createObjectURL(blob), blob);
            }, 'image/jpeg', 0.8);
        };
        img.src = e.target.result;
    };
    
    reader.readAsDataURL(file);
}

function addServiceBookletImageToGrid(imageSrc, blob) {
    const grid = document.getElementById('serviceBookletGrid');
    const emptySlot = grid.querySelector('.image-upload-slot:not(.has-image)');
    
    if (emptySlot) {
        emptySlot.innerHTML = `
            <img src="${imageSrc}" alt="Service booklet image">
            <button type="button" class="remove-image" onclick="removeServiceBookletImage(this)">
                <i class="bi bi-x"></i>
            </button>
        `;
        emptySlot.classList.add('has-image');
        
        // Store the image data
        uploadedServiceBookletImages.push({
            slot: emptySlot,
            blob: blob,
            src: imageSrc
        });
        
        // Always add a new placeholder after adding an image (if under max limit)
        if (grid.children.length < maxImages) {
            createServiceBookletSlot(grid);
        }
    }
}

function removeServiceBookletImage(button) {
    const slot = button.closest('.image-upload-slot');
    const imageIndex = uploadedServiceBookletImages.findIndex(img => img.slot === slot);
    
    if (imageIndex > -1) {
        // Revoke the object URL to free memory
        URL.revokeObjectURL(uploadedServiceBookletImages[imageIndex].src);
        uploadedServiceBookletImages.splice(imageIndex, 1);
    }
    
    // Remove the slot entirely instead of converting back to placeholder
    slot.remove();
    
    // Ensure there's always at least one placeholder available
    const grid = document.getElementById('serviceBookletGrid');
    if (grid.querySelectorAll('.image-upload-slot:not(.has-image)').length === 0) {
        createServiceBookletSlot(grid);
    }
}

function loadPreviousData() {
    // Display summary of inspection progress
    const visualData = sessionStorage.getItem('visualInspectionData');
    
    if (visualData) {
        const data = JSON.parse(visualData);
        displayInspectionSummary(data);
    }

    // Load any existing service booklet data
    const serviceBookletData = sessionStorage.getItem('serviceBookletData');
    if (serviceBookletData) {
        restoreServiceBookletData(JSON.parse(serviceBookletData));
    }
}

function displayInspectionSummary(data) {
    const breadcrumbContainer = document.querySelector('.breadcrumb').parentElement.parentElement;
    const summaryDiv = document.createElement('div');
    summaryDiv.className = 'row mb-3';
    summaryDiv.innerHTML = `
        <div class="col-12">
            <div class="alert alert-info">
                <strong>Inspection Progress:</strong>
                ${data.manufacturer} ${data.model} (${data.vehicle_type}) | 
                VIN: ${data.vin} | 
                Inspector: ${data.inspector_name} |
                Progress: Visual ✓ | Body Panels ✓ | Specific Areas ✓ | Interior Assessment ✓ | Interior Images ✓ | Service Booklet
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

function restoreServiceBookletData(data) {
    // Restore form fields
    if (data.service_comments) {
        document.getElementById('service_comments').value = data.service_comments;
    }
    if (data.service_recommendations) {
        document.getElementById('service_recommendations').value = data.service_recommendations;
    }
    
    // Restore images
    if (data.images) {
        data.images.forEach(imageData => {
            if (imageData && imageData.src) {
                addServiceBookletImageToGrid(imageData.src, imageData.blob);
            }
        });
    }
}

function saveCurrentProgress() {
    // Collect form data
    const formData = new FormData(document.getElementById('service-booklet-form'));
    const serviceBookletData = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== '_token' && value) {
            serviceBookletData[key] = value;
        }
    }
    
    // Store images data
    serviceBookletData.images = uploadedServiceBookletImages.map(img => ({
        src: img.src,
        // Note: In production, images would be uploaded to server
    }));
    
    sessionStorage.setItem('serviceBookletData', JSON.stringify(serviceBookletData));
}

function goBack() {
    saveCurrentProgress();
    window.location.href = '/inspection/interior-images';
}

function saveDraft() {
    saveCurrentProgress();
    alert('Service booklet draft saved successfully!');
}

function continueToFinalReport() {
    saveCurrentProgress();
    
    // Navigate to tyres and rims assessment section
    window.location.href = '/inspection/tyres-rims';
}
</script>
@endsection