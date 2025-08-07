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
                    <li class="breadcrumb-item text-muted">Final Report</li>
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
            <div class="col-12 text-center">
                <button type="button" class="btn btn-outline-secondary me-3" id="backBtn">
                    <i class="bi bi-arrow-left me-1"></i>Back to Mechanical Report
                </button>
                <button type="button" class="btn btn-secondary me-3" id="saveDraftBtn">Save Draft</button>
                <button type="submit" class="btn btn-primary" id="nextBtn" form="engineCompartmentForm">
                    Continue to Physical Hoist Inspection <i class="bi bi-arrow-right ms-1"></i>
                </button>
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
    
    // Add color coding for condition dropdowns
    document.addEventListener('change', function(e) {
        if (e.target.name && e.target.name.endsWith('-condition')) {
            const select = e.target;
            // Set the value attribute for CSS selector
            select.setAttribute('value', select.value);
        }
    });

    // Form submission handler
    document.getElementById('engineCompartmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save the data
        saveCurrentProgress();
        
        // Navigate to physical hoist inspection section
        window.location.href = '/inspection/physical-hoist';
    });

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        saveCurrentProgress();
        window.location.href = '/inspection/mechanical-report';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        saveCurrentProgress();
        alert('Engine compartment assessment draft saved successfully!');
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
        
        // Callback for form submission
        onFormSubmit: function(data) {
            // Store the engine components data
            sessionStorage.setItem('engineComponentsData', JSON.stringify(data));
            // Continue with existing form submission logic
            window.location.href = '/inspection/physical-hoist';
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
</script>
@endsection