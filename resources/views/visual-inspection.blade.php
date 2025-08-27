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
                        <input type="text" class="form-control" id="inspector_name" name="inspector_name" 
                               value="{{ Auth::user()->name }}" 
                               placeholder="Inspector name" 
                               @if(!Auth::user()->isAdmin()) readonly @endif>
                        @if(!Auth::user()->isAdmin())
                            <div class="form-text">Inspector name is automatically set from your login</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Images Section -->
        <div class="form-section">
            <h3>Vehicle Images</h3>
            <p class="text-muted mb-3">Take photos of the vehicle using your tablet camera.</p>
            
            <!-- Camera button without any wrapper boxes -->
            <div class="mb-3">
                <button type="button" class="photo-btn btn btn-outline-primary" data-panel="visual">
                    <i class="bi bi-camera-fill"></i> Take Photo
                </button>
                <input type="file" accept="image/*" capture="environment" 
                       class="d-none camera-input" id="camera-visual">
            </div>
            
            <!-- Image gallery for captured photos -->
            <div class="image-gallery" id="gallery-visual" style="display: none;">
                <!-- Images will be added here -->
            </div>
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
                        <input type="number" class="form-control" id="year_model" name="year_model" min="1900" max="2026">
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
        <div class="button-group-responsive text-center mb-4">
            <button type="button" class="btn btn-secondary me-2 mb-2" onclick="saveDraft()">
                Save Draft
            </button>
            <button type="button" class="btn btn-primary mb-2" onclick="continueToNext()">
                Continue to Next Section
            </button>
        </div>
    </form>
</div>
@endsection

@section('additional-css')
<style>
/* Button responsive layout for tablets */
@media (max-width: 768px) {
    .button-group-responsive {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 5px;
    }
    
    .button-group-responsive .btn {
        width: 100%;
        margin-right: 0 !important;
    }
}

/* Consistent Image Modal Styles */
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
}

.image-modal-content {
    margin: auto;
    display: block;
    width: 90%;
    max-width: 700px;
    max-height: 90%;
    object-fit: contain;
    animation: zoom 0.6s;
}

.image-modal-close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    cursor: pointer;
}

.image-modal-close:hover,
.image-modal-close:focus {
    color: #bbb;
}

@keyframes zoom {
    from { transform: scale(0) }
    to { transform: scale(1) }
}

/* Gallery styles */
.image-gallery {
    margin-top: 15px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f8f9fa;
}

.captured-image {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.captured-image:hover {
    transform: translateY(-2px);
}
</style>
@endsection

@section('additional-js')
<!-- Include consistent camera technology -->
<script src="/js/inspection-cards.js"></script>
<script>
// Image management
const maxImages = 20; // Maximum number of images allowed
let imageCount = 0;
let uploadedImages = [];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Check if continuing an existing inspection from dashboard
    const urlParams = new URLSearchParams(window.location.search);
    const continueInspectionId = urlParams.get('continue');
    
    if (continueInspectionId) {
        // Continuing existing inspection
        console.log('Continuing inspection ID:', continueInspectionId);
        sessionStorage.setItem('currentInspectionId', continueInspectionId);
        
        @if(isset($inspection))
        // Load inspection data from server
        const inspectionData = @json($inspection);
        console.log('Loading inspection data:', inspectionData);
        
        // Populate form fields
        if (inspectionData.inspection_date) {
            const date = new Date(inspectionData.inspection_date);
            document.getElementById('inspection_datetime').value = date.toISOString().slice(0, 16);
        }
        if (inspectionData.inspector_name) {
            document.getElementById('inspector_name').value = inspectionData.inspector_name;
        }
        if (inspectionData.client && inspectionData.client.name) {
            document.getElementById('client_name').value = inspectionData.client.name;
        }
        if (inspectionData.vehicle) {
            const vehicle = inspectionData.vehicle;
            if (vehicle.vin) document.getElementById('vin').value = vehicle.vin;
            if (vehicle.manufacturer) document.getElementById('manufacturer').value = vehicle.manufacturer;
            if (vehicle.model) document.getElementById('model').value = vehicle.model;
            if (vehicle.vehicle_type) document.getElementById('vehicle_type').value = vehicle.vehicle_type;
            if (vehicle.colour) document.getElementById('colour').value = vehicle.colour;
            if (vehicle.doors) document.getElementById('doors').value = vehicle.doors;
            if (vehicle.fuel_type) document.getElementById('fuel_type').value = vehicle.fuel_type;
            if (vehicle.transmission) document.getElementById('transmission').value = vehicle.transmission;
            if (vehicle.engine_number) document.getElementById('engine_number').value = vehicle.engine_number;
            if (vehicle.registration_number) document.getElementById('registration_number').value = vehicle.registration_number;
            if (vehicle.year) document.getElementById('year_model').value = vehicle.year;
            if (vehicle.mileage) document.getElementById('km_reading').value = vehicle.mileage;
        }
        @endif
    } else {
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
            sessionStorage.removeItem('interiorAssessmentImages');
            sessionStorage.removeItem('serviceBookletData');
            sessionStorage.removeItem('tyresRimsData');
            sessionStorage.removeItem('tyresRimsAssessmentData');
            sessionStorage.removeItem('mechanicalReportData');
            sessionStorage.removeItem('engineCompartmentData');
            sessionStorage.removeItem('physicalHoistData');
            
            // Set a new inspection ID
            const newInspectionId = 'inspection_' + Date.now();
            sessionStorage.setItem('currentInspectionId', newInspectionId);
        }
    }
    
    initializeImageGrid();
    initializeConsistentCamera(); // Add consistent camera functionality
    setCurrentDateTime();
});

