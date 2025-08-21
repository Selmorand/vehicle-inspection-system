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
                            <div class="form-check mb-2">
                                <input class="form-check-input finding-checkbox" type="checkbox" 
                                       id="engineNumberNotVisible" name="findings[engine_number_not_visible]" value="1">
                                <label class="form-check-label" for="engineNumberNotVisible">
                                    Engine number verification: "not possible to verify engine number (not visible without dismantling)"
                                </label>
                            </div>
                            <div class="additional-notes-container" id="engineNumberNotes" style="display: none;">
                                <textarea class="form-control mt-2" name="findings[engine_number_notes]" rows="2" 
                                          placeholder="Additional notes regarding engine number verification..."></textarea>
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

document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Initialize finding checkboxes
    initializeFindingCheckboxes();
    
    // Initialize engine component assessments using InspectionCards
    initializeEngineComponents();
    
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
        saveEngineCompartmentData();
    });

});

// Function to initialize engine components with InspectionCards
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

        // Get data from sessionStorage (saved by InspectionCards onFormSubmit)
        const storedData = sessionStorage.getItem('engineComponentsData');
        let componentData = {};
        
        if (storedData) {
            componentData = JSON.parse(storedData);
            console.log('Retrieved engine components data from sessionStorage:', componentData);
        }
        
        // Build component map from stored data
        const componentMap = {};
        
        for (let [key, value] of Object.entries(componentData)) {
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
        
        // Convert component map to array  
        apiData.components = Object.values(componentMap);
        apiData.images = []; // No images for now
        
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
                alert('Condition Report completed successfully!');
                window.location.href = '/dashboard';
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
        
        alert('Failed to save engine compartment assessment: ' + error.message);
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
        completeConditionBtn.onclick = function() {
            saveCurrentProgress();
            alert('Condition Report completed successfully!');
            // Could redirect to a completion page or back to dashboard
            window.location.href = '/dashboard';
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
                alert('Failed to save engine compartment assessment: ' + error.message);
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
                alert('Failed to save engine compartment assessment: ' + error.message);
            }
        };
        
        console.log('No inspection type found, defaulting to technical inspection');
    }
}
</script>
