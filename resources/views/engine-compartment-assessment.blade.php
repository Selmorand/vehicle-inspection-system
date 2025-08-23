@extends('layouts.app')

@section('title', 'Engine Compartment Assessment')

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
                    <li class="breadcrumb-item"><a href="/inspection/tyres-rims" style="color: var(--primary-color);">Tyres & Rims Assessment</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/mechanical-report" style="color: var(--primary-color);">Mechanical Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Engine Compartment</li>
                    <li class="breadcrumb-item text-muted" id="nextStepBreadcrumb">Physical Hoist</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Engine Compartment Assessment</h2>
        <p class="text-muted">Document engine compartment findings, capture images, and assess component conditions</p>
    </div>

    <form id="engineCompartmentForm">
        @csrf
        
        <!-- Section 1: Inspection Findings & Observations -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Engine compartment:</h5>
                    </div>
                    <div class="card-body">
                        <!-- Engine Number Verification -->
                        <div class="finding-section mb-4">
                            <h6 class="fw-bold text-primary mb-3">Engine Number Verification</h6>
                            <div class="mb-2">
                                <label class="form-label" for="engineNumberInput">
                                    Engine number verification (enter notes below):
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="engineNumberInput" 
                                       name="findings[engine_number_input]" 
                                       placeholder="Enter engine number verification details...">
                            </div>
                        </div>

                        <!-- General Engine Compartment Inspection -->
                        <div class="finding-section mb-4">
                            <h6 class="fw-bold text-primary mb-3">General Engine Compartment Inspection</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="noDeficiencies" name="findings[no_deficiencies]" value="1">
                                <label class="form-check-label" for="noDeficiencies">
                                    "During the inspection of the Engine Compartment, no deficiencies were detected"
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="noStructuralDamage" name="findings[no_structural_damage]" value="1">
                                <label class="form-check-label" for="noStructuralDamage">
                                    "During the inspection no structural damage was visible/found"
                                </label>
                            </div>
                            <div class="additional-notes-container" id="generalInspectionNotes" style="display: none;">
                                <textarea class="form-control mt-2" name="findings[general_inspection_notes]" rows="2" 
                                          placeholder="Additional findings or observations..."></textarea>
                            </div>
                        </div>

                        <!-- Component Presence Assessment -->
                        <div class="finding-section mb-4">
                            <h6 class="fw-bold text-primary mb-3">Component Presence Assessment</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="engineCoversPartial" name="findings[engine_covers_partial]" value="1">
                                <label class="form-check-label" for="engineCoversPartial">
                                    "Engine covers are partially present"
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="undercarriageMissing" name="findings[undercarriage_missing]" value="1">
                                <label class="form-check-label" for="undercarriageMissing">
                                    "undercarriage was not present on the vehicle, replacement suggested"
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="engineCoversAbsent" name="findings[engine_covers_absent]" value="1">
                                <label class="form-check-label" for="engineCoversAbsent">
                                    "engine covers not present at all"
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="headlightRepairs" name="findings[headlight_repairs]" value="1">
                                <label class="form-check-label" for="headlightRepairs">
                                    "Previous repairs/damages has been found on headlights/headlight brackets"
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="fenderlinerDamages" name="findings[fenderliner_damages]" value="1">
                                <label class="form-check-label" for="fenderlinerDamages">
                                    "All fenderliners were present during the inspection but damages has been found"
                                </label>
                            </div>
                            <div class="additional-notes-container" id="componentPresenceNotes" style="display: none;">
                                <textarea class="form-control mt-2" name="findings[component_presence_notes]" rows="2" 
                                          placeholder="Additional observations regarding component presence..."></textarea>
                            </div>
                        </div>

                        <!-- Additional Engine Compartment Images -->
                        <div class="finding-section mb-4">
                            <h6 class="fw-bold text-primary mb-3">Additional Engine Compartment Images</h6>
                            <p class="text-muted mb-3">Capture additional photos of the engine compartment with captions.</p>
                            
                            <!-- Camera button without any wrapper boxes -->
                            <div class="mb-3">
                                <button type="button" class="additional-photo-btn btn btn-outline-primary" data-panel="engine-additional">
                                    <i class="bi bi-camera-fill"></i> Take Photo
                                </button>
                                <input type="file" accept="image/*" capture="environment" 
                                       class="d-none additional-camera-input" id="camera-engine-additional">
                            </div>
                            
                            <!-- Image gallery for captured photos -->
                            <div class="image-gallery" id="gallery-engine-additional" style="display: none;">
                                <!-- Images will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Engine Component Overview Check -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Overview check:</h5>
                        <small class="text-light">Assess engine component conditions - colors will update automatically</small>
                    </div>
                    <div class="card-body">
                        <!-- Dynamic engine component assessments will be generated by JavaScript -->
                        <div id="engineComponentAssessments">
                            <!-- Component cards will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Action buttons -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" id="backBtn">
                        <i class="bi bi-arrow-left me-1"></i>Back to Mechanical Report
                    </button>
                    <div class="button-group-responsive">
                        <button type="button" class="btn btn-secondary me-2 mb-2" id="saveDraftBtn">Save Draft</button>
                        <button type="button" class="btn btn-success mb-2" id="completeConditionBtn" style="display: none;">
                            <i class="bi bi-check-circle me-1"></i>Complete Condition Report
                        </button>
                        <button type="button" class="btn btn-primary mb-2" id="continueTechnicalBtn" style="display: none;">
                            Continue to Physical Hoist Inspection <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('additional-css')