function initializeImageGrid() {
    // Image grid now handled by consistent camera technology only
    // No need to create placeholder slots
}

// Old camera functions removed - now using consistent camera technology

function setCurrentDateTime() {
    // Get current time in South African timezone
    const now = new Date();
    const saTime = new Date(now.toLocaleString("en-US", {timeZone: "Africa/Johannesburg"}));
    
    // Format for datetime-local input (YYYY-MM-DDTHH:MM)
    const year = saTime.getFullYear();
    const month = String(saTime.getMonth() + 1).padStart(2, '0');
    const day = String(saTime.getDate()).padStart(2, '0');
    const hours = String(saTime.getHours()).padStart(2, '0');
    const minutes = String(saTime.getMinutes()).padStart(2, '0');
    
    const saTimeString = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    document.getElementById('inspection_datetime').value = saTimeString;
    console.log('✅ Current South African time set:', saTimeString);
}

// Initialize consistent camera functionality like other pages
function initializeConsistentCamera() {
    // Create modal if it doesn't exist (from inspection-cards.js)
    if (!document.getElementById('imageModal')) {
        const modal = document.createElement('div');
        modal.id = 'imageModal';
        modal.className = 'image-modal';
        modal.innerHTML = `
            <span class="image-modal-close">&times;</span>
            <img class="image-modal-content" id="modalImage">
        `;
        document.body.appendChild(modal);
        
        // Modal close handlers
        modal.querySelector('.image-modal-close').onclick = function() {
            modal.style.display = 'none';
        };
        
        window.onclick = function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        };
    }
    
    // Photo button click handler - consistent with other pages
    document.addEventListener('click', function(e) {
        if (e.target.closest('.photo-btn')) {
            const btn = e.target.closest('.photo-btn');
            const panelId = btn.dataset.panel;
            const fileInput = document.getElementById(`camera-${panelId}`);
            if (fileInput) {
                console.log('📷 Triggering camera for panel:', panelId);
                fileInput.click();
            }
        }
    });
    
    // File input change handler - consistent with other pages
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('camera-input')) {
            const file = e.target.files[0];
            if (file) {
                const panelId = e.target.id.replace('camera-', '');
                console.log('📸 Processing image for panel:', panelId);
                processConsistentImage(file, panelId);
            }
            // Clear input for reuse
            e.target.value = '';
        }
    });
}

// Process images using consistent approach
function processConsistentImage(file, panelId) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const imageData = e.target.result;
        const imageId = `${panelId}-${Date.now()}`;
        
        const imageInfo = {
            id: imageId,
            data: imageData,
            blob: file,
            src: imageData,
            slot: null, // For compatibility with existing code
            timestamp: new Date().toISOString(),
            area_name: 'Visual Inspection'
        };
        
        uploadedImages.push(imageInfo); // For compatibility with existing code
        
        // Display the image in gallery
        displayConsistentImage(imageInfo, panelId);
        
        console.log('✅ CONSISTENT CAMERA IMAGE CAPTURED! Total images now:', uploadedImages.length);
    };
    
    reader.readAsDataURL(file);
}

