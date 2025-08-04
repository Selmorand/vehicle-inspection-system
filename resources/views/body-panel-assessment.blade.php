@extends('layouts.app')

@section('title', 'Body Panel Assessment')

@section('content')
<div class="container-fluid px-4">
    <!-- Progress Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/inspection/visual" style="color: var(--primary-color);">Visual Inspection</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Body Panel Assessment</li>
                    <li class="breadcrumb-item text-muted">Specific Area Images</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Body Panel Assessment</h2>
        <p class="text-muted">Click on vehicle panels or hover over form labels to highlight areas</p>
    </div>

    <div class="row">
        <!-- Vehicle Visual Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Vehicle Body Panels</h5>
                </div>
                <div class="card-body">
                    <div class="vehicle-wrapper">
                        <div class="vehicle-container">
                            <!-- Base vehicle image -->
                            <img src="/images/panels/FullVehicle.png" alt="Vehicle Base" class="base-vehicle" id="baseVehicle">
                        
                        <!-- All panel overlays with converted positions -->
                        <!-- Windscreen -->
                        <img src="/images/panels/windscreen.png" 
                             class="panel-overlay" 
                             data-panel="windscreen" 
                             style="position: absolute; left: 576px; top: 350px; width: 147px; height: 279px;"
                             title="Windscreen" 
                             alt="Windscreen">
                             
                        <!-- Rear Right Taillight -->
                        <img src="/images/panels/rr-taillight.png" 
                             class="panel-overlay" 
                             data-panel="rr-taillight" 
                             style="position: absolute; left: 820px; top: 1122px; width: 92px; height: 52px;"
                             title="RR Taillight" 
                             alt="RR Taillight">
                             
                        <!-- Rear Right Quarter Panel -->
                        <img src="/images/panels/rr-quarter-panel.png" 
                             class="panel-overlay" 
                             data-panel="rr-quarter-panel" 
                             style="position: absolute; left: 56px; top: 102px; width: 271px; height: 141px;"
                             title="RR Quarter Panel" 
                             alt="RR Quarter Panel">
                             
                        <!-- Rear Right Door -->
                        <img src="/images/panels/rr-door.png" 
                             class="panel-overlay" 
                             data-panel="rr-door" 
                             style="position: absolute; left: 266px; top: 28px; width: 209px; height: 224px;"
                             title="RR Door" 
                             alt="RR Door">
                             
                        <!-- Roof -->
                        <img src="/images/panels/roof.png" 
                             class="panel-overlay" 
                             data-panel="roof" 
                             style="position: absolute; left: 299px; top: 380px; width: 283px; height: 221px;"
                             title="Roof" 
                             alt="Roof">
                             
                        <!-- Rear Window -->
                        <img src="/images/panels/rear-window.png" 
                             class="panel-overlay" 
                             data-panel="rear-window" 
                             style="position: absolute; left: 159px; top: 368px; width: 157px; height: 250px;"
                             title="Rear Window" 
                             alt="Rear Window">
                             
                        <!-- Rear Bumper -->
                        <img src="/images/panels/rear-bumper.png" 
                             class="panel-overlay" 
                             data-panel="rear-bumper" 
                             style="position: absolute; left: 595px; top: 1182px; width: 340px; height: 68px;"
                             title="Rear Bumper" 
                             alt="Rear Bumper">
                             
                        <!-- Left Rear Taillight -->
                        <img src="/images/panels/lr-taillight.png" 
                             class="panel-overlay" 
                             data-panel="lr-taillight" 
                             style="position: absolute; left: 622px; top: 1122px; width: 92px; height: 52px;"
                             title="LR Taillight" 
                             alt="LR Taillight">
                             
                        <!-- Left Rear Quarter Panel -->
                        <img src="/images/panels/lr-quarter-panel.png" 
                             class="panel-overlay" 
                             data-panel="lr-quarter-panel" 
                             style="position: absolute; left: 674px; top: 788px; width: 271px; height: 140px;"
                             title="LR Quarter Panel" 
                             alt="LR Quarter Panel">
                             
                        <!-- Left Rear Door -->
                        <img src="/images/panels/lr-door.png" 
                             class="panel-overlay" 
                             data-panel="lr-door" 
                             style="position: absolute; left: 526px; top: 712px; width: 207px; height: 224px;"
                             title="LR Door" 
                             alt="LR Door">
                             
                        <!-- Left Front Mirror -->
                        <img src="/images/panels/lf-mirror.png" 
                             class="panel-overlay" 
                             data-panel="lf-mirror" 
                             style="position: absolute; left: 368px; top: 1095px; width: 48px; height: 32px;"
                             title="LF Mirror" 
                             alt="LF Mirror">
                             
                        <!-- Left Front Headlight -->
                        <img src="/images/panels/lf-headlight.png" 
                             class="panel-overlay" 
                             data-panel="lf-headlight" 
                             style="position: absolute; left: 295px; top: 1155px; width: 92px; height: 34px;"
                             title="LF Headlight" 
                             alt="LF Headlight">
                             
                        <!-- Left Front Fender -->
                        <img src="/images/panels/lf-fender.png" 
                             class="panel-overlay" 
                             data-panel="lf-fender" 
                             style="position: absolute; left: 59px; top: 770px; width: 320px; height: 220px;"
                             title="LF Fender" 
                             alt="LF Fender">
                             
                        <!-- Left Front Door -->
                        <img src="/images/panels/lf-door.png" 
                             class="panel-overlay" 
                             data-panel="lf-door" 
                             style="position: absolute; left: 328px; top: 715px; width: 231px; height: 212px;"
                             title="LF Door" 
                             alt="LF Door">
                             
                        <!-- Front Bumper -->
                        <img src="/images/panels/front-bumper.png" 
                             class="panel-overlay" 
                             data-panel="front-bumper" 
                             style="position: absolute; left: 42px; top: 1180px; width: 374px; height: 85px;"
                             title="Front Bumper" 
                             alt="Front Bumper">
                             
                        <!-- Front Right Mirror -->
                        <img src="/images/panels/fr-mirror.png" 
                             class="panel-overlay" 
                             data-panel="fr-mirror" 
                             style="position: absolute; left: 40px; top: 1095px; width: 48px; height: 32px;"
                             title="FR Mirror" 
                             alt="FR Mirror">
                             
                        <!-- Front Right Headlight -->
                        <img src="/images/panels/fr-headlight.png" 
                             class="panel-overlay" 
                             data-panel="fr-headlight" 
                             style="position: absolute; left: 70px; top: 1155px; width: 91px; height: 34px;"
                             title="FR Headlight" 
                             alt="FR Headlight">
                             
                        <!-- Front Right Fender -->
                        <img src="/images/panels/fr-fender.png" 
                             class="panel-overlay" 
                             data-panel="fr-fender" 
                             style="position: absolute; left: 622px; top: 84px; width: 320px; height: 220px;"
                             title="FR Fender" 
                             alt="FR Fender">
                             
                        <!-- Front Right Door -->
                        <img src="/images/panels/fr-door.png" 
                             class="panel-overlay" 
                             data-panel="fr-door" 
                             style="position: absolute; left: 443px; top: 30px; width: 230px; height: 212px;"
                             title="FR Door" 
                             alt="FR Door">
                             
                        <!-- Boot -->
                        <img src="/images/panels/boot.png" 
                             class="panel-overlay" 
                             data-panel="boot" 
                             style="position: absolute; left: 73px; top: 363px; width: 141px; height: 267px;"
                             title="Boot" 
                             alt="Boot">
                             
                        <!-- Bonnet -->
                        <img src="/images/panels/bonnet.png" 
                             class="panel-overlay" 
                             data-panel="bonnet" 
                             style="position: absolute; left: 684px; top: 329px; width: 271px; height: 336px;"
                             title="Bonnet" 
                             alt="Bonnet">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Assessment Form Section -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Panel Assessment Details</h5>
                </div>
                <div class="card-body">
                    <form id="panelAssessmentForm">
                        @csrf
                        
                        <!-- Dynamic panel assessments will be generated by JavaScript -->
                        <div id="panelAssessments">
                            <!-- Panel forms will be added here -->
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" id="backBtn">
                                <i class="bi bi-arrow-left me-1"></i>Back to Visual Inspection
                            </button>
                            <div>
                                <button type="button" class="btn btn-secondary me-2" id="saveDraftBtn">Save Draft</button>
                                <button type="submit" class="btn btn-primary" id="nextBtn">
                                    Continue to Specific Areas <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-css')
