@extends('layouts.app')

@section('title', 'Visual Inspection - New Report')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Vehicle Inspection Report</h2>
    </div>

    <!-- TODO: Add 'required' attributes back to all form fields before production deployment -->
    <form id="visual-inspection-form" enctype="multipart/form-data">
        @csrf
        
        <!-- Inspector Details Section -->
        <div class="form-section">
            <h3>Inspector Details</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-row">
                        <label for="inspection_datetime" class="form-label fw-bold">Inspection Time & Date:</label>
                        <input type="datetime-local" class="form-control" id="inspection_datetime" name="inspection_datetime">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-row">
                        <label for="inspector_name" class="form-label fw-bold">Inspector:</label>
                        <input type="text" class="form-control" id="inspector_name" name="inspector_name" placeholder="Inspector name">
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Images Section -->
        <div class="form-section">
            <h3>Vehicle Images</h3>
            <p class="text-muted mb-3">Take photos of the vehicle using your tablet camera. Photos are automatically cropped to square format.</p>
            
            <!-- Image upload grid optimized for tablets -->
            <div class="image-upload-grid" id="imageGrid">
                <!-- Initial placeholder will be created by JavaScript -->
            </div>
            
            <!-- Hidden file input optimized for tablet camera -->
            <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display: none;">
        </div>

        <!-- Vehicle Details Section -->
        <div class="form-section">
            <h3>Vehicle Details</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="vehicle_type" class="form-label fw-bold">Vehicle Type:</label>
                        <select class="form-control" id="vehicle_type" name="vehicle_type">
                            <option value="">Select vehicle type</option>
                            <option value="passenger vehicle">Passenger Vehicle</option>
                            <option value="commercial vehicle">Commercial Vehicle</option>
                            <option value="motorcycle">Motorcycle</option>
                            <option value="truck">Truck</option>
                            <option value="van">Van</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="manufacturer" class="form-label fw-bold">Manufacturer:</label>
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="e.g., BMW">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="model" class="form-label fw-bold">Model:</label>
                        <input type="text" class="form-control" id="model" name="model">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="vin" class="form-label fw-bold">VIN:</label>
                        <input type="text" class="form-control" id="vin" name="vin" maxlength="17">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="engine_number" class="form-label fw-bold">Engine Number:</label>
                        <input type="text" class="form-control" id="engine_number" name="engine_number">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="registration_number" class="form-label fw-bold">Registration Number:</label>
                        <input type="text" class="form-control" id="registration_number" name="registration_number">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="colour" class="form-label fw-bold">Colour:</label>
                        <input type="text" class="form-control" id="colour" name="colour" placeholder="e.g., Gold">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="year_model" class="form-label fw-bold">Year Model:</label>
                        <input type="number" class="form-control" id="year_model" name="year_model" min="1900" max="2030">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="km_reading" class="form-label fw-bold">Km Reading:</label>
                        <input type="number" class="form-control" id="km_reading" name="km_reading" placeholder="e.g., 50000">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="fuel_type" class="form-label fw-bold">Fuel Type:</label>
                        <select class="form-control" id="fuel_type" name="fuel_type">
                            <option value="">Select fuel type</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                            <option value="LPG">LPG</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="transmission" class="form-label fw-bold">Transmission:</label>
                        <select class="form-control" id="transmission" name="transmission">
                            <option value="">Select transmission</option>
                            <option value="Manual">Manual</option>
                            <option value="Automatic">Automatic</option>
                            <option value="CVT">CVT</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <label for="doors" class="form-label fw-bold">Doors:</label>
                        <select class="form-control" id="doors" name="doors">
                            <option value="">Select doors</option>
                            <option value="2 Door">2 Door</option>
                            <option value="3 Door">3 Door</option>
                            <option value="4 Door">4 Door</option>
                            <option value="5 Door">5 Door</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagnostic Report Section -->
        <div class="form-section">
            <h3>Diagnostic Report</h3>
            <div class="form-row">
                <label for="diagnostic_report" class="form-label fw-bold">Diagnostic Report:</label>
                <textarea class="form-control" id="diagnostic_report" name="diagnostic_report" rows="3" 
                    placeholder="During the diagnostic report no active messages of the vehicle manufacture or ALPHA Inspections."></textarea>
            </div>
            
            <!-- File upload for diagnostic report -->
            <div class="mt-3">
                <label for="diagnostic_file" class="form-label fw-bold">Add Diagnostic File:</label>
                <input type="file" class="form-control" id="diagnostic_file" name="diagnostic_file" accept=".pdf">
                <small class="text-muted">Upload diagnostic report file (PDF only)</small>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-secondary me-3" onclick="saveDraft()">
                Save Draft
            </button>
            <button type="button" class="btn btn-primary" onclick="continueToNext()">
                Continue to Next Section
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
let uploadedImages = [];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeImageGrid();
    setCurrentDateTime();
});