<link rel="stylesheet" href="{{ asset('css/panel-cards.css') }}">
<style>
/* Engine Component Assessment specific styling */
#engineComponentAssessments .panel-controls {
    display: grid;
    grid-template-columns: 1fr 2fr auto;
    gap: 10px;
    align-items: start;
}

#engineComponentAssessments .form-field-group {
    display: flex;
    flex-direction: column;
}

#engineComponentAssessments .field-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 4px;
    text-align: center;
    background-color: #b8dae0;
    padding: 4px 8px;
    border-radius: 3px;
}

#engineComponentAssessments .form-control {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 6px 8px;
    font-size: 14px;
}

#engineComponentAssessments .photo-btn {
    align-self: end;
    margin-bottom: 0;
}

/* Condition-based color coding for dropdowns */
select[name$="-condition"] {
    transition: background-color 0.3s ease, color 0.3s ease;
}

select[name$="-condition"][value="good"] {
    background-color: #28a745 !important;
    color: white !important;
}

select[name$="-condition"][value="average"] {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

select[name$="-condition"][value="bad"] {
    background-color: #dc3545 !important;
    color: white !important;
}

select[name$="-condition"][value="n/a"] {
    background-color: #6c757d !important;
    color: white !important;
}

/* Responsive design for tablets */
@media (max-width: 768px) {
    #engineComponentAssessments .panel-controls {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    #engineComponentAssessments .field-label {
        text-align: left;
    }
    
    #engineComponentAssessments .form-control {
        text-align: left;
    }
    
    /* Button responsive layout for tablets */
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
    
    .mt-4.d-flex.justify-content-between {
        flex-direction: column !important;
        gap: 10px;
    }
}

/* Engine Compartment Assessment Styling */
.finding-section {
    border-left: 4px solid var(--primary-color);
    padding-left: 15px;
}

.finding-checkbox {
    transform: scale(1.2);
    margin-right: 10px;
}

.form-check-label {
    font-size: 14px;
    line-height: 1.4;
    margin-left: 5px;
}

.additional-notes-container {
    margin-left: 25px;
    animation: slideDown 0.3s ease-in-out;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}


/* Progress indicators */
.progress {
    background-color: #e9ecef;
    border-radius: 4px;
}

/* Responsive design */
@media (max-width: 991px) {
    .table-responsive {
        font-size: 14px;
    }
    
    .finding-section {
        padding-left: 10px;
    }
}

@media (max-width: 768px) {
    .table {
        font-size: 12px;
    }
    
    .form-check-label {
        font-size: 13px;
    }
}

/* Alert styling */
.alert-info {
    background-color: #e8f4f8;
    border-color: var(--primary-color);
    color: var(--text-color);
}

/* Additional Engine Compartment Images Gallery Styles */
.image-gallery {
    margin-top: 15px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f8f9fa;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.captured-image {
    border: 2px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    width: 200px;
}

.captured-image:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.captured-image img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    cursor: pointer;
    display: block;
}

.image-caption-input {
    padding: 8px;
    border: none;
    border-top: 1px solid #ddd;
    width: 100%;
    font-size: 12px;
}

.remove-image-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.remove-image-btn:hover {
    background: rgba(220, 53, 69, 1);
}

/* Image Modal Styles */
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
</style>
@endsection

@section('additional-js')
<script src="{{ asset('js/inspection-cards.js') }}"></script>
<script>
// Engine compartment assessment data storage
let engineCompartmentData = {
    findings: {},
    components: {}
};

let totalFindings = 7;

// Store additional images with captions
let additionalEngineImages = [];

