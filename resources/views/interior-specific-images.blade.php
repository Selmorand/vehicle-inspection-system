@extends('layouts.app')

@section('title', 'Interior Specific Area Images')

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
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Interior Specific Images</li>
                    <li class="breadcrumb-item text-muted">Final Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Interior Specific Area Images</h2>
        <p class="text-muted">Take photos of specific interior components using your tablet camera. Each component should have one clear photo.</p>
    </div>

    <form id="interior-specific-form" enctype="multipart/form-data">
        @csrf
        
        <!-- Interior Images - Specific Areas Section -->
        <div class="form-section">
            <h3>Interior Images - Specific Components</h3>
            <p class="text-muted mb-3">Take photos of specific interior components using your tablet camera. Each component should have one clear photo.</p>
            
            <!-- Responsive image grid - 3 per row portrait, 6 per row landscape -->
            <div class="row g-3" id="interiorImageGrid">
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="dash">
                        <span class="area-label">Dash</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="steering-wheel">
                        <span class="area-label">Steering Wheel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="buttons">
                        <span class="area-label">Buttons</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="driver-seat">
                        <span class="area-label">Driver Seat</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="passenger-seat">
                        <span class="area-label">Passenger Seat</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="rooflining">
                        <span class="area-label">Rooflining</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="fr-door-panel">
                        <span class="area-label">FR Door Panel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="fl-door-panel">
                        <span class="area-label">FL Door Panel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="rear-seat">
                        <span class="area-label">Rear Seat</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="additional-seats">
                        <span class="area-label">Additional Seats</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="backboard">
                        <span class="area-label">Backboard</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="rr-door-panel">
                        <span class="area-label">RR Door Panel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="lr-door-panel">
                        <span class="area-label">LR Door Panel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="boot-interior">
                        <span class="area-label">Boot Interior</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="centre-console">
                        <span class="area-label">Centre Console</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="gear-lever">
                        <span class="area-label">Gear Lever</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="air-vents">
                        <span class="area-label">Air Vents</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="additional-interior">
                        <span class="area-label">Additional Interior</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Hidden file input optimized for tablet camera -->
            <input type="file" id="interiorCameraInput" accept="image/*" capture="environment" style="display: none;">
        </div>

        <!-- Action buttons -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-secondary me-3" onclick="goBack()">
                <i class="bi bi-arrow-left me-1"></i>Back to Interior Assessment
            </button>
            <button type="button" class="btn btn-secondary me-3" onclick="saveDraft()">
                Save Draft
            </button>
            <button type="button" class="btn btn-primary" onclick="continueToFinalReport()">
                Continue to Service Booklet <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('additional-js')
<script>
// Image management
let interiorSpecificImages = {}; // Store images by area
let currentCaptureArea = null; // Track which area is being captured

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeInteriorImageGrid();
    loadPreviousData();
});

function initializeInteriorImageGrid() {
    // Add click handlers to all interior image slots
    const imageSlots = document.querySelectorAll('.image-slot');
    imageSlots.forEach(slot => {
        slot.addEventListener('click', function() {
            if (!this.classList.contains('has-image')) {
                currentCaptureArea = this.dataset.area;
                triggerInteriorCamera();
            }
        });
        
        // Touch events for tablets
        slot.addEventListener('touchstart', function(e) {
            e.preventDefault();
            if (!this.classList.contains('has-image')) {
                currentCaptureArea = this.dataset.area;
                triggerInteriorCamera();
            }
        });
    });
}

function triggerInteriorCamera() {
    const input = document.getElementById('interiorCameraInput');
    input.click();
}

// Handle interior camera input
document.getElementById('interiorCameraInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file && file.type.startsWith('image/') && currentCaptureArea) {
        processInteriorImage(file, currentCaptureArea);
    }
    
    // Clear the input to allow taking the same photo again if needed
    this.value = '';
    currentCaptureArea = null;
});

function processInteriorImage(file, areaName) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Make it square by using the smaller dimension
            const size = Math.min(img.width, img.height);
            canvas.width = 300;
            canvas.height = 300;
            
            // Calculate crop area (center crop)
            const startX = (img.width - size) / 2;
            const startY = (img.height - size) / 2;
            
            // Draw cropped image
            ctx.drawImage(img, startX, startY, size, size, 0, 0, 300, 300);
            
            // Convert to blob and display
            canvas.toBlob(function(blob) {
                displayInteriorImage(URL.createObjectURL(blob), blob, areaName);
            }, 'image/jpeg', 0.8);
        };
        img.src = e.target.result;
    };
    
    reader.readAsDataURL(file);
}

function displayInteriorImage(imageSrc, blob, areaName) {
    const slot = document.querySelector(`[data-area="${areaName}"]`);
    if (slot) {
        slot.innerHTML = `
            <span class="area-label">${slot.querySelector('.area-label').textContent}</span>
            <img src="${imageSrc}" alt="${areaName}">
            <button type="button" class="remove-image" onclick="removeInteriorImage('${areaName}', this)">
                <i class="bi bi-x"></i>
            </button>
        `;
        slot.classList.add('has-image');
        
        // Store the image data
        interiorSpecificImages[areaName] = {
            src: imageSrc,
            blob: blob
        };
    }
}

function removeInteriorImage(areaName, button) {
    const slot = button.closest('.image-slot');
    
    // Revoke the object URL to free memory
    if (interiorSpecificImages[areaName]) {
        URL.revokeObjectURL(interiorSpecificImages[areaName].src);
        delete interiorSpecificImages[areaName];
    }
    
    // Reset the slot
    const labelText = slot.querySelector('.area-label').textContent;
    slot.innerHTML = `
        <span class="area-label">${labelText}</span>
        <div class="upload-placeholder">
            <i class="bi bi-camera"></i>
            <small>Tap to capture</small>
        </div>
    `;
    slot.classList.remove('has-image');
    
    // Re-add click handler
    slot.addEventListener('click', function() {
        if (!this.classList.contains('has-image')) {
            currentCaptureArea = this.dataset.area;
            triggerInteriorCamera();
        }
    });
}

function loadPreviousData() {
    // Display summary of inspection progress
    const visualData = sessionStorage.getItem('visualInspectionData');
    const interiorData = sessionStorage.getItem('interiorAssessmentData');
    
    if (visualData) {
        const data = JSON.parse(visualData);
        displayInspectionSummary(data);
    }

    // Load any existing interior specific images
    const interiorSpecificData = sessionStorage.getItem('interiorSpecificImagesData');
    if (interiorSpecificData) {
        restoreInteriorImages(JSON.parse(interiorSpecificData));
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
                Progress: Visual ✓ | Body Panels ✓ | Specific Areas ✓ | Interior Assessment ✓ | Interior Images
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

function restoreInteriorImages(data) {
    Object.keys(data).forEach(areaName => {
        const imageData = data[areaName];
        if (imageData && imageData.src) {
            displayInteriorImage(imageData.src, imageData.blob, areaName);
        }
    });
}

function saveCurrentProgress() {
    sessionStorage.setItem('interiorSpecificImagesData', JSON.stringify(interiorSpecificImages));
}

function goBack() {
    saveCurrentProgress();
    window.location.href = '/inspection/interior';
}

function saveDraft() {
    saveCurrentProgress();
    alert('Interior specific images draft saved successfully!');
}

function continueToFinalReport() {
    saveCurrentProgress();
    
    // Navigate to service booklet section
    window.location.href = '/inspection/service-booklet';
}
</script>
@endsection