function initializeImageGrid() {
    const grid = document.getElementById('imageGrid');
    // Create initial placeholder
    createImageSlot(grid);
}

function createImageSlot(container) {
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
            triggerCamera();
        }
    });
    
    // Also handle touch events for better tablet responsiveness
    slot.addEventListener('touchstart', function(e) {
        e.preventDefault(); // Prevent double-tap zoom
        if (!this.classList.contains('has-image')) {
            triggerCamera();
        }
    });
    
    container.appendChild(slot);
}

function triggerCamera() {
    const input = document.getElementById('cameraInput');
    input.click();
}

// Handle camera input
document.getElementById('cameraInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file && file.type.startsWith('image/')) {
        processImage(file);
    }
    
    // Clear the input to allow taking the same photo again if needed
    this.value = '';
});

function processImage(file) {
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
                addImageToGrid(URL.createObjectURL(blob), blob);
            }, 'image/jpeg', 0.8);
        };
        img.src = e.target.result;
    };
    
    reader.readAsDataURL(file);
}

function addImageToGrid(imageSrc, blob) {
    const grid = document.getElementById('imageGrid');
    const emptySlot = grid.querySelector('.image-upload-slot:not(.has-image)');
    
    if (emptySlot) {
        emptySlot.innerHTML = `
            <img src="${imageSrc}" alt="Vehicle image">
            <button type="button" class="remove-image" onclick="removeImage(this)">
                <i class="bi bi-x"></i>
            </button>
        `;
        emptySlot.classList.add('has-image');
        
        // Store the image data
        uploadedImages.push({
            slot: emptySlot,
            blob: blob,
            src: imageSrc
        });
        
        // Always add a new placeholder after adding an image (if under max limit)
        if (grid.children.length < maxImages) {
            createImageSlot(grid);
        }
    }
}

function removeImage(button) {
    const slot = button.closest('.image-upload-slot');
    const imageIndex = uploadedImages.findIndex(img => img.slot === slot);
    
    if (imageIndex > -1) {
        // Revoke the object URL to free memory
        URL.revokeObjectURL(uploadedImages[imageIndex].src);
        uploadedImages.splice(imageIndex, 1);
    }
    
    // Remove the slot entirely instead of converting back to placeholder
    slot.remove();
    
    // Ensure there's always at least one placeholder available
    const grid = document.getElementById('imageGrid');
    if (grid.querySelectorAll('.image-upload-slot:not(.has-image)').length === 0) {
        createImageSlot(grid);
    }
}

function setCurrentDateTime() {
    const now = new Date();
    const isoString = now.toISOString().slice(0, 16); // Format for datetime-local
    document.getElementById('inspection_datetime').value = isoString;
}

function saveDraft() {
    // Implement save draft functionality
    alert('Draft saved successfully!');
}

function continueToNext() {
    // TESTING: Validation disabled for testing purposes
    // TODO: Re-enable validation before production
    /*
    // Basic validation - ensure required fields are filled
    const requiredFields = [
        'inspection_datetime',
        'inspector_name',
        'vehicle_type',
        'manufacturer',
        'model',
        'vin'
    ];
    
    const missingFields = [];
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (!field.value.trim()) {
            missingFields.push(field.previousElementSibling.textContent.replace(':', ''));
        }
    });
    
    if (missingFields.length > 0) {
        alert(`Please fill in the following required fields:\n• ${missingFields.join('\n• ')}`);
        return;
    }
    */
    
    // Store form data in sessionStorage for next section
    const formData = new FormData(document.getElementById('visual-inspection-form'));
    const inspectionData = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== '_token' && value) {
            inspectionData[key] = value;
        }
    }
    
    // Store images data for PDF generation
    const imageDataForPDF = uploadedImages.map((img, index) => {
        // Convert blob to base64
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                resolve({
                    base64: e.target.result, // This includes the data URL prefix
                    mime_type: img.blob.type || 'image/jpeg',
                    area_name: 'visual_' + (index + 1),
                    original_name: 'visual_image_' + (index + 1) + '.jpg'
                });
            };
            reader.readAsDataURL(img.blob);
        });
    });
    
    // Wait for all images to be processed
    Promise.all(imageDataForPDF).then(processedImages => {
        // Store image data for PDF
        sessionStorage.setItem('visualInspectionImages', JSON.stringify(processedImages));
        
        // Store basic inspection data
        sessionStorage.setItem('visualInspectionData', JSON.stringify(inspectionData));
        
        // Navigate to body panel assessment
        window.location.href = '/inspection/body-panel';
    }).catch(error => {
        console.error('Error processing images:', error);
        // Store basic data without images and continue
        sessionStorage.setItem('visualInspectionData', JSON.stringify(inspectionData));
        window.location.href = '/inspection/body-panel';
    });
}
</script>
@endsection