// Display images consistently
function displayConsistentImage(imageInfo, panelId) {
    const gallery = document.getElementById(`gallery-${panelId}`);
    
    if (gallery) {
        gallery.style.display = 'block';
        
        const imageContainer = document.createElement('div');
        imageContainer.className = 'captured-image';
        imageContainer.dataset.imageId = imageInfo.id;
        imageContainer.style.cssText = `
            display: inline-block;
            margin: 10px;
            position: relative;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        `;
        
        imageContainer.innerHTML = `
            <img src="${imageInfo.data}" alt="Visual inspection image" 
                 onclick="openImageModal('${imageInfo.data}')"
                 style="width: 150px; height: 150px; object-fit: cover; cursor: pointer; display: block;">
            <button type="button" class="remove-image-btn" onclick="removeConsistentImage('${imageInfo.id}', '${panelId}')"
                    style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-x"></i>
            </button>
            <div class="image-timestamp" style="padding: 5px; font-size: 10px; text-align: center; background: #f8f9fa;">
                ${new Date(imageInfo.timestamp).toLocaleString()}
            </div>
        `;
        
        gallery.appendChild(imageContainer);
        
        // Images captured - main photo button remains available for more photos
    }
}

// Function removed - single photo button handles all captures

// Remove images consistently
function removeConsistentImage(imageId, panelId) {
    // Remove from data arrays
    uploadedImages = uploadedImages.filter(img => img.id !== imageId);
    
    // Remove from DOM
    const imageContainer = document.querySelector(`[data-image-id="${imageId}"]`);
    if (imageContainer) {
        imageContainer.remove();
    }
    
    // Hide gallery if no images
    const gallery = document.getElementById(`gallery-${panelId}`);
    if (gallery && gallery.children.length === 0) {
        gallery.style.display = 'none';
    }
    
    console.log('🗑️ CONSISTENT CAMERA IMAGE REMOVED! Total images now:', uploadedImages.length);
}

// Modal functionality
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    if (modal && modalImg) {
        modal.style.display = 'block';
        modalImg.src = imageSrc;
    }
}