<link rel="stylesheet" href="{{ asset('css/vehicle-responsive-fix.css') }}">
<style>
/* Vehicle container - now handled by vehicle-responsive.js and CSS file */

/* Base vehicle image - responsive */
.base-vehicle {
    width: 100%;
    height: auto;
    display: block;
    max-width: 1005px;
}

/* Panel overlay base styling - responsive positioning */
.panel-overlay {
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0; /* Start invisible */
    position: absolute !important;
    /* Scale with the base vehicle image */
}

/* Hover effects for panels - red highlight when hovering (only if no condition set) */
.panel-overlay:not(.condition-good):not(.condition-average):not(.condition-bad):hover {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* Active state - temporary red highlight (only if no condition set) */
.panel-overlay:not(.condition-good):not(.condition-average):not(.condition-bad).active {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* Condition-based persistent colors - these take priority */
.panel-overlay.condition-good {
    opacity: 0.8 !important;
    /* Green #277020 */
    filter: brightness(0) saturate(100%) invert(25%) sepia(98%) saturate(1044%) hue-rotate(73deg) brightness(92%) contrast(101%) !important;
}

.panel-overlay.condition-average {
    opacity: 0.8 !important;
    /* Orange #f5a409 */
    filter: brightness(0) saturate(100%) invert(66%) sepia(68%) saturate(3428%) hue-rotate(8deg) brightness(102%) contrast(95%) !important;
}

.panel-overlay.condition-bad {
    opacity: 0.8 !important;
    /* Red #c62121 */
    filter: brightness(0) saturate(100%) invert(16%) sepia(90%) saturate(3122%) hue-rotate(348deg) brightness(93%) contrast(87%) !important;
}

/* Form label hover effects */
.form-label-wrapper {
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.form-label-wrapper:hover,
.form-label-wrapper.active {
    background-color: rgba(220, 53, 69, 0.2);
}

/* Panel assessment highlighting */
.panel-assessment {
    border-left: 3px solid transparent;
    padding-left: 10px;
    transition: all 0.3s ease;
    margin-bottom: 8px;
}

.panel-assessment.highlighted {
    border-left-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.05);
}

/* Responsive design for tablets and mobile */
@media (max-width: 991px) {
    .vehicle-container {
        max-width: 100%;
    }
    
    .col-lg-6 {
        margin-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .form-select-sm, .form-control-sm {
        font-size: 14px;
    }
    
    .row.g-2 > div {
        margin-bottom: 5px;
    }
}
</style>
@endsection

@section('additional-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Initialize responsive overlay scaling
    // Responsive overlay scaling is handled by vehicle-responsive.js automatically
    
    // Panel names for form generation
    const panelNames = [
        { id: 'windscreen', name: 'Windscreen' },
        { id: 'bonnet', name: 'Bonnet' },
        { id: 'boot', name: 'Boot' },
        { id: 'roof', name: 'Roof' },
        { id: 'rear-window', name: 'Rear Window' },
        { id: 'front-bumper', name: 'Front Bumper' },
        { id: 'rear-bumper', name: 'Rear Bumper' },
        { id: 'lf-headlight', name: 'Left Front Headlight' },
        { id: 'fr-headlight', name: 'Right Front Headlight' },
        { id: 'lr-taillight', name: 'Left Rear Taillight' },
        { id: 'rr-taillight', name: 'Right Rear Taillight' },
        { id: 'lf-mirror', name: 'Left Front Mirror' },
        { id: 'fr-mirror', name: 'Right Front Mirror' },
        { id: 'lf-fender', name: 'Left Front Fender' },
        { id: 'fr-fender', name: 'Right Front Fender' },
        { id: 'lf-door', name: 'Left Front Door' },
        { id: 'fr-door', name: 'Right Front Door' },
        { id: 'lr-door', name: 'Left Rear Door' },
        { id: 'rr-door', name: 'Right Rear Door' },
        { id: 'lr-quarter-panel', name: 'Left Rear Quarter Panel' },
        { id: 'rr-quarter-panel', name: 'Right Rear Quarter Panel' }
    ];

    // Generate form fields for each panel
    const assessmentContainer = document.getElementById('panelAssessments');
    panelNames.forEach(panelInfo => {
        const panelDiv = document.createElement('div');
        panelDiv.className = 'panel-assessment';
        panelDiv.dataset.panel = panelInfo.id;
        
        panelDiv.innerHTML = `
            <div class="form-label-wrapper p-2 rounded" data-panel-label="${panelInfo.id}">
                <label class="form-label fw-bold mb-1">${panelInfo.name}</label>
            </div>
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select form-select-sm" name="${panelInfo.id}-condition">
                        <option value="">Condition</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="bad">Bad</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select form-select-sm" name="${panelInfo.id}-comments">
                        <option value="">Comments</option>
                        <option value="scratched">Scratched</option>
                        <option value="dented">Dented</option>
                        <option value="cracked">Cracked</option>
                        <option value="repainted">Repainted</option>
                        <option value="replaced">Replaced</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" 
                           name="${panelInfo.id}-additional" placeholder="Additional comments">
                </div>
            </div>
        `;
        
        assessmentContainer.appendChild(panelDiv);
    });

    // Two-way highlighting functionality
    const panelOverlays = document.querySelectorAll('.panel-overlay');
    const formLabels = document.querySelectorAll('.form-label-wrapper');
    const panelAssessments = document.querySelectorAll('.panel-assessment');

    // Handle panel click
    panelOverlays.forEach(overlay => {
        const panelId = overlay.dataset.panel;
        
        // Click handler - highlights form field
        overlay.addEventListener('click', function() {
            // Remove active class from all panels and labels
            panelOverlays.forEach(p => p.classList.remove('active'));
            formLabels.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked panel and corresponding form label
            this.classList.add('active');
            const correspondingLabel = document.querySelector(`[data-panel-label="${panelId}"]`);
            if (correspondingLabel) {
                correspondingLabel.classList.add('active');
                // Scroll form into view
                correspondingLabel.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        // Hover handlers for visual feedback
        overlay.addEventListener('mouseenter', function() {
            const correspondingAssessment = document.querySelector(`.panel-assessment[data-panel="${panelId}"]`);
            if (correspondingAssessment) {
                correspondingAssessment.classList.add('highlighted');
            }
        });
        
        overlay.addEventListener('mouseleave', function() {
            const correspondingAssessment = document.querySelector(`.panel-assessment[data-panel="${panelId}"]`);
            if (correspondingAssessment) {
                correspondingAssessment.classList.remove('highlighted');
            }
        });
    });

    // Handle form label hover - highlights corresponding panel
    formLabels.forEach(label => {
        const panelId = label.dataset.panelLabel;
        
        label.addEventListener('mouseenter', function() {
            const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
            if (correspondingPanel && 
                !correspondingPanel.classList.contains('condition-good') && 
                !correspondingPanel.classList.contains('condition-average') && 
                !correspondingPanel.classList.contains('condition-bad')) {
                correspondingPanel.classList.add('active');
            }
        });
        
        label.addEventListener('mouseleave', function() {
            const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
            if (correspondingPanel) {
                correspondingPanel.classList.remove('active');
            }
        });
        
        // Click handler for form labels
        label.addEventListener('click', function() {
            const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
            if (correspondingPanel) {
                // Trigger click on the panel
                correspondingPanel.click();
            }
        });
    });
    
    // Handle condition changes - update panel colors
    const conditionSelects = document.querySelectorAll('select[name$="-condition"]');
    conditionSelects.forEach(select => {
        select.addEventListener('change', function() {
            const panelName = this.name.replace('-condition', '');
            const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelName}"]`);
            
            if (correspondingPanel) {
                // Remove existing condition classes
                correspondingPanel.classList.remove('condition-good', 'condition-average', 'condition-bad', 'active');
                
                // Add new condition class
                if (this.value) {
                    correspondingPanel.classList.add(`condition-${this.value}`);
                }
            }
        });
    });

    // Form submission handler
    document.getElementById('panelAssessmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Collect form data
        const formData = new FormData(this);
        const assessmentData = {};
        
        for (let [key, value] of formData.entries()) {
            if (value && key !== '_token') {
                assessmentData[key] = value;
            }
        }
        
        console.log('Assessment Data:', assessmentData);
        alert('Assessment saved! (Frontend only - backend integration pending)');
    });

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        // Save current progress before going back
        saveCurrentProgress();
        window.location.href = '/inspection/visual';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        saveCurrentProgress();
        alert('Assessment draft saved successfully!');
    });

    // Update form submission to proceed to next section
    document.getElementById('panelAssessmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save the panel assessment data
        saveCurrentProgress();
        
        // Navigate to specific area images section
        window.location.href = '/inspection/specific-areas';
    });
});

