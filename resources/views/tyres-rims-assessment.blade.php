@extends('layouts.app')

@section('title', 'Tyres & Rims Assessment')

@section('content')
<div class="container-fluid px-4">
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
                    <li class="breadcrumb-item"><a href="/inspection/service-booklet" style="color: var(--primary-color);">Service Booklet</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Tyres & Rims Assessment</li>
                    <li class="breadcrumb-item text-muted">Mechanical Report</li>
                    <li class="breadcrumb-item text-muted">Final Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Tyres & Rims Assessment</h2>
        <p class="text-muted">Document the condition and specifications of all four tyres and rims</p>
    </div>

    <!-- Tyres & Rims Assessment Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Tyres & Rims:</h5>
                </div>
                <div class="card-body p-0">
                    <form id="tyresRimsAssessmentForm">
                        @csrf
                        
                        <!-- Tyres Assessment Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead style="background-color: #b8dae0;">
                                    <tr>
                                        <th style="width: 15%; background-color: #f8f9fa;"></th>
                                        <th style="width: 20%;" class="text-center">Size</th>
                                        <th style="width: 20%;" class="text-center">Manufacture</th>
                                        <th style="width: 20%;" class="text-center">Model</th>
                                        <th style="width: 15%;" class="text-center">Tread Depth<br>(mm)</th>
                                        <th style="width: 25%;" class="text-center">Damages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="background-color: #f8f9fa; font-weight: bold; vertical-align: middle;">Front Left</td>
                                        <td><input type="text" class="form-control border-0" name="front-left-size" placeholder="e.g., 225/45R/18"></td>
                                        <td><input type="text" class="form-control border-0" name="front-left-manufacture" placeholder="e.g., Continental"></td>
                                        <td><input type="text" class="form-control border-0" name="front-left-model" placeholder="e.g., SportContact"></td>
                                        <td><input type="text" class="form-control border-0" name="front-left-tread-depth" placeholder="e.g., 5mm"></td>
                                        <td><input type="text" class="form-control border-0" name="front-left-damages" placeholder="e.g., Uneven rundown"></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f9fa; font-weight: bold; vertical-align: middle;">Front Right</td>
                                        <td><input type="text" class="form-control border-0" name="front-right-size" placeholder="e.g., 225/45R/18"></td>
                                        <td><input type="text" class="form-control border-0" name="front-right-manufacture" placeholder="e.g., Continental"></td>
                                        <td><input type="text" class="form-control border-0" name="front-right-model" placeholder="e.g., SportContact"></td>
                                        <td><input type="text" class="form-control border-0" name="front-right-tread-depth" placeholder="e.g., 5mm"></td>
                                        <td><input type="text" class="form-control border-0" name="front-right-damages" placeholder="e.g., Uneven rundown"></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f9fa; font-weight: bold; vertical-align: middle;">Rear Left</td>
                                        <td><input type="text" class="form-control border-0" name="rear-left-size" placeholder="e.g., 245/45R/18"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-left-manufacture" placeholder="e.g., Continental"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-left-model" placeholder="e.g., SportContact"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-left-tread-depth" placeholder="e.g., 3mm"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-left-damages" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f8f9fa; font-weight: bold; vertical-align: middle;">Rear Right</td>
                                        <td><input type="text" class="form-control border-0" name="rear-right-size" placeholder="e.g., 245/45R/18"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-right-manufacture" placeholder="e.g., Continental"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-right-model" placeholder="e.g., SportContact"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-right-tread-depth" placeholder="e.g., 3mm"></td>
                                        <td><input type="text" class="form-control border-0" name="rear-right-damages" placeholder=""></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tyre Images Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <!-- Front Left -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="tyre-image-slot" data-position="front-left">
                                <div class="upload-placeholder">
                                    <i class="bi bi-camera"></i>
                                    <small>Add Image +</small>
                                </div>
                                <div class="text-center mt-2">
                                    <strong>Front Left</strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Front Right -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="tyre-image-slot" data-position="front-right">
                                <div class="upload-placeholder">
                                    <i class="bi bi-camera"></i>
                                    <small>Add Image +</small>
                                </div>
                                <div class="text-center mt-2">
                                    <strong>Front Right</strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rear Left -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="tyre-image-slot" data-position="rear-left">
                                <div class="upload-placeholder">
                                    <i class="bi bi-camera"></i>
                                    <small>Add Image +</small>
                                </div>
                                <div class="text-center mt-2">
                                    <strong>Rear Left</strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rear Right -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="tyre-image-slot" data-position="rear-right">
                                <div class="upload-placeholder">
                                    <i class="bi bi-camera"></i>
                                    <small>Add Image +</small>
                                </div>
                                <div class="text-center mt-2">
                                    <strong>Rear Right</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden file input for camera -->
                    <input type="file" id="tyreCameraInput" accept="image/*" capture="environment" style="display: none;">
                </div>
            </div>
        </div>
    </div>

    <!-- Disclaimer Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info">
                <p class="mb-2"><strong>Tyre Safety Information:</strong></p>
                <p class="mb-2">It is recommended that tyres are replaced when the tread depth reaches 2mm. If uneven tyre wear is noted, this may indicate incorrect geometry, which can result in excessive and rapid tyre wear. A full steering and geometry check is therefore recommended.</p>
                <p class="mb-2">If this vehicle is fitted with "Run Flat" tyres and no spare wheel. The tyre's effectiveness in a puncture situation cannot be commented on.</p>
                <p class="mb-0">It is advised to have tyres of the correct size and of similar make, tread pattern and tread depth across axles. This will benefit steering and handling, the operation of the transmission, 4 wheel drive, traction control, ABS and puncture detection systems. This can also prevent premature transmission wear or failure.</p>
            </div>
        </div>
    </div>

    <!-- Action buttons -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <button type="button" class="btn btn-outline-secondary me-3" id="backBtn">
                <i class="bi bi-arrow-left me-1"></i>Back to Service Booklet
            </button>
            <button type="button" class="btn btn-secondary me-3" id="saveDraftBtn">Save Draft</button>
            <button type="submit" class="btn btn-primary" id="nextBtn" form="tyresRimsAssessmentForm">
                Continue to Mechanical Report <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>