document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Initialize finding checkboxes
    initializeFindingCheckboxes();
    
    // Initialize engine component assessments using InspectionCards
    initializeEngineComponents();
    
    // Initialize additional images capture functionality
    initializeAdditionalImages();
    
    // Show appropriate navigation button based on inspection type
    setupNavigationButtons();
    
    // Add color coding for condition dropdowns
    document.addEventListener('change', function(e) {
        if (e.target.name && e.target.name.endsWith('-condition')) {
            const select = e.target;
            // Set the value attribute for CSS selector
            select.setAttribute('value', select.value);
        }
    });

    // REMOVED manual form submission handler - InspectionCards handles this

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        saveCurrentProgress();
        window.location.href = '/inspection/mechanical-report';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        InspectionCards.saveData();
        
        // Show success notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px; padding: 15px 20px;
            background: #ffc107; color: white; border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
            font-weight: 500;
        `;
        notification.textContent = 'Draft saved successfully!';
        document.body.appendChild(notification);

        setTimeout(() => notification.remove(), 3000);
    });

});

// Function to initialize engine components with InspectionCards
// Initialize additional images capture functionality
function initializeAdditionalImages() {
    // Create modal if it doesn't exist
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
    
    // Photo button click handler for additional images only
    document.addEventListener('click', function(e) {
        if (e.target.closest('.additional-photo-btn')) {
            e.preventDefault();
            e.stopPropagation();
            const fileInput = document.getElementById('camera-engine-additional');
            if (fileInput) {
                console.log('Triggering camera for additional engine images');
                fileInput.click();
            }
        }
    });
    
    // File input change handler
    const fileInput = document.getElementById('camera-engine-additional');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    e.target.value = '';
                    return;
                }
                // Validate file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Image file is too large. Maximum size is 10MB.');
                    e.target.value = '';
                    return;
                }
                processAdditionalImage(file);
                // Clear input AFTER processing to allow reuse
                setTimeout(() => {
                    e.target.value = '';
                }, 100);
            }
        });
    }
}

// Process additional images
function processAdditionalImage(file) {
    try {
        console.log('Processing additional engine image:', file.name, file.size);
        const reader = new FileReader();
        
        reader.onload = function(e) {
            try {
                const imageData = e.target.result;
                const imageId = `engine-additional-${Date.now()}`;
                
                const imageInfo = {
                    id: imageId,
                    data: imageData,
                    caption: '', // Will be filled by user
                    timestamp: new Date().toISOString()
                };
                
                additionalEngineImages.push(imageInfo);
                console.log('Image processed, displaying:', imageId);
                displayAdditionalImage(imageInfo);
            } catch (error) {
                console.error('Error processing image data:', error);
                if (typeof notify !== 'undefined' && notify.error) {
                    notify.error('Error processing image. Please try again.');
                } else {
                    console.error('Error processing image:', error);
                }
            }
        };
        
        reader.onerror = function(error) {
            console.error('FileReader error:', error);
            if (typeof notify !== 'undefined' && notify.error) {
                notify.error('Error reading image file. Please try again.');
            }
        };
        
        reader.readAsDataURL(file);
    } catch (error) {
        console.error('Error in processAdditionalImage:', error);
        if (typeof notify !== 'undefined' && notify.error) {
            notify.error('Error processing image: ' + error.message);
        }
    }
}

// Display additional images with caption input
function displayAdditionalImage(imageInfo) {
    const gallery = document.getElementById('gallery-engine-additional');
    
    if (gallery) {
        gallery.style.display = 'flex';
        
        const imageContainer = document.createElement('div');
        imageContainer.className = 'captured-image';
        imageContainer.dataset.imageId = imageInfo.id;
        imageContainer.style.position = 'relative';
        
        // Create elements programmatically to avoid quote escaping issues
        const img = document.createElement('img');
        img.src = imageInfo.data;
        img.alt = 'Engine compartment image';
        img.title = 'Click to view full size';
        img.onclick = function() { openImageModal(imageInfo.data); };
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-image-btn';
        removeBtn.title = 'Remove image';
        removeBtn.onclick = function() { removeAdditionalImage(imageInfo.id); };
        removeBtn.innerHTML = '<i class="bi bi-x"></i>';
        
        const captionInput = document.createElement('input');
        captionInput.type = 'text';
        captionInput.className = 'image-caption-input';
        captionInput.placeholder = 'Enter image caption...';
        captionInput.dataset.imageId = imageInfo.id;
        captionInput.value = imageInfo.caption || '';
        captionInput.onchange = function() { updateImageCaption(imageInfo.id, this.value); };
        
        imageContainer.appendChild(img);
        imageContainer.appendChild(removeBtn);
        imageContainer.appendChild(captionInput);
        
        gallery.appendChild(imageContainer);
    }
}

// Update image caption
function updateImageCaption(imageId, caption) {
    const image = additionalEngineImages.find(img => img.id === imageId);
    if (image) {
        image.caption = caption;
        console.log('Caption updated for image:', imageId, 'Caption:', caption);
    }
}

// Remove additional image
function removeAdditionalImage(imageId) {
    // Remove from data array
    additionalEngineImages = additionalEngineImages.filter(img => img.id !== imageId);
    
    // Remove from DOM
    const imageContainer = document.querySelector(`[data-image-id="${imageId}"]`);
    if (imageContainer) {
        imageContainer.remove();
    }
    
    // Hide gallery if no images
    const gallery = document.getElementById('gallery-engine-additional');
    if (gallery && gallery.children.length === 0) {
        gallery.style.display = 'none';
    }
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

function initializeEngineComponents() {
    // Initialize the reusable InspectionCards system for engine components
    InspectionCards.init({
        // Required Configuration
        formId: 'engineCompartmentForm',
        containerId: 'engineComponentAssessments',
        storageKey: 'engineComponentsData',
        
        // Engine components specific configuration (no overlays)
        hasOverlays: false,
        
        // All engine component items with camera
        items: [
            { id: 'brakefluid_cleanliness', category: 'Brakefluid cleanliness', panelId: 'brakefluid-cleanliness' },
            { id: 'brakefluid_level', category: 'Brakefluid level', panelId: 'brakefluid-level' },
            { id: 'coolant_level', category: 'Coolant level', panelId: 'coolant-level' },
            { id: 'antifreeze_strength', category: 'Antifreeze strength', panelId: 'antifreeze-strength' },
            { id: 'fan_belt', category: 'Fan belt', panelId: 'fan-belt' },
            { id: 'engine_oil_level', category: 'Engine oil level', panelId: 'engine-oil-level' },
            { id: 'engine_oil_condition', category: 'Engine oil condition', panelId: 'engine-oil-condition' },
            { id: 'battery_condition', category: 'Battery condition', panelId: 'battery-condition' },
            { id: 'engine_mounts', category: 'Engine mounts', panelId: 'engine-mounts' },
            { id: 'exhaust_system', category: 'Exhaust system', panelId: 'exhaust-system' }
        ],
        
        // Custom field configuration for engine components
        fields: {
            condition: { 
                enabled: true, 
                label: 'Condition', 
                options: ['Good', 'Average', 'Bad', 'N/A'] 
            },
            comments: { 
                enabled: true, 
                label: 'Comments', 
                type: 'textarea', 
                placeholder: 'Add comments if needed...'
            }
        },
        
        // Callback for form submission - just save to sessionStorage
        onFormSubmit: function(data) {
            // Store the engine components data
            sessionStorage.setItem('engineComponentsData', JSON.stringify(data));
            // Don't do API call here - button handler will do it
        }
    });
}

function initializeFindingCheckboxes() {
    const checkboxes = document.querySelectorAll('.finding-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const findingKey = this.name.replace('findings[', '').replace(']', '');
            const notesContainer = document.getElementById(findingKey.replace('_', '') + 'Notes') || 
                                 document.getElementById('generalInspectionNotes') || 
                                 document.getElementById('componentPresenceNotes');
            
            if (this.checked) {
                engineCompartmentData.findings[findingKey] = true;
                if (notesContainer) {
                    notesContainer.style.display = 'block';
                }
            } else {
                delete engineCompartmentData.findings[findingKey];
                if (notesContainer && !hasAnyRelatedCheckboxSelected(notesContainer)) {
                    notesContainer.style.display = 'none';
                }
            }
            
        });
    });
    
    // Handle notes inputs
    const notesInputs = document.querySelectorAll('textarea[name^="findings["]');
    notesInputs.forEach(input => {
        input.addEventListener('input', function() {
            const findingKey = this.name.replace('findings[', '').replace(']', '');
            engineCompartmentData.findings[findingKey] = this.value;
        });
    });
}

function hasAnyRelatedCheckboxSelected(notesContainer) {
    const containerId = notesContainer.id;
    if (containerId.includes('generalInspection')) {
        return document.getElementById('noDeficiencies').checked || 
               document.getElementById('noStructuralDamage').checked;
    } else if (containerId.includes('componentPresence')) {
        return document.getElementById('engineCoversPartial').checked ||
               document.getElementById('undercarriageMissing').checked ||
               document.getElementById('engineCoversAbsent').checked ||
               document.getElementById('headlightRepairs').checked ||
               document.getElementById('fenderlinerDamages').checked;
    }
    return false;
}



function validateEngineCompartmentAssessment() {
    // All validations removed for testing
    return true;
}

function loadPreviousData() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    if (visualData) {
        const data = JSON.parse(visualData);
        displayInspectionSummary(data);
    }
    
    // Load existing engine compartment data if available
    const engineData = sessionStorage.getItem('engineCompartmentData');
    if (engineData) {
        restoreEngineCompartmentData(JSON.parse(engineData));
    }
}

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
                Progress: Visual ✓ | Body Panels ✓ | Specific Areas ✓ | Interior ✓ | Service Booklet ✓ | Tyres & Rims ✓ | Mechanical Report ✓ | Engine Compartment
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

function saveCurrentProgress() {
    const formData = new FormData(document.getElementById('engineCompartmentForm'));
    const updatedData = { ...engineCompartmentData };
    
    // Update data with current form values
    sessionStorage.setItem('engineCompartmentData', JSON.stringify(updatedData));
}

async function saveEngineCompartmentData() {
    console.log('Starting engine compartment save...');
    
    try {
        let inspectionId = sessionStorage.getItem('currentInspectionId');
        console.log('Inspection ID from storage:', inspectionId);
        
        // If no inspection ID, use a default for testing (like we do in other controllers)
        if (!inspectionId) {
            console.warn('No inspection ID in sessionStorage, using default ID 121 for testing');
            inspectionId = '121';
            sessionStorage.setItem('currentInspectionId', inspectionId);
        }

        // Prepare API data structure
        const apiData = {
            inspection_id: parseInt(inspectionId),
            findings: [],
            components: [],
            images: []
        };

        // Extract findings from form checkboxes
        const checkboxes = document.querySelectorAll('.finding-checkbox:checked');
        checkboxes.forEach(checkbox => {
            const findingType = checkbox.name.replace('findings[', '').replace(']', '');
            const notesInput = document.querySelector(`textarea[name="findings[${findingType}_notes]"]`);
            
            apiData.findings.push({
                finding_type: findingType,
                is_checked: true,
                notes: notesInput ? notesInput.value : null
            });
        });
        
        // Add engine number verification text input
        const engineNumberInput = document.getElementById('engineNumberInput');
        console.log('Engine number input element:', engineNumberInput);
        console.log('Engine number input value:', engineNumberInput ? engineNumberInput.value : 'not found');
        if (engineNumberInput && engineNumberInput.value.trim()) {
            console.log('Adding engine number finding:', engineNumberInput.value.trim());
            apiData.findings.push({
                finding_type: 'engine_number_input',
                is_checked: true,
                notes: engineNumberInput.value.trim()
            });
        } else {
            console.log('Engine number input is empty or not found');
        }

        // Get form data and images from InspectionCards (EXACT WORKING PATTERN)
        let formData = {};
        let imageData = {};
        
        try {
            if (window.InspectionCards && typeof InspectionCards.getFormData === 'function') {
                formData = InspectionCards.getFormData();
                imageData = InspectionCards.getImages();
                console.log('Engine Form Data:', formData);
                console.log('Engine Images:', imageData);
            }
        } catch (e) {
            console.error('Error getting InspectionCards data:', e);
        }
        
        // Build component map from InspectionCards data
        const componentMap = {};
        
        for (let [key, value] of Object.entries(formData)) {
            // Skip non-string values and handle them properly
            if (key !== '_token' && value !== null && value !== undefined) {
                // Convert value to string if it's not already
                const stringValue = typeof value === 'string' ? value : String(value);
                
                if (stringValue.trim() !== '') {
                    // Parse field names like "brakefluid_cleanliness-condition" 
                    const parts = key.split('-');
                    if (parts.length >= 2) {
                        const componentId = parts[0];
                        const fieldName = parts[1];
                        
                        if (!componentMap[componentId]) {
                            componentMap[componentId] = {
                                component_type: componentId,
                                condition: null,
                                comments: null
                            };
                        }
                        
                        if (fieldName === 'condition') {
                            componentMap[componentId].condition = stringValue;
                        } else if (fieldName === 'comments') {
                            componentMap[componentId].comments = stringValue;
                        }
                    }
                }
            }
        }
        
        apiData.components = Object.values(componentMap);
        
        // Add images from InspectionCards
        for (let [componentId, images] of Object.entries(imageData)) {
            if (images && images.length > 0) {
                images.forEach(imageInfo => {
                    apiData.images.push({
                        component_type: componentId,
                        image_data: imageInfo.data,
                        original_name: imageInfo.name || `${componentId}_image.jpg`
                    });
                });
            }
        }
        
        // Add additional images with captions
        if (additionalEngineImages && additionalEngineImages.length > 0) {
            additionalEngineImages.forEach(img => {
                apiData.images.push({
                    component_type: 'additional',
                    image_data: img.data,
                    caption: img.caption || '',
                    original_name: `additional_engine_${img.id}.jpg`
                });
            });
            console.log('Additional engine images with captions:', additionalEngineImages.length);
        }
        
        console.log('Engine components data extracted:', apiData.components);
        console.log('Engine images data:', apiData.images);

        console.log('Final API data to send:', apiData);

        // Check if we have valid data
        if (!apiData.inspection_id) {
            throw new Error('No inspection ID available');
        }

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }

        console.log('Making fetch request with inspection_id:', apiData.inspection_id);
        console.log('CSRF token:', csrfToken.getAttribute('content'));

        // Save to database via API
        const response = await fetch('/api/inspection/engine-compartment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(apiData)
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response error:', errorText);
            throw new Error(`HTTP ${response.status}: ${errorText}`);
        }

        const result = await response.json();
        console.log('Response JSON:', result);

        if (result.success) {
            // Show success notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                background: #28a745; color: white; border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
                font-weight: 500;
            `;
            notification.textContent = 'Engine compartment assessment saved successfully!';
            document.body.appendChild(notification);

            setTimeout(() => notification.remove(), 3000);

            // Clear local storage
            sessionStorage.removeItem('engineCompartmentData');
            sessionStorage.removeItem('engineComponentsData');

            // Navigate based on inspection type
            const inspectionType = sessionStorage.getItem('inspectionType');
            if (inspectionType === 'condition') {
                // Complete condition report
                notify.success('Condition Report completed successfully!', { duration: 2000 });
                // Wait 2 seconds before navigating to dashboard
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
            } else {
                // Continue to physical hoist inspection
                window.location.href = '/inspection/physical-hoist';
            }
        } else {
            throw new Error(result.message || 'Unknown error occurred');
        }

    } catch (error) {
        console.error('Failed to save engine compartment assessment:', error);
        console.error('Error name:', error.name);
        console.error('Error message:', error.message);
        console.error('Error stack:', error.stack);
        
        notify.error('Failed to save engine compartment assessment: ' + error.message);
    }
}