function saveDraft() {
    // Implement save draft functionality
    notify.draft('Draft saved successfully!');
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
        notify.warning(`Please fill in the following required fields:\n• ${missingFields.join('\n• ')}`, { duration: 8000 });
        return;
    }
    */
    
    // Store form data in sessionStorage for next section
    const formData = new FormData(document.getElementById('visual-inspection-form'));
    const inspectionData = {};
    
    // Process all form fields first
    for (let [key, value] of formData.entries()) {
        if (key !== '_token' && key !== 'diagnostic_file') {
            // Convert numeric fields to proper types
            if (key === 'km_reading' || key === 'year_model') {
                // Parse the value and validate it's actually a number
                const numValue = parseInt(value);
                if (!isNaN(numValue)) {
                    inspectionData[key] = numValue;
                } else {
                    inspectionData[key] = null;
                }
                // Log for debugging
                console.log(`Field ${key}: raw="${value}", parsed=${inspectionData[key]}`);
            } else {
                inspectionData[key] = value || '';
            }
        }
    }

    // Handle PDF file separately
    let hasPdfFile = false;
    const diagnosticFileInput = formData.get('diagnostic_file');
    if (diagnosticFileInput instanceof File && diagnosticFileInput.size > 0) {
        hasPdfFile = true;
        console.log('📄 Processing PDF file:', diagnosticFileInput.name);
        // Convert PDF file to base64
        const reader = new FileReader();
        reader.onload = function(e) {
            inspectionData.diagnostic_file_data = e.target.result;
            inspectionData.diagnostic_file_name = diagnosticFileInput.name;
            inspectionData.diagnostic_file_size = diagnosticFileInput.size;
            console.log('✅ PDF FILE CAPTURED:', diagnosticFileInput.name, '(' + diagnosticFileInput.size + ' bytes)');
            // Continue with the rest of the processing
            processContinueToNext();
        };
        reader.readAsDataURL(diagnosticFileInput);
        return; // Wait for PDF file to be processed
    }
    
    // If no PDF file, continue immediately
    if (!hasPdfFile) {
        console.log('📋 No PDF file detected, continuing with form data only');
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
            
            // Add inspection_id if continuing an existing inspection
            const currentInspectionId = sessionStorage.getItem('currentInspectionId');
            if (currentInspectionId) {
                // Check if it's a numeric ID (continuing from dashboard) or session-generated ID
                if (!currentInspectionId.startsWith('inspection_')) {
                    // This is a numeric database ID - we're continuing an existing inspection
                    apiData.inspection_id = currentInspectionId;
                    console.log('Continuing existing inspection with ID:', currentInspectionId);
                } else {
                    console.log('Creating new inspection with session ID:', currentInspectionId);
                }
            }
            
            console.log('API Data being sent:', apiData);
            console.log('Images in API data:', apiData.images ? apiData.images.length : 'NO IMAGES ARRAY');
            console.log('uploadedImages array:', uploadedImages.length);
            console.log('PDF data in API:', {
                hasPdfData: !!apiData.diagnostic_file_data,
                pdfName: apiData.diagnostic_file_name,
                pdfSize: apiData.diagnostic_file_size
            });
            
            const response = await fetch('{{ url('/api/inspection/visual') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(apiData)
            });
            
            console.log('=== API RESPONSE DEBUG ===');
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            console.log('Response headers:', Array.from(response.headers.entries()));
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('API Error Response:', errorText);
                console.error('Failed request data:', {
                    url: '{{ url('/api/inspection/visual') }}',
                    method: 'POST',
                    dataKeys: Object.keys(apiData),
                    hasImages: !!apiData.images,
                    hasPDF: !!apiData.diagnostic_file_data
                });
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }
            
            const result = await response.json();
            console.log('Raw API Response:', result);
            console.log('Success value:', result.success, '(type:', typeof result.success, ')');
            
            if (result.success === true || result.success === 1 || result.success === '1') {
                console.log('✅ SUCCESS CONDITION MET - Visual inspection saved successfully!');
                console.log('Inspection ID:', result.inspection_id);
                // Store inspection ID for later use
                sessionStorage.setItem('currentInspectionId', result.inspection_id);
                
                // Show success message
                showNotification('Visual inspection saved to database successfully!', 'success');
                
                // Navigate after short delay
                setTimeout(() => {
                    window.location.href = '/inspection/body-panel';
                }, 1500);
            } else {
                console.error('Unexpected success value:', result.success, typeof result.success);
                throw new Error(result.message || 'Failed to save inspection - unexpected response format');
            }
        } catch (error) {
            console.error('Database save failed:', error);
            console.error('Error details:', error.message);
            console.error('API response:', error);
            
            // Clear any potentially corrupted data
            if (error.message && error.message.includes('year_model') && error.message.includes('must not be greater')) {
                console.error('Year model validation error detected. Check the year_model field value.');
                const yearInput = document.getElementById('year_model');
                if (yearInput) {
                    console.log('Current year_model input value:', yearInput.value);
                }
            }
            
            showNotification('Warning: Data saved locally only. Database save failed. Check console for details.', 'warning');
            
            // Navigate anyway after delay
            setTimeout(() => {
                window.location.href = '/inspection/body-panel';
            }, 2500);
        }
    }).catch(error => {
        console.error('Error processing images:', error);
        // Store basic data without images and continue
        sessionStorage.setItem('visualInspectionData', JSON.stringify(inspectionData));
        
        // Prepare fallback data with inspection_id if continuing
        const fallbackData = {
            ...inspectionData,
            images: []
        };
        
        const currentInspectionId = sessionStorage.getItem('currentInspectionId');
        if (currentInspectionId && !currentInspectionId.startsWith('inspection_')) {
            // This is a numeric database ID - we're continuing an existing inspection
            fallbackData.inspection_id = currentInspectionId;
        }
        
        // Try to save without images
        fetch('{{ url('/api/inspection/visual') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(fallbackData)
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

</script>
@endsection