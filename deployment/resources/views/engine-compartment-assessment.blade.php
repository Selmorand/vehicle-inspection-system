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

        <!-- Section 2: Photographic Documentation -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Photographic Documentation</h5>
                        <small class="text-light">Capture up to 16 images with captions (minimum 5 required)</small>
                    </div>
                    <div class="card-body">

                        <!-- Image Grid -->
                        <div class="row" id="imageGrid">
                            <!-- Images will be dynamically added here -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                <div class="image-slot empty-slot" onclick="captureImage(0)">
                                    <div class="add-image-content">
                                        <i class="bi bi-camera-fill mb-2" style="font-size: 2rem; color: var(--primary-color);"></i>
                                        <p class="mb-0">Add Image</p>
                                        <small class="text-muted">Tap to capture</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Engine Component Overview Check -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Overview check:</h5>
                        <small class="text-light">Assess engine component conditions - colors will update automatically</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="componentAssessmentTable">
                                <thead style="background-color: #b8dae0;">
                                    <tr>
                                        <th style="width: 40%;" class="text-center">Engine Component</th>
                                        <th style="width: 20%;" class="text-center">Condition</th>
                                        <th style="width: 40%;" class="text-center">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="component-row" data-component="brakefluid_cleanliness">
                                        <td class="component-name">Brakefluid cleanliness</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[brakefluid_cleanliness][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[brakefluid_cleanliness][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="brakefluid_level">
                                        <td class="component-name">Brakefluid level</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[brakefluid_level][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[brakefluid_level][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="coolant_level">
                                        <td class="component-name">Coolant level</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[coolant_level][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[coolant_level][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="antifreeze_strength">
                                        <td class="component-name">Antifreeze strength</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[antifreeze_strength][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[antifreeze_strength][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="fan_belt">
                                        <td class="component-name">Fan belt</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[fan_belt][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[fan_belt][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="engine_oil_level">
                                        <td class="component-name">Engine oil level</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[engine_oil_level][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[engine_oil_level][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="engine_oil_condition">
                                        <td class="component-name">Engine oil condition</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[engine_oil_condition][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[engine_oil_condition][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="battery_condition">
                                        <td class="component-name">Battery condition</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[battery_condition][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[battery_condition][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="engine_mounts">
                                        <td class="component-name">Engine mounts</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[engine_mounts][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[engine_mounts][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-component="exhaust_system">
                                        <td class="component-name">Exhaust system</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown" name="components[exhaust_system][condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" name="components[exhaust_system][comments]" 
                                                      rows="1" placeholder="Add comments if needed..."></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

<!-- Image Capture Modal -->
<div class="modal fade" id="imageCaptureModal" tabindex="-1" aria-labelledby="imageCaptureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageCaptureModalLabel">Capture Engine Compartment Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <video id="camera" width="100%" height="300" autoplay style="border: 2px solid #ccc; border-radius: 8px;"></video>
                    <canvas id="captureCanvas" style="display: none;"></canvas>
                </div>
                <div class="mt-3">
                    <label for="imageCategory" class="form-label">Image Category:</label>
                    <select class="form-control" id="imageCategory">
                        <option value="">Select category...</option>
                        <option value="Engine Overview">Engine Overview</option>
                        <option value="Engine Number">Engine Number</option>
                        <option value="Engine Covers">Engine Covers</option>
                        <option value="Fluid Levels">Fluid Levels</option>
                        <option value="Belts & Hoses">Belts & Hoses</option>
                        <option value="Electrical Components">Electrical Components</option>
                        <option value="Structural Elements">Structural Elements</option>
                        <option value="Damage Areas">Damage Areas</option>
                        <option value="Fender Liners">Fender Liners</option>
                        <option value="Headlight Areas">Headlight Areas</option>
                        <option value="Additional Findings">Additional Findings</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="captureBtn">
                    <i class="bi bi-camera-fill me-1"></i>Capture Image
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-css')
<style>
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

/* Image Grid Styling */
.image-slot {
    aspect-ratio: 1;
    width: 100%;
    border: 2px dashed #ccc;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.image-slot:hover {
    border-color: var(--primary-color);
    background-color: #e8f4f8;
    transform: translateY(-2px);
}

.image-slot.filled {
    border: 2px solid var(--primary-color);
    padding: 5px;
}

.add-image-content {
    text-align: center;
    color: #6c757d;
}

.captured-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.image-caption {
    margin-top: 5px;
}

.image-caption input {
    font-size: 12px;
    padding: 4px 8px;
}

.delete-image-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.8);
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    color: white;
    font-size: 12px;
    cursor: pointer;
}

.delete-image-btn:hover {
    background: rgba(220, 53, 69, 1);
}

/* Component Assessment Table */
.component-name {
    font-weight: 500;
    background-color: #f8f9fa;
}

/* Condition Dropdown Color Coding */
.condition-dropdown.condition-good {
    background-color: #28a745;
    color: white;
    border-color: #28a745;
}

.condition-dropdown.condition-average {
    background-color: #ffc107;
    color: black;
    border-color: #ffc107;
}

.condition-dropdown.condition-bad {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

.condition-dropdown.condition-na {
    background-color: #6c757d;
    color: white;
    border-color: #6c757d;
}

/* Comments field styling */
.component-comments {
    transition: all 0.3s ease;
    min-height: 38px;
    resize: vertical;
}

.component-comments.required {
    border-color: #dc3545;
    background-color: #fff5f5;
}

.component-comments:focus {
    box-shadow: 0 0 0 0.2rem rgba(79, 149, 155, 0.25);
    border-color: var(--primary-color);
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
<script>
// Engine compartment assessment data storage
let engineCompartmentData = {
    findings: {},
    images: [],
    components: {}
};

let currentImageSlot = 0;
let maxImages = 16;
let totalFindings = 7;
let totalComponents = 10;

document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Initialize finding checkboxes
    initializeFindingCheckboxes();
    
    // Initialize component dropdowns
    initializeComponentDropdowns();
    
    // Initialize image grid
    initializeImageGrid();

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

function initializeComponentDropdowns() {
    const conditionDropdowns = document.querySelectorAll('.condition-dropdown');
    
    conditionDropdowns.forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const row = this.closest('.component-row');
            const component = row.dataset.component;
            const condition = this.value;
            const commentsField = row.querySelector('.component-comments');
            
            // Update dropdown styling
            updateConditionStyling(this, condition);
            
            // Handle comments field requirements
            handleCommentsField(commentsField, condition);
            
            // Store the assessment data
            if (condition) {
                engineCompartmentData.components[component] = {
                    condition: condition,
                    comments: commentsField.value
                };
            } else {
                delete engineCompartmentData.components[component];
            }
        });
    });
    
    // Add listeners to comments fields
    const commentsFields = document.querySelectorAll('.component-comments');
    commentsFields.forEach(field => {
        field.addEventListener('input', function() {
            const row = this.closest('.component-row');
            const component = row.dataset.component;
            
            if (engineCompartmentData.components[component]) {
                engineCompartmentData.components[component].comments = this.value;
            }
        });
    });
}

function updateConditionStyling(dropdown, condition) {
    // Remove all condition classes
    dropdown.classList.remove('condition-good', 'condition-average', 'condition-bad', 'condition-na');
    
    // Add appropriate class based on condition
    if (condition === 'Good') {
        dropdown.classList.add('condition-good');
    } else if (condition === 'Average') {
        dropdown.classList.add('condition-average');
    } else if (condition === 'Bad') {
        dropdown.classList.add('condition-bad');
    } else if (condition === 'N/A') {
        dropdown.classList.add('condition-na');
    }
}

function handleCommentsField(commentsField, condition) {
    if (condition === 'Bad') {
        commentsField.classList.add('required');
        commentsField.setAttribute('placeholder', 'Comments required for Bad condition...');
        commentsField.focus();
    } else {
        commentsField.classList.remove('required');
        commentsField.setAttribute('placeholder', 'Add comments if needed...');
    }
}

function initializeImageGrid() {
    // Initialize empty slots for remaining images
    const imageGrid = document.getElementById('imageGrid');
    
    for (let i = 1; i < maxImages; i++) {
        const slot = document.createElement('div');
        slot.className = 'col-lg-3 col-md-4 col-sm-6 mb-3';
        slot.innerHTML = `
            <div class="image-slot empty-slot" onclick="captureImage(${i})" style="display: none;">
                <div class="add-image-content">
                    <i class="bi bi-camera-fill mb-2" style="font-size: 2rem; color: var(--primary-color);"></i>
                    <p class="mb-0">Add Image</p>
                    <small class="text-muted">Tap to capture</small>
                </div>
            </div>
        `;
        imageGrid.appendChild(slot);
    }
}

function captureImage(slotIndex) {
    currentImageSlot = slotIndex;
    const modal = new bootstrap.Modal(document.getElementById('imageCaptureModal'));
    modal.show();
    
    // Initialize camera when modal is shown
    setTimeout(() => {
        initializeCamera();
    }, 500);
}

function initializeCamera() {
    const video = document.getElementById('camera');
    
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                video.srcObject = stream;
                
                // Add capture button event listener
                document.getElementById('captureBtn').onclick = function() {
                    capturePhotoFromVideo();
                };
            })
            .catch(function(error) {
                console.error('Error accessing camera:', error);
                alert('Unable to access camera. Please ensure camera permissions are granted.');
            });
    } else {
        alert('Camera not supported on this device.');
    }
}

function capturePhotoFromVideo() {
    const video = document.getElementById('camera');
    const canvas = document.getElementById('captureCanvas');
    const context = canvas.getContext('2d');
    const category = document.getElementById('imageCategory').value;
    
    if (!category) {
        alert('Please select an image category before capturing.');
        return;
    }
    
    // Set canvas dimensions
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Draw video frame to canvas
    context.drawImage(video, 0, 0);
    
    // Convert to blob and process
    canvas.toBlob(function(blob) {
        if (blob.size > 2 * 1024 * 1024) { // 2MB limit
            alert('Image too large. Please try again.');
            return;
        }
        
        // Create image data
        const imageData = {
            id: `img_${Date.now()}`,
            blob: blob,
            category: category,
            caption: getDefaultCaption(category),
            timestamp: new Date().toISOString(),
            slotIndex: currentImageSlot
        };
        
        // Add to data array
        engineCompartmentData.images.push(imageData);
        
        // Display in grid
        displayCapturedImage(imageData);
        
        // Close modal and stop camera
        bootstrap.Modal.getInstance(document.getElementById('imageCaptureModal')).hide();
        stopCamera();
        
        
    }, 'image/jpeg', 0.8);
}

function getDefaultCaption(category) {
    const captions = {
        'Engine Overview': 'General engine compartment view',
        'Engine Number': 'Engine number location (if visible)',
        'Engine Covers': 'Engine cover condition/presence',
        'Fluid Levels': 'Brake fluid, coolant, oil levels',
        'Belts & Hoses': 'Fan belt and hose condition',
        'Electrical Components': 'Battery, wiring, connections',
        'Structural Elements': 'Engine mounts, brackets, frames',
        'Damage Areas': 'Any identified damage or repairs',
        'Fender Liners': 'Fender liner condition',
        'Headlight Areas': 'Headlight brackets and surroundings',
        'Additional Findings': 'Other notable observations'
    };
    return captions[category] || 'Engine compartment image';
}

function displayCapturedImage(imageData) {
    const imageGrid = document.getElementById('imageGrid');
    const slots = imageGrid.querySelectorAll('.col-lg-3');
    const targetSlot = slots[imageData.slotIndex];
    
    // Create image URL from blob
    const imageUrl = URL.createObjectURL(imageData.blob);
    
    // Update slot content
    targetSlot.innerHTML = `
        <div class="image-slot filled position-relative">
            <img src="${imageUrl}" alt="${imageData.category}" class="captured-image">
            <button type="button" class="delete-image-btn" onclick="deleteImage('${imageData.id}', ${imageData.slotIndex})">
                <i class="bi bi-x"></i>
            </button>
            <div class="image-caption">
                <input type="text" class="form-control" value="${imageData.caption}" 
                       onchange="updateImageCaption('${imageData.id}', this.value)"
                       placeholder="Add caption..." maxlength="100">
                <small class="text-muted">${imageData.category}</small>
            </div>
        </div>
    `;
    
    // Show next empty slot if available
    const nextSlotIndex = imageData.slotIndex + 1;
    if (nextSlotIndex < maxImages) {
        const nextSlot = slots[nextSlotIndex].querySelector('.empty-slot');
        if (nextSlot) {
            nextSlot.style.display = 'flex';
        }
    }
}

function deleteImage(imageId, slotIndex) {
    if (confirm('Are you sure you want to delete this image?')) {
        // Remove from data array
        engineCompartmentData.images = engineCompartmentData.images.filter(img => img.id !== imageId);
        
        // Reset slot to empty state
        const imageGrid = document.getElementById('imageGrid');
        const slots = imageGrid.querySelectorAll('.col-lg-3');
        const targetSlot = slots[slotIndex];
        
        targetSlot.innerHTML = `
            <div class="image-slot empty-slot" onclick="captureImage(${slotIndex})">
                <div class="add-image-content">
                    <i class="bi bi-camera-fill mb-2" style="font-size: 2rem; color: var(--primary-color);"></i>
                    <p class="mb-0">Add Image</p>
                    <small class="text-muted">Tap to capture</small>
                </div>
            </div>
        `;
    }
}

function updateImageCaption(imageId, newCaption) {
    const image = engineCompartmentData.images.find(img => img.id === imageId);
    if (image) {
        image.caption = newCaption;
    }
}

function stopCamera() {
    const video = document.getElementById('camera');
    if (video.srcObject) {
        video.srcObject.getTracks().forEach(track => track.stop());
    }
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
    
    // Restore component assessments
    Object.keys(data.components).forEach(component => {
        const componentData = data.components[component];
        const conditionSelect = document.querySelector(`[name="components[${component}][condition]"]`);
        const commentsField = document.querySelector(`[name="components[${component}][comments]"]`);
        
        if (conditionSelect && componentData.condition) {
            conditionSelect.value = componentData.condition;
            updateConditionStyling(conditionSelect, componentData.condition);
            handleCommentsField(commentsField, componentData.condition);
        }
        
        if (commentsField && componentData.comments) {
            commentsField.value = componentData.comments;
        }
    });
    
    // Restore images
    data.images.forEach(imageData => {
        displayCapturedImage(imageData);
    });
}
</script>
@endsection