function restoreEngineCompartmentData(data) {
    engineCompartmentData = data;
    
    // Restore checkboxes and findings
    Object.keys(data.findings).forEach(findingKey => {
        const checkbox = document.querySelector(`[name="findings[${findingKey}]"]`);
        if (checkbox && data.findings[findingKey] === true) {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
}

function setupNavigationButtons() {
    const inspectionType = sessionStorage.getItem('inspectionType');
    const completeConditionBtn = document.getElementById('completeConditionBtn');
    const continueTechnicalBtn = document.getElementById('continueTechnicalBtn');
    const nextStepBreadcrumb = document.getElementById('nextStepBreadcrumb');
    
    console.log('Setting up navigation buttons for inspection type:', inspectionType);
    
    if (inspectionType === 'condition') {
        // Show "Complete Condition Report" button
        completeConditionBtn.style.display = 'inline-block';
        continueTechnicalBtn.style.display = 'none';
        
        // Update breadcrumb
        nextStepBreadcrumb.textContent = 'Report Complete';
        nextStepBreadcrumb.innerHTML = '<i class="bi bi-check-circle"></i> Report Complete';
        
        // Update form submission to complete the condition report
        completeConditionBtn.onclick = async function() {
            try {
                await saveEngineCompartmentData();
                // Success notification is handled in saveEngineCompartmentData()
                // Redirect to dashboard after successful save
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1500);
            } catch (error) {
                console.error('Error completing condition report:', error);
                notify.error('Error saving condition report. Please try again.');
            }
        };
        
    } else if (inspectionType === 'technical') {
        // Show "Continue to Physical Hoist" button
        completeConditionBtn.style.display = 'none';
        continueTechnicalBtn.style.display = 'inline-block';
        
        // Update breadcrumb
        nextStepBreadcrumb.textContent = 'Physical Hoist';
        
        // Update form submission to continue to physical hoist
        continueTechnicalBtn.onclick = async function(e) {
            e.preventDefault();
            
            console.log('Engine Compartment: Starting save and navigation...');
            
            // Get form data and images from InspectionCards (EXACT WORKING PATTERN)
            let formData = {};
            let imageData = {};
            
            try {
                if (window.InspectionCards && typeof InspectionCards.getFormData === 'function') {
                    formData = InspectionCards.getFormData();
                    imageData = InspectionCards.getImages();
                    console.log('Engine Form Data:', formData);
                    console.log('Engine Images:', imageData);
                }
            } catch (e) {
                console.error('Error getting InspectionCards data:', e);
            }
            
            // Get current inspection ID from session storage
            const inspectionId = sessionStorage.getItem('currentInspectionId') || '121';
            console.log('Current Inspection ID:', inspectionId);
            
            // Prepare API data
            const apiData = {
                inspection_id: inspectionId,
                findings: [],
                components: [],
                images: []
            };
            
            // Transform image data to engine compartment format
            console.log('Raw imageData before transformation:', imageData);
            
            if (imageData && typeof imageData === 'object') {
                // imageData is like: {"exhaust-system": [{id: "...", data: "..."}]}
                for (const [componentType, componentImages] of Object.entries(imageData)) {
                    console.log('Processing component:', componentType, 'with images:', componentImages);
                    if (Array.isArray(componentImages)) {
                        componentImages.forEach(img => {
                            if (img && img.data) {
                                // Transform hyphenated names to underscores for backend
                                const cleanComponentType = componentType.replace(/-/g, '_');
                                apiData.images.push({
                                    component_type: cleanComponentType,
                                    image_data: img.data
                                });
                                console.log('Added image for:', cleanComponentType);
                            }
                        });
                    }
                }
            }
            
            console.log('Final transformed images for API:', apiData.images);
            
            // Add additional images with captions
            if (additionalEngineImages && additionalEngineImages.length > 0) {
                additionalEngineImages.forEach(img => {
                    apiData.images.push({
                        component_type: 'additional',
                        image_data: img.data,
                        caption: img.caption || '',
                        original_name: `additional_engine_${img.id}.jpg`
                    });
                });
                console.log('Additional engine images with captions added:', additionalEngineImages.length);
            }
            
            // Extract findings from checkboxes
            const checkboxes = document.querySelectorAll('.finding-checkbox:checked');
            checkboxes.forEach(checkbox => {
                const findingType = checkbox.name.replace('findings[', '').replace(']', '');
                const notesInput = document.querySelector(`textarea[name="findings[${findingType}_notes]"]`);
                
                apiData.findings.push({
                    finding_type: findingType,
                    is_checked: true,
                    notes: notesInput ? notesInput.value : null
                });
            });
            
            // Add engine number verification text input
            const engineNumberInput = document.getElementById('engineNumberInput');
            if (engineNumberInput && engineNumberInput.value.trim()) {
                apiData.findings.push({
                    finding_type: 'engine_number_input',
                    is_checked: true,
                    notes: engineNumberInput.value.trim()
                });
            }
            
            // Extract component data from form data (map engine fields) 
            const componentMap = {};
            for (const [key, value] of Object.entries(formData)) {
                const match = key.match(/^([^-]+)-(.+)$/);
                if (match) {
                    const componentId = match[1];
                    const fieldName = match[2];
                    
                    if (!componentMap[componentId]) {
                        componentMap[componentId] = { component_type: componentId };
                    }
                    
                    if (fieldName === 'condition') {
                        componentMap[componentId].condition = value;
                    } else if (fieldName === 'comments') {
                        componentMap[componentId].comments = value;
                    }
                }
            }
            
            // Convert component map to array
            apiData.components = Object.values(componentMap);
            
            console.log('Engine API Data being sent:', apiData);
            
            try {
                // Save to database via API (EXACT WORKING PATTERN FROM TYRES)
                const response = await fetch('/api/inspection/engine-compartment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(apiData)
                });
                
                console.log('Engine API Response status:', response.status);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Engine API Error Response:', errorText);
                    throw new Error(`HTTP ${response.status}: ${errorText}`);
                }
                
                const result = await response.json();
                console.log('Engine API Response:', result);
                
                if (result.success) {
                    console.log('✅ Engine compartment assessment saved successfully!');
                    
                    // Also save to sessionStorage for compatibility
                    InspectionCards.saveData();
                    
                    // Show success message
                    const notification = document.createElement('div');
                    notification.style.cssText = `
                        position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                        background: #28a745; color: white; border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
                        font-weight: 500;
                    `;
                    notification.textContent = '✅ Engine compartment data saved successfully!';
                    document.body.appendChild(notification);
                    
                    // Remove notification after delay and navigate
                    setTimeout(() => {
                        notification.remove();
                        window.location.href = '/inspection/physical-hoist';
                    }, 1500);
                } else {
                    throw new Error(result.message || 'Failed to save engine compartment data');
                }
                
            } catch (error) {
                console.error('Failed to save engine compartment assessment:', error);
                notify.error('Failed to save engine compartment assessment: ' + error.message);
            }
        };
        
    } else {
        // Default: assume technical inspection if no type is set
        completeConditionBtn.style.display = 'none';
        continueTechnicalBtn.style.display = 'inline-block';
        
        // Keep default breadcrumb text
        nextStepBreadcrumb.textContent = 'Physical Hoist';
        
        continueTechnicalBtn.onclick = async function(e) {
            e.preventDefault();
            
            console.log('Engine Compartment: Starting save and navigation...');
            
            // Get form data and images from InspectionCards (EXACT WORKING PATTERN)
            let formData = {};
            let imageData = {};
            
            try {
                if (window.InspectionCards && typeof InspectionCards.getFormData === 'function') {
                    formData = InspectionCards.getFormData();
                    imageData = InspectionCards.getImages();
                    console.log('Engine Form Data:', formData);
                    console.log('Engine Images:', imageData);
                }
            } catch (e) {
                console.error('Error getting InspectionCards data:', e);
            }
            
            // Get current inspection ID from session storage
            const inspectionId = sessionStorage.getItem('currentInspectionId') || '121';
            console.log('Current Inspection ID:', inspectionId);
            
            // Prepare API data
            const apiData = {
                inspection_id: inspectionId,
                findings: [],
                components: [],
                images: []
            };
            
            // Transform image data to engine compartment format
            console.log('Raw imageData before transformation:', imageData);
            
            if (imageData && typeof imageData === 'object') {
                // imageData is like: {"exhaust-system": [{id: "...", data: "..."}]}
                for (const [componentType, componentImages] of Object.entries(imageData)) {
                    console.log('Processing component:', componentType, 'with images:', componentImages);
                    if (Array.isArray(componentImages)) {
                        componentImages.forEach(img => {
                            if (img && img.data) {
                                // Transform hyphenated names to underscores for backend
                                const cleanComponentType = componentType.replace(/-/g, '_');
                                apiData.images.push({
                                    component_type: cleanComponentType,
                                    image_data: img.data
                                });
                                console.log('Added image for:', cleanComponentType);
                            }
                        });
                    }
                }
            }
            
            console.log('Final transformed images for API:', apiData.images);
            
            // Add additional images with captions
            if (additionalEngineImages && additionalEngineImages.length > 0) {
                additionalEngineImages.forEach(img => {
                    apiData.images.push({
                        component_type: 'additional',
                        image_data: img.data,
                        caption: img.caption || '',
                        original_name: `additional_engine_${img.id}.jpg`
                    });
                });
                console.log('Additional engine images with captions added:', additionalEngineImages.length);
            }
            
            // Extract findings from checkboxes
            const checkboxes = document.querySelectorAll('.finding-checkbox:checked');
            checkboxes.forEach(checkbox => {
                const findingType = checkbox.name.replace('findings[', '').replace(']', '');
                const notesInput = document.querySelector(`textarea[name="findings[${findingType}_notes]"]`);
                
                apiData.findings.push({
                    finding_type: findingType,
                    is_checked: true,
                    notes: notesInput ? notesInput.value : null
                });
            });
            
            // Add engine number verification text input
            const engineNumberInput = document.getElementById('engineNumberInput');
            if (engineNumberInput && engineNumberInput.value.trim()) {
                apiData.findings.push({
                    finding_type: 'engine_number_input',
                    is_checked: true,
                    notes: engineNumberInput.value.trim()
                });
            }
            
            // Extract component data from form data (map engine fields) 
            const componentMap = {};
            for (const [key, value] of Object.entries(formData)) {
                const match = key.match(/^([^-]+)-(.+)$/);
                if (match) {
                    const componentId = match[1];
                    const fieldName = match[2];
                    
                    if (!componentMap[componentId]) {
                        componentMap[componentId] = { component_type: componentId };
                    }
                    
                    if (fieldName === 'condition') {
                        componentMap[componentId].condition = value;
                    } else if (fieldName === 'comments') {
                        componentMap[componentId].comments = value;
                    }
                }
            }
            
            // Convert component map to array
            apiData.components = Object.values(componentMap);
            
            console.log('Engine API Data being sent:', apiData);
            
            try {
                // Save to database via API (EXACT WORKING PATTERN FROM TYRES)
                const response = await fetch('/api/inspection/engine-compartment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(apiData)
                });
                
                console.log('Engine API Response status:', response.status);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Engine API Error Response:', errorText);
                    throw new Error(`HTTP ${response.status}: ${errorText}`);
                }
                
                const result = await response.json();
                console.log('Engine API Response:', result);
                
                if (result.success) {
                    console.log('✅ Engine compartment assessment saved successfully!');
                    
                    // Also save to sessionStorage for compatibility
                    InspectionCards.saveData();
                    
                    // Show success message
                    const notification = document.createElement('div');
                    notification.style.cssText = `
                        position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                        background: #28a745; color: white; border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
                        font-weight: 500;
                    `;
                    notification.textContent = '✅ Engine compartment data saved successfully!';
                    document.body.appendChild(notification);
                    
                    // Remove notification after delay and navigate
                    setTimeout(() => {
                        notification.remove();
                        window.location.href = '/inspection/physical-hoist';
                    }, 1500);
                } else {
                    throw new Error(result.message || 'Failed to save engine compartment data');
                }
                
            } catch (error) {
                console.error('Failed to save engine compartment assessment:', error);
                notify.error('Failed to save engine compartment assessment: ' + error.message);
            }
        };
        
        console.log('No inspection type found, defaulting to technical inspection');
    }
}
</script>
@endsection
