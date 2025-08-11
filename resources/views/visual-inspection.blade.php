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
            <button type="button" class="btn btn-info me-3" onclick="testVisualReport()">
                Test Report View
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
    // Check if this is a new inspection (coming from dashboard or direct URL)
    // Clear data only if not coming from within the inspection flow
    const referrer = document.referrer;
    const isFromInspectionFlow = referrer.includes('/inspection/');
    const hasInspectionId = sessionStorage.getItem('currentInspectionId');
    
    // If not from inspection flow and no current inspection ID, start fresh
    if (!isFromInspectionFlow && !hasInspectionId) {
        // Starting a new inspection - clear all data
        sessionStorage.removeItem('visualInspectionData');
        sessionStorage.removeItem('visualInspectionImages');
        sessionStorage.removeItem('bodyPanelAssessmentData');
        sessionStorage.removeItem('bodyPanelAssessmentImages');
        sessionStorage.removeItem('interiorAssessmentData');
        
        // Set a new inspection ID
        const newInspectionId = 'inspection_' + Date.now();
        sessionStorage.setItem('currentInspectionId', newInspectionId);
    }
    
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

// Show notification function
function showNotification(message, type = 'info') {
    // Create or update notification element
    let notification = document.getElementById('notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 9999;
            display: none;
            max-width: 300px;
            color: white;
            font-weight: 500;
        `;
        document.body.appendChild(notification);
    }

    // Set color based on type
    const colors = {
        success: '#28a745',
        warning: '#ffc107',
        error: '#dc3545',
        info: '#4f959b'
    };
    
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    notification.style.display = 'block';

    // Auto hide after 3 seconds
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
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
    
    // Handle PDF file separately (same as testVisualReport)
    let hasPdfFile = false;
    for (let [key, value] of formData.entries()) {
        if (key === 'diagnostic_file' && value instanceof File && value.size > 0) {
            hasPdfFile = true;
            // Convert PDF file to base64 (same as testVisualReport)
            const reader = new FileReader();
            reader.onload = function(e) {
                inspectionData.diagnostic_file_data = e.target.result;
                inspectionData.diagnostic_file_name = value.name;
                inspectionData.diagnostic_file_size = value.size;
                console.log('PDF file captured for sessionStorage:', value.name);
                // Continue with the rest of the processing
                processContinueToNext();
            };
            reader.readAsDataURL(value);
            return; // Wait for PDF file to be processed
        } else if (key !== '_token' && key !== 'diagnostic_file') {
            inspectionData[key] = value || '';
        }
    }
    
    // If no PDF file, continue immediately
    if (!hasPdfFile) {
        processContinueToNext();
    }
    
    function processContinueToNext() {
    
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
    Promise.all(imageDataForPDF).then(async (processedImages) => {
        // Store image data for PDF (keep for compatibility)
        sessionStorage.setItem('visualInspectionImages', JSON.stringify(processedImages));
        
        // Store basic inspection data (keep for compatibility)
        sessionStorage.setItem('visualInspectionData', JSON.stringify(inspectionData));
        
        // Save to database
        try {
            console.log('Saving visual inspection to database...');
            
            // Prepare form data for API - add missing fields
            const apiData = {
                ...inspectionData,
                images: processedImages
            };
            
            const response = await fetch('/api/inspection/visual', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(apiData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                console.log('Visual inspection saved successfully. Inspection ID:', result.inspection_id);
                // Store inspection ID for later use
                sessionStorage.setItem('currentInspectionId', result.inspection_id);
                
                // Show success message
                showNotification('Visual inspection saved to database successfully!', 'success');
                
                // Navigate after short delay
                setTimeout(() => {
                    window.location.href = '/inspection/body-panel';
                }, 1500);
            } else {
                throw new Error(result.message || 'Failed to save inspection');
            }
        } catch (error) {
            console.error('Database save failed:', error);
            showNotification('Warning: Data saved locally only. Database save failed.', 'warning');
            
            // Navigate anyway after delay
            setTimeout(() => {
                window.location.href = '/inspection/body-panel';
            }, 2500);
        }
    }).catch(error => {
        console.error('Error processing images:', error);
        // Store basic data without images and continue
        sessionStorage.setItem('visualInspectionData', JSON.stringify(inspectionData));
        
        // Try to save without images
        fetch('/api/inspection/visual', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                ...inspectionData,
                images: []
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('Visual inspection saved without images');
                sessionStorage.setItem('currentInspectionId', result.inspection_id);
                showNotification('Visual inspection saved (without images)', 'success');
            }
        })
        .catch(err => {
            console.error('Failed to save to database:', err);
            showNotification('Warning: Data saved locally only', 'warning');
        })
        .finally(() => {
            // Navigate regardless
            setTimeout(() => {
                window.location.href = '/inspection/body-panel';
            }, 2000);
        });
    });
    
    } // End of processContinueToNext function
}

// Test Visual Report with current form data
function testVisualReport() {
    console.log('testVisualReport function called');
    
    // Get current form data
    const formData = new FormData(document.getElementById('visual-inspection-form'));
    const visualData = {};
    
    console.log('Form data collected, processing...');
    
    // Convert FormData to object
    for (let [key, value] of formData.entries()) {
        // Handle file inputs separately
        if (key === 'diagnostic_file' && value instanceof File && value.size > 0) {
            // Convert PDF file to base64
            const reader = new FileReader();
            reader.onload = function(e) {
                visualData.diagnostic_file_data = e.target.result;
                visualData.diagnostic_file_name = value.name;
                visualData.diagnostic_file_size = value.size;
                console.log('PDF file captured:', value.name);
                continueProcesing();
            };
            reader.readAsDataURL(value);
            return; // Wait for file to be read
        } else if (key !== 'diagnostic_file') {
            visualData[key] = value;
        }
    }
    
    // Debug: Log the data being sent
    console.log('Form data being sent:', visualData);
    continueProcesing();
    
    function continueProcesing() {
    
    // Get images from sessionStorage (if any)
    const storedImages = sessionStorage.getItem('visualInspectionImages');
    console.log('Raw stored images:', storedImages);
    
    const imageData = storedImages ? JSON.parse(storedImages) : [];
    console.log('Parsed image data:', imageData);
    
    // Check if we have current uploaded images that aren't in sessionStorage yet
    if (uploadedImages.length > 0) {
        console.log('Using current uploadedImages:', uploadedImages.length);
        // Convert current images to base64 for the test
        const currentImagePromises = uploadedImages.map(img => {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    resolve(e.target.result);
                };
                reader.readAsDataURL(img.blob);
            });
        });
        
        Promise.all(currentImagePromises).then(base64Images => {
            visualData.images = base64Images;
            console.log('Base64 images ready:', base64Images.length);
            submitTestForm();
        });
        return; // Exit early to wait for images
    }
    
    // Add images to the data
    if (imageData.length > 0) {
        visualData.images = imageData;
        console.log('Images found in storage:', imageData.length);
    }
    
    submitTestForm();
    } // End of continueProcesing
    
    function submitTestForm() {
        console.log('Creating form for submission...');
        
        // Create a form to POST to the test endpoint
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/test/visual-report';
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token meta tag not found!');
            alert('Error: CSRF token not found. Please refresh the page.');
            return;
        }
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken.getAttribute('content');
        form.appendChild(csrfInput);
        
        console.log('CSRF token added:', csrfInput.value);
        
        // Add visual data
        const dataInput = document.createElement('input');
        dataInput.type = 'hidden';
        dataInput.name = 'visualData';
        dataInput.value = JSON.stringify(visualData);
        form.appendChild(dataInput);
        
        // Submit to open in same window
        document.body.appendChild(form);
        console.log('Form appended to body, submitting...');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        console.log('Number of form inputs:', form.elements.length);
        
        try {
            form.submit();
            console.log('Form submitted successfully!');
        } catch (error) {
            console.error('Error submitting form:', error);
            alert('Error submitting form: ' + error.message);
        }
    }
}
</script>
@endsection