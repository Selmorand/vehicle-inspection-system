@extends('layouts.app')

@section('title', 'Body Panel Assessment')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inspection.visual') }}">Visual Inspection</a></li>
                <li class="breadcrumb-item active" aria-current="page">Body Panel Assessment</li>
                <li class="breadcrumb-item">Specific Area Images</li>
            </ol>
        </nav>
        
        <!-- Title -->
        <div class="text-center">
            <h1 class="text-gradient display-6 mb-2">ALPHA Inspection</h1>
            <h2 class="h4 mb-3" style="color: #4f959b !important;">Body Panel Assessment</h2>
            <p class="text-muted">Click on vehicle panels or hover over form labels to highlight areas</p>
        </div>
    </div>

    <div class="row">
        <!-- Vehicle Visual Section - EXACTLY like Interior -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Vehicle Body Panels</h5>
                </div>
                <div class="card-body">
                    <div class="assessment-wrapper">
                        <div class="vehicle-container">
                            <!-- Base vehicle image -->
                            <img src="/images/panels/FullVehicle.png" 
                                 alt="Vehicle View" 
                                 class="base-vehicle" 
                                 id="baseVehicle">
                        
                        <!-- Vehicle panel overlays with percentage-based coordinates like Interior -->
                        
                        <!-- Windscreen -->
                        <img src="/images/panels/windscreen.png" 
                             class="panel-overlay" 
                             data-panel="windscreen"
                             style="position: absolute; left: 57.31%; top: 25.87%; width: 14.63%; height: 20.62%;"
                             title="Windscreen" 
                             alt="Windscreen">
                        
                        <!-- Rear Right Taillight -->
                        <img src="/images/panels/rr-taillight.png" 
                             class="panel-overlay" 
                             data-panel="rr-taillight"
                             style="position: absolute; left: 81.59%; top: 82.93%; width: 9.15%; height: 3.84%;"
                             title="RR Taillight" 
                             alt="RR Taillight">
                        
                        <!-- Rear Right Quarter Panel -->
                        <img src="/images/panels/rr-quarter-panel.png" 
                             class="panel-overlay" 
                             data-panel="rr-quarter-panel"
                             style="position: absolute; left: 5.57%; top: 7.54%; width: 26.97%; height: 10.42%;"
                             title="RR Quarter Panel" 
                             alt="RR Quarter Panel">
                        
                        <!-- Rear Right Door -->
                        <img src="/images/panels/rr-door.png" 
                             class="panel-overlay" 
                             data-panel="rr-door"
                             style="position: absolute; left: 26.47%; top: 2.07%; width: 20.80%; height: 16.56%;"
                             title="RR Door" 
                             alt="RR Door">
                        
                        <!-- Roof -->
                        <img src="/images/panels/roof.png" 
                             class="panel-overlay" 
                             data-panel="roof"
                             style="position: absolute; left: 29.75%; top: 28.09%; width: 28.16%; height: 16.33%;"
                             title="Roof" 
                             alt="Roof">
                        
                        <!-- Rear Window -->
                        <img src="/images/panels/rear-window.png" 
                             class="panel-overlay" 
                             data-panel="rear-window"
                             style="position: absolute; left: 15.82%; top: 27.20%; width: 15.62%; height: 18.48%;"
                             title="Rear Window" 
                             alt="Rear Window">
                        
                        <!-- Rear Bumper -->
                        <img src="/images/panels/rear-bumper.png" 
                             class="panel-overlay" 
                             data-panel="rear-bumper"
                             style="position: absolute; left: 59.20%; top: 87.36%; width: 33.83%; height: 5.03%;"
                             title="Rear Bumper" 
                             alt="Rear Bumper">
                        
                        <!-- Left Rear Taillight -->
                        <img src="/images/panels/lr-taillight.png" 
                             class="panel-overlay" 
                             data-panel="lr-taillight"
                             style="position: absolute; left: 61.89%; top: 82.93%; width: 9.15%; height: 3.84%;"
                             title="LR Taillight" 
                             alt="LR Taillight">
                        
                        <!-- Left Rear Quarter Panel -->
                        <img src="/images/panels/lr-quarter-panel.png" 
                             class="panel-overlay" 
                             data-panel="lr-quarter-panel"
                             style="position: absolute; left: 67.06%; top: 58.24%; width: 26.97%; height: 10.35%;"
                             title="LR Quarter Panel" 
                             alt="LR Quarter Panel">
                        
                        <!-- Left Rear Door -->
                        <img src="/images/panels/lr-door.png" 
                             class="panel-overlay" 
                             data-panel="lr-door"
                             style="position: absolute; left: 52.34%; top: 52.62%; width: 20.60%; height: 16.56%;"
                             title="LR Door" 
                             alt="LR Door">
                        
                        <!-- Left Front Mirror -->
                        <img src="/images/panels/lf-mirror.png" 
                             class="panel-overlay" 
                             data-panel="lf-mirror"
                             style="position: absolute; left: 36.62%; top: 80.93%; width: 4.78%; height: 2.36%;"
                             title="LF Mirror" 
                             alt="LF Mirror">
                        
                        <!-- Left Front Headlight -->
                        <img src="/images/panels/lf-headlight.png" 
                             class="panel-overlay" 
                             data-panel="lf-headlight"
                             style="position: absolute; left: 29.35%; top: 85.36%; width: 9.15%; height: 2.51%;"
                             title="LF Headlight" 
                             alt="LF Headlight">
                        
                        <!-- Left Front Fender -->
                        <img src="/images/panels/lf-fender.png" 
                             class="panel-overlay" 
                             data-panel="lf-fender"
                             style="position: absolute; left: 5.87%; top: 56.91%; width: 31.84%; height: 16.26%;"
                             title="LF Fender" 
                             alt="LF Fender">
                        
                        <!-- Left Front Door -->
                        <img src="/images/panels/lf-door.png" 
                             class="panel-overlay" 
                             data-panel="lf-door"
                             style="position: absolute; left: 32.64%; top: 52.85%; width: 22.99%; height: 15.67%;"
                             title="LF Door" 
                             alt="LF Door">
                        
                        <!-- Front Bumper -->
                        <img src="/images/panels/front-bumper.png" 
                             class="panel-overlay" 
                             data-panel="front-bumper"
                             style="position: absolute; left: 4.18%; top: 87.21%; width: 37.21%; height: 6.28%;"
                             title="Front Bumper" 
                             alt="Front Bumper">
                        
                        <!-- Right Front Mirror -->
                        <img src="/images/panels/fr-mirror.png" 
                             class="panel-overlay" 
                             data-panel="fr-mirror"
                             style="position: absolute; left: 3.98%; top: 80.93%; width: 4.78%; height: 2.36%;"
                             title="FR Mirror" 
                             alt="FR Mirror">
                        
                        <!-- Right Front Headlight -->
                        <img src="/images/panels/fr-headlight.png" 
                             class="panel-overlay" 
                             data-panel="fr-headlight"
                             style="position: absolute; left: 6.97%; top: 85.36%; width: 9.05%; height: 2.51%;"
                             title="FR Headlight" 
                             alt="FR Headlight">
                        
                        <!-- Right Front Fender -->
                        <img src="/images/panels/fr-fender.png" 
                             class="panel-overlay" 
                             data-panel="fr-fender"
                             style="position: absolute; left: 61.89%; top: 6.21%; width: 31.84%; height: 16.26%;"
                             title="FR Fender" 
                             alt="FR Fender">
                        
                        <!-- Right Front Door -->
                        <img src="/images/panels/fr-door.png" 
                             class="panel-overlay" 
                             data-panel="fr-door"
                             style="position: absolute; left: 44.08%; top: 2.22%; width: 22.89%; height: 15.67%;"
                             title="FR Door" 
                             alt="FR Door">
                        
                        <!-- Boot -->
                        <img src="/images/panels/boot.png" 
                             class="panel-overlay" 
                             data-panel="boot"
                             style="position: absolute; left: 7.26%; top: 26.83%; width: 14.03%; height: 19.73%;"
                             title="Boot" 
                             alt="Boot">
                        
                        <!-- Bonnet -->
                        <img src="/images/panels/bonnet.png" 
                             class="panel-overlay" 
                             data-panel="bonnet"
                             style="position: absolute; left: 68.06%; top: 24.32%; width: 26.97%; height: 24.83%;"
                             title="Bonnet" 
                             alt="Bonnet">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Form Section - EXACTLY like Interior form structure -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Panel Assessment Details</h5>
                </div>
                <div class="card-body">
                    <form id="panelAssessmentForm">
                        @csrf
                        
                        <!-- Panel assessment forms - dynamically generated -->
                        <div id="panelAssessments">
                            <!-- Forms will be generated by JavaScript -->
                        </div>

                        <div class="mt-4 d-flex justify-content-between flex-wrap">
                            <button type="button" class="btn btn-outline-secondary mb-2" onclick="window.location.href='{{ route('inspection.visual') }}'">
                                <i class="bi bi-arrow-left me-1"></i>Back to Visual Inspection
                            </button>
                            <div>
                                <button type="button" class="btn btn-secondary me-2 mb-2" onclick="saveDraft()">Save Draft</button>
                                <button type="submit" class="btn btn-primary mb-2" onclick="continueToNext()">
                                    Continue to Next Section <i class="bi bi-arrow-right ms-1"></i>
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
<style>
/* Use EXACT same styles as Interior section */
.assessment-wrapper {
    position: relative;
    width: 100%;
    max-width: 100%;
    overflow: visible;
    margin: 0 auto;
}