// Responsive overlay scaling is now handled by vehicle-responsive.js

// Load previous visual inspection data and display summary
function loadPreviousData() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    if (visualData) {
        const data = JSON.parse(visualData);
        
        // Display inspection summary at top of page
        displayInspectionSummary(data);
        
        // Load any existing panel assessment data
        const panelData = sessionStorage.getItem('panelAssessmentData');
        if (panelData) {
            restorePanelAssessments(JSON.parse(panelData));
        }
    }
}

// Display summary of visual inspection data
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
                Images: ${data.images ? data.images.length : 0} uploaded
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

// Save current panel assessment progress
function saveCurrentProgress() {
    const formData = new FormData(document.getElementById('panelAssessmentForm'));
    const panelData = {};
    
    for (let [key, value] of formData.entries()) {
        if (value && key !== '_token') {
            panelData[key] = value;
        }
    }
    
    sessionStorage.setItem('panelAssessmentData', JSON.stringify(panelData));
}

// Restore previous panel assessments
function restorePanelAssessments(data) {
    Object.keys(data).forEach(key => {
        const field = document.querySelector(`[name="${key}"]`);
        if (field) {
            field.value = data[key];
            
            // If it's a condition field, update panel color
            if (key.endsWith('-condition') && data[key]) {
                const panelName = key.replace('-condition', '');
                const panel = document.querySelector(`.panel-overlay[data-panel="${panelName}"]`);
                if (panel) {
                    panel.classList.remove('condition-good', 'condition-average', 'condition-bad');
                    panel.classList.add(`condition-${data[key]}`);
                }
            }
        }
    });
}
</script>
<script src="{{ asset('js/vehicle-responsive.js') }}"></script>
@endsection