</div>
@endsection

@section('additional-css')
<style>
/* Tyres table styling */
.table th {
    font-weight: 600;
    color: var(--text-color);
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    padding: 8px;
}

.table .form-control {
    background-color: transparent;
    font-size: 14px;
    padding: 6px 8px;
}

.table .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(79, 149, 155, 0.25);
    border-color: var(--primary-color);
}

/* Tyre image upload styling */
.tyre-image-slot {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    border: 2px dashed #ccc;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
    min-height: 150px;
}

.tyre-image-slot:hover {
    border-color: var(--primary-color);
    background: rgba(79, 149, 155, 0.05);
}

.tyre-image-slot.has-image {
    border: 2px solid var(--primary-color);
    padding: 0;
}

.tyre-image-slot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.upload-placeholder {
    text-align: center;
    color: #6c757d;
    padding: 20px;
}

.upload-placeholder i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: var(--danger-color);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 12px;
    cursor: pointer;
    z-index: 10;
}

/* Responsive design for tablets and mobile */
@media (max-width: 991px) {
    .table-responsive {
        font-size: 12px;
    }
    
    .table .form-control {
        font-size: 12px;
        padding: 4px 6px;
    }
}

@media (max-width: 768px) {
    .table th {
        font-size: 11px;
        padding: 6px 4px;
    }
    
    .table td {
        padding: 6px 4px;
    }
    
    .table .form-control {
        font-size: 11px;
        padding: 4px;
    }
    
    .tyre-image-slot {
        min-height: 120px;
    }
}

/* Alert styling for disclaimer */
.alert-info {
    background-color: #e8f4f8;
    border-color: var(--primary-color);
    color: var(--text-color);
}
</style>
@endsection

@section('additional-js')
<script>
// Image management
let tyreImages = {
    'front-left': null,
    'front-right': null,
    'rear-left': null,
    'rear-right': null
};
let currentCapturePosition = null;

document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Initialize tyre image slots
    initializeTyreImageSlots();

    // Form submission handler
    document.getElementById('tyresRimsAssessmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save the tyres assessment data
        saveCurrentProgress();
        
        // Navigate to mechanical report section
        alert('Tyres & Rims assessment saved! Continuing to Mechanical Report...');
        window.location.href = '/inspection/mechanical-report';
    });

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        // Save current progress before going back
        saveCurrentProgress();
        window.location.href = '/inspection/service-booklet';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        saveCurrentProgress();
        alert('Tyres & Rims assessment draft saved successfully!');
    });
});

function initializeTyreImageSlots() {
    // Add click handlers to all tyre image slots
    const imageSlots = document.querySelectorAll('.tyre-image-slot');
    imageSlots.forEach(slot => {
        slot.addEventListener('click', function() {
            if (!this.classList.contains('has-image')) {
                currentCapturePosition = this.dataset.position;
                triggerTyreCamera();
            }
        });
        
        // Touch events for tablets
        slot.addEventListener('touchstart', function(e) {
            e.preventDefault();
            if (!this.classList.contains('has-image')) {
                currentCapturePosition = this.dataset.position;
                triggerTyreCamera();
            }
        });
    });
}