/* Vehicle container - responsive for tablet-first design EXACTLY like Interior */
.vehicle-container {
    position: relative;
    max-width: 1005px;
    width: 100%;
    margin: 0 auto;
    background-color: #f8f9fa;
    padding: 0;
    overflow: visible;
}

/* Responsive design for tablets and mobile EXACTLY like Interior */
@media (max-width: 991px) {
    .vehicle-container {
        max-width: 100%;
    }
}

/* Vehicle visual card body - responsive height */
.vehicle-visual-card .card-body {
    overflow: visible;
    padding: 15px;
}

/* Base vehicle image - fully responsive EXACTLY like Interior */
.base-vehicle {
    width: 100%;
    height: auto;
    display: block;
    max-width: 1005px;
}

/* Panel overlay base styling - responsive positioning using percentages EXACTLY like Interior */
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
    filter: brightness(0) saturate(100%) invert(25%) sepia(98%) saturate(1044%) hue-rotate(73deg) brightness(92%) contrast(101%) !important;
}

.panel-overlay.condition-average {
    opacity: 0.8 !important;
    filter: brightness(0) saturate(100%) invert(66%) sepia(68%) saturate(3428%) hue-rotate(8deg) brightness(102%) contrast(95%) !important;
}

.panel-overlay.condition-bad {
    opacity: 0.8 !important;
    filter: brightness(0) saturate(100%) invert(16%) sepia(90%) saturate(3122%) hue-rotate(348deg) brightness(93%) contrast(87%) !important;
}

