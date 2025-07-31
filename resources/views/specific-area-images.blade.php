@extends('layouts.app')

@section('title', 'Specific Area Images')

@section('content')
<div class="container">
    <!-- Progress Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/inspection/visual" style="color: var(--primary-color);">Visual Inspection</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/body-panel" style="color: var(--primary-color);">Body Panel Assessment</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Specific Area Images</li>
                    <li class="breadcrumb-item text-muted">Final Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">AlPHA Inspection</h1>
        <h2 class="h4" style="color: var(--text-color);">Specific Area Images</h2>
        <p class="text-muted">Take photos of specific vehicle areas using your tablet camera. Each area should have one clear photo.</p>
    </div>

    <form id="specific-area-form" enctype="multipart/form-data">
        @csrf
        
        <!-- Vehicle Images - Specific Areas Section -->
        <div class="form-section">
            <h3>Vehicle Images - Specific Areas</h3>
            <p class="text-muted mb-3">Take photos of specific vehicle areas using your tablet camera. Each area should have one clear photo.</p>
            
            <!-- Responsive image grid - 3 per row portrait, 6 per row landscape -->
            <div class="row g-3" id="specificImageGrid">
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="front-bumper">
                        <span class="area-label">Front Bumper</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="bonnet">
                        <span class="area-label">Bonnet</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="lf-fender">
                        <span class="area-label">LF Fender</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="lf-mirror">
                        <span class="area-label">LF Mirror</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="lf-door">
                        <span class="area-label">LF Door</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="lr-door">
                        <span class="area-label">LR Door</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="lr-quarter-panel">
                        <span class="area-label">LR Quarter Panel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="rear-bumper">
                        <span class="area-label">Rear Bumper</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="boot">
                        <span class="area-label">Boot</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="rr-quarter-panel">
                        <span class="area-label">RR Quarter Panel</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="rr-door">
                        <span class="area-label">RR Door</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="fr-door">
                        <span class="area-label">FR Door</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="fr-mirror">
                        <span class="area-label">FR Mirror</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="fr-fender">
                        <span class="area-label">FR Fender</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="roof">
                        <span class="area-label">Roof</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="windscreen">
                        <span class="area-label">Windscreen</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="engine-compartment">
                        <span class="area-label">Engine Compartment</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-2">
                    <div class="image-slot" data-area="additional">
                        <span class="area-label">Additional</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-camera"></i>
                            <small>Tap to capture</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Hidden file input optimized for tablet camera -->
            <input type="file" id="specificCameraInput" accept="image/*" capture="environment" style="display: none;">
        </div>

        <!-- Action buttons -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-secondary me-3" onclick="goBack()">
                <i class="bi bi-arrow-left me-1"></i>Back to Body Panel Assessment
            </button>
            <button type="button" class="btn btn-secondary me-3" onclick="saveDraft()">
                Save Draft
            </button>
            <button type="button" class="btn btn-primary" onclick="continueToFinalReport()">
                Continue to Final Report <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('additional-js')
<script>
// Image management
let specificAreaImages = {}; // Store images by area
let currentCaptureArea = null; // Track which area is being captured

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeSpecificImageGrid();
    loadPreviousData();
});

function initializeSpecificImageGrid() {
    // Add click handlers to all specific image slots
    const imageSlots = document.querySelectorAll('.image-slot');
    imageSlots.forEach(slot => {
        slot.addEventListener('click', function() {
            if (!this.classList.contains('has-image')) {
                currentCaptureArea = this.dataset.area;
                triggerSpecificCamera();
            }
        });
        
        // Touch events for tablets
        slot.addEventListener('touchstart', function(e) {
            e.preventDefault();
            if (!this.classList.contains('has-image')) {
                currentCaptureArea = this.dataset.area;
                triggerSpecificCamera();
            }
        });
    });
}

function triggerSpecificCamera() {
    const input = document.getElementById('specificCameraInput');
    input.click();
}

// Handle specific area camera input
document.getElementById('specificCameraInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file && file.type.startsWith('image/') && currentCaptureArea) {
        processSpecificAreaImage(file, currentCaptureArea);
    }
    
    // Clear the input to allow taking the same photo again if needed
    this.value = '';
    currentCaptureArea = null;
});

function processSpecificAreaImage(file, areaName) {
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
                displaySpecificAreaImage(URL.createObjectURL(blob), blob, areaName);
            }, 'image/jpeg', 0.8);
        };
        img.src = e.target.result;
    };
    
    reader.readAsDataURL(file);
}

function displaySpecificAreaImage(imageSrc, blob, areaName) {
    const slot = document.querySelector(`[data-area="${areaName}"]`);
    if (slot) {
        slot.innerHTML = `
            <span class="area-label">${slot.querySelector('.area-label').textContent}</span>
            <img src="${imageSrc}" alt="${areaName}">
            <button type="button" class="remove-image" onclick="removeSpecificAreaImage('${areaName}', this)">
                <i class="bi bi-x"></i>
            </button>
        `;
        slot.classList.add('has-image');
        
        // Store the image data
        specificAreaImages[areaName] = {
            src: imageSrc,
            blob: blob
        };
    }
}

function removeSpecificAreaImage(areaName, button) {
    const slot = button.closest('.image-slot');
    
    // Revoke the object URL to free memory
    if (specificAreaImages[areaName]) {
        URL.revokeObjectURL(specificAreaImages[areaName].src);
        delete specificAreaImages[areaName];
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
            triggerSpecificCamera();
        }
    });
}

function loadPreviousData() {
    // Display summary of inspection progress
    const visualData = sessionStorage.getItem('visualInspectionData');
    const panelData = sessionStorage.getItem('panelAssessmentData');
    
    if (visualData) {
        const data = JSON.parse(visualData);
        displayInspectionSummary(data);
    }

    // Load any existing specific area images
    const specificData = sessionStorage.getItem('specificAreaImagesData');
    if (specificData) {
        restoreSpecificAreaImages(JSON.parse(specificData));
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
                General Images: ${data.images ? data.images.length : 0} uploaded
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

function restoreSpecificAreaImages(data) {
    Object.keys(data).forEach(areaName => {
        const imageData = data[areaName];
        if (imageData && imageData.src) {
            displaySpecificAreaImage(imageData.src, imageData.blob, areaName);
        }
    });
}

function saveCurrentProgress() {
    sessionStorage.setItem('specificAreaImagesData', JSON.stringify(specificAreaImages));
}

function goBack() {
    saveCurrentProgress();
    window.location.href = '/inspection/body-panel';
}

function saveDraft() {
    saveCurrentProgress();
    alert('Specific area images draft saved successfully!');
}

function continueToFinalReport() {
    saveCurrentProgress();
    
    // TODO: Navigate to final report section when implemented
    alert('Specific area images completed! (Final report section coming soon...)');
}
</script>
@endsection