function triggerTyreCamera() {
    const input = document.getElementById('tyreCameraInput');
    input.click();
}

// Handle tyre camera input
document.getElementById('tyreCameraInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file && file.type.startsWith('image/') && currentCapturePosition) {
        processTyreImage(file, currentCapturePosition);
    }
    
    // Clear the input to allow taking the same photo again if needed
    this.value = '';
    currentCapturePosition = null;
});

function processTyreImage(file, position) {
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
                displayTyreImage(URL.createObjectURL(blob), blob, position);
            }, 'image/jpeg', 0.8);
        };
        img.src = e.target.result;
    };
    
    reader.readAsDataURL(file);
}

function displayTyreImage(imageSrc, blob, position) {
    const slot = document.querySelector(`[data-position="${position}"]`);
    if (slot) {
        const positionName = slot.querySelector('strong').textContent;
        
        slot.innerHTML = `
            <img src="${imageSrc}" alt="${position} tyre">
            <button type="button" class="remove-image" onclick="removeTyreImage('${position}', this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="text-center mt-2">
                <strong>${positionName}</strong>
            </div>
        `;
        slot.classList.add('has-image');
        
        // Store the image data
        tyreImages[position] = {
            src: imageSrc,
            blob: blob
        };
    }
}

function removeTyreImage(position, button) {
    const slot = button.closest('.tyre-image-slot');
    
    // Revoke the object URL to free memory
    if (tyreImages[position]) {
        URL.revokeObjectURL(tyreImages[position].src);
        tyreImages[position] = null;
    }
    
    // Get position name for restoration
    const positionName = slot.querySelector('strong').textContent;
    
    // Reset the slot
    slot.innerHTML = `
        <div class="upload-placeholder">
            <i class="bi bi-camera"></i>
            <small>Add Image +</small>
        </div>
        <div class="text-center mt-2">
            <strong>${positionName}</strong>
        </div>
    `;
    slot.classList.remove('has-image');
    
    // Re-add click handler
    slot.addEventListener('click', function() {
        if (!this.classList.contains('has-image')) {
            currentCapturePosition = this.dataset.position;
            triggerTyreCamera();
        }
    });
}

// Load previous inspection data and display summary
function loadPreviousData() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    if (visualData) {
        const data = JSON.parse(visualData);
        
        // Display inspection summary at top of page
        displayInspectionSummary(data);
        
        // Load any existing tyres assessment data
        const tyresData = sessionStorage.getItem('tyresRimsAssessmentData');
        if (tyresData) {
            restoreTyresAssessments(JSON.parse(tyresData));
        }
    }
}

// Display summary of inspection data
function displayInspectionSummary(data) {
    const breadcrumbContainer = document.querySelector('.breadcrumb').parentElement.parentElement;
    const summaryDiv = document.createElement('div');
    summaryDiv.className = 'row mb-3';
    summaryDiv.innerHTML = `
        <div class="col-12">
            <div class="alert alert-info">
                <strong>Inspection Details:</strong>
                ${data.manufacturer} ${data.model} (${data.vehicle_type}) | 
                VIN: ${data.vin} | 
                Inspector: ${data.inspector_name} |
                Progress: Visual ✓ | Body Panels ✓ | Specific Areas ✓ | Interior Assessment ✓ | Interior Images ✓ | Service Booklet ✓ | Tyres & Rims
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

// Save current tyres assessment progress
function saveCurrentProgress() {
    const formData = new FormData(document.getElementById('tyresRimsAssessmentForm'));
    const tyresData = {};
    
    for (let [key, value] of formData.entries()) {
        if (value && key !== '_token') {
            tyresData[key] = value;
        }
    }
    
    // Store images data
    tyresData.images = {};
    Object.keys(tyreImages).forEach(position => {
        if (tyreImages[position]) {
            tyresData.images[position] = {
                src: tyreImages[position].src,
                // Note: In production, images would be uploaded to server
            };
        }
    });
    
    sessionStorage.setItem('tyresRimsAssessmentData', JSON.stringify(tyresData));
}

// Restore previous tyres assessments
function restoreTyresAssessments(data) {
    // Restore form fields
    Object.keys(data).forEach(key => {
        if (key !== 'images') {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        }
    });
    
    // Restore images
    if (data.images) {
        Object.keys(data.images).forEach(position => {
            const imageData = data.images[position];
            if (imageData && imageData.src) {
                displayTyreImage(imageData.src, imageData.blob, position);
            }
        });
    }
}
</script>
@endsection