/* Form label hover effects EXACTLY like Interior */
.form-label-wrapper {
    transition: background-color 0.3s ease;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
    margin-bottom: 5px;
}

.form-label-wrapper:hover,
.form-label-wrapper.active {
    background-color: rgba(220, 53, 69, 0.2);
}

/* Panel assessment items - show all forms initially like Interior */
.panel-assessment-item {
    border-left: 3px solid transparent;
    padding-left: 10px;
    transition: all 0.3s ease;
    margin-bottom: 15px;
    display: block; /* Show all forms like Interior */
}

.panel-assessment-item.active {
    border-left-color: var(--danger-color);
    background-color: rgba(220, 53, 69, 0.05);
}

.panel-assessment-item.show {
    display: block !important;
}

/* Additional responsive adjustments */
@media (max-width: 991px) {
    .col-lg-6 {
        margin-bottom: 20px;
    }
}

/* Custom dropdown styling */
.form-select {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 149, 155, 0.25);
}

/* Button styling */
.btn {
    white-space: nowrap;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endsection

@section('additional-js')
<script>
// Vehicle panels data - EXACTLY like Interior structure
const vehiclePanels = [
    { id: 'windscreen', name: 'Windscreen' },
    { id: 'bonnet', name: 'Bonnet' },
    { id: 'boot', name: 'Boot' },
    { id: 'roof', name: 'Roof' },
    { id: 'rear-window', name: 'Rear Window' },
    { id: 'lf-door', name: 'Left Front Door' },
    { id: 'lr-door', name: 'Left Rear Door' },
    { id: 'fr-door', name: 'Right Front Door' },
    { id: 'rr-door', name: 'Right Rear Door' },
    { id: 'lf-headlight', name: 'Left Front Headlight' },
    { id: 'fr-headlight', name: 'Right Front Headlight' },
    { id: 'lr-taillight', name: 'Left Rear Taillight' },
    { id: 'rr-taillight', name: 'Right Rear Taillight' },
    { id: 'lf-mirror', name: 'Left Front Mirror' },
    { id: 'fr-mirror', name: 'Right Front Mirror' },
    { id: 'lf-fender', name: 'Left Front Fender' },
    { id: 'fr-fender', name: 'Right Front Fender' },
    { id: 'lr-quarter-panel', name: 'Left Rear Quarter Panel' },
    { id: 'rr-quarter-panel', name: 'Right Rear Quarter Panel' },
    { id: 'front-bumper', name: 'Front Bumper' },
    { id: 'rear-bumper', name: 'Rear Bumper' }
];

// Initialize when DOM is ready - EXACTLY like Interior
document.addEventListener('DOMContentLoaded', function() {
    generatePanelAssessments();
    setupPanelInteractions();
    setupFormInteractions();
});

// Generate panel assessment forms - EXACTLY like Interior
function generatePanelAssessments() {
    const container = document.getElementById('panelAssessments');
    container.innerHTML = '';
    
    vehiclePanels.forEach(panel => {
        const panelDiv = document.createElement('div');
        panelDiv.className = 'panel-assessment-item';
        panelDiv.id = `assessment-${panel.id}`;
        
        panelDiv.innerHTML = `
            <div class="form-label-wrapper" data-panel="${panel.id}">
                <label class="form-label fw-bold">${panel.name}</label>
            </div>
            <div class="row g-2">
                <div class="col-md-6">
                    <select class="form-select" name="${panel.id}-condition">
                        <option value="">Condition</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="bad">Bad</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-select" name="${panel.id}-comment">
                        <option value="">Comments</option>
                        <option value="minor-damage">Minor Damage</option>
                        <option value="scratches">Scratches</option>
                        <option value="dents">Dents</option>
                        <option value="rust">Rust</option>
                        <option value="paint-damage">Paint Damage</option>
                    </select>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control" 
                           name="${panel.id}-additional" 
                           placeholder="Additional comments">
                </div>
            </div>
        `;
        
        container.appendChild(panelDiv);
    });
}

// Setup panel interactions - EXACTLY like Interior
function setupPanelInteractions() {
    const panelOverlays = document.querySelectorAll('.panel-overlay');
    
    panelOverlays.forEach(overlay => {
        const panelId = overlay.dataset.panel;
        
        // Click handler for panel overlays
        overlay.addEventListener('click', function() {
            showPanelAssessment(panelId);
            
            // Add temporary active class
            this.classList.add('active');
            setTimeout(() => {
                this.classList.remove('active');
            }, 500);
        });
    });
}

// Setup form interactions - EXACTLY like Interior
function setupFormInteractions() {
    const labels = document.querySelectorAll('.form-label-wrapper');
    
    labels.forEach(label => {
        const panelId = label.dataset.panel;
        const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
        
        // Click handler for form labels
        label.addEventListener('click', function() {
            showPanelAssessment(panelId);
        });
        
        // Hover effects
        label.addEventListener('mouseenter', function() {
            this.classList.add('active');
            if (correspondingPanel && !hasConditionClass(correspondingPanel)) {
                correspondingPanel.classList.add('active');
            }
        });
        
        label.addEventListener('mouseleave', function() {
            this.classList.remove('active');
            if (correspondingPanel) {
                correspondingPanel.classList.remove('active');
            }
        });
    });
    
    // Handle condition changes - update panel colors
    const conditionSelects = document.querySelectorAll('select[name$="-condition"]');
    conditionSelects.forEach(select => {
        select.addEventListener('change', function() {
            const panelId = this.name.replace('-condition', '');
            const panel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
            
            if (panel) {
                // Remove existing condition classes
                panel.classList.remove('condition-good', 'condition-average', 'condition-bad');
                
                // Add new condition class
                if (this.value) {
                    panel.classList.add(`condition-${this.value}`);
                }
            }
        });
    });
}

// Show panel assessment - highlight selected panel like Interior
function showPanelAssessment(panelId) {
    // Remove active from all assessments
    document.querySelectorAll('.panel-assessment-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Highlight selected assessment
    const assessment = document.getElementById(`assessment-${panelId}`);
    if (assessment) {
        assessment.classList.add('active');
        
        // Scroll to assessment
        assessment.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Helper function
function hasConditionClass(element) {
    return element.classList.contains('condition-good') || 
           element.classList.contains('condition-average') || 
           element.classList.contains('condition-bad');
}

// Navigation functions
function saveDraft() {
    alert('Draft saved! (This will be implemented with actual save functionality)');
}

function continueToNext() {
    window.location.href = '{{ route("inspection.specific-areas") }}';
}
</script>
<!-- Removed assessment-responsive.js to match Interior approach -->
@endsection