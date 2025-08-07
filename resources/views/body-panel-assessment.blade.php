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
                    <li class="breadcrumb-item text-muted">Interior Assessment</li>
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
                             style="position: absolute; left: 756px; top: 1075px; width: 95px; height: 33px;"
                             title="RR Taillight" 
                             alt="RR Taillight">
                             
                        <!-- Rear Left Taillight -->
                        <img src="/images/panels/lr-taillight.png" 
                             class="panel-overlay" 
                             data-panel="lr-taillight" 
                             style="position: absolute; left: 158px; top: 225px; width: 95px; height: 33px;"
                             title="LR Taillight" 
                             alt="LR Taillight">
                             
                        <!-- Rear Bumper -->
                        <img src="/images/panels/rear-bumper.png" 
                             class="panel-overlay" 
                             data-panel="rear-bumper" 
                             style="position: absolute; left: 588px; top: 1180px; width: 374px; height: 85px;"
                             title="Rear Bumper" 
                             alt="Rear Bumper">
                             
                        <!-- Rear Window -->
                        <img src="/images/panels/rear-window.png" 
                             class="panel-overlay" 
                             data-panel="rear-window" 
                             style="position: absolute; left: 428px; top: 695px; width: 147px; height: 279px;"
                             title="Rear Window" 
                             alt="Rear Window">
                             
                        <!-- Roof -->
                        <img src="/images/panels/roof.png" 
                             class="panel-overlay" 
                             data-panel="roof" 
                             style="position: absolute; left: 380px; top: 400px; width: 244px; height: 552px;"
                             title="Roof" 
                             alt="Roof">
                             
                        <!-- Boot -->
                        <img src="/images/panels/boot.png" 
                             class="panel-overlay" 
                             data-panel="boot" 
                             style="position: absolute; left: 575px; top: 975px; width: 147px; height: 205px;"
                             title="Boot" 
                             alt="Boot">
                             
                        <!-- Bonnet -->
                        <img src="/images/panels/bonnet.png" 
                             class="panel-overlay" 
                             data-panel="bonnet" 
                             style="position: absolute; left: 283px; top: 175px; width: 147px; height: 205px;"
                             title="Bonnet" 
                             alt="Bonnet">
                             
                        <!-- Right Rear Quarter Panel -->
                        <img src="/images/panels/rr-quarter-panel.png" 
                             class="panel-overlay" 
                             data-panel="rr-quarter-panel" 
                             style="position: absolute; left: 677px; top: 690px; width: 231px; height: 294px;"
                             title="RR Quarter Panel" 
                             alt="RR Quarter Panel">
                             
                        <!-- Left Rear Quarter Panel -->
                        <img src="/images/panels/lr-quarter-panel.png" 
                             class="panel-overlay" 
                             data-panel="lr-quarter-panel" 
                             style="position: absolute; left: 98px; top: 370px; width: 231px; height: 294px;"
                             title="LR Quarter Panel" 
                             alt="LR Quarter Panel">
                             
                        <!-- Right Rear Door -->
                        <img src="/images/panels/rr-door.png" 
                             class="panel-overlay" 
                             data-panel="rr-door" 
                             style="position: absolute; left: 446px; top: 640px; width: 231px; height: 212px;"
                             title="RR Door" 
                             alt="RR Door">
                             
                        <!-- Left Rear Door -->
                        <img src="/images/panels/lr-door.png" 
                             class="panel-overlay" 
                             data-panel="lr-door" 
                             style="position: absolute; left: 326px; top: 501px; width: 231px; height: 212px;"
                             title="LR Door" 
                             alt="LR Door">
                             
                        <!-- Left Front Mirror -->
                        <img src="/images/panels/lf-mirror.png" 
                             class="panel-overlay" 
                             data-panel="lf-mirror" 
                             style="position: absolute; left: 918px; top: 225px; width: 48px; height: 32px;"
                             title="LF Mirror" 
                             alt="LF Mirror">
                             
                        <!-- Left Front Headlight -->
                        <img src="/images/panels/lf-headlight.png" 
                             class="panel-overlay" 
                             data-panel="lf-headlight" 
                             style="position: absolute; left: 844px; top: 159px; width: 91px; height: 34px;"
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Panel Assessment Form -->
        <div class="col-lg-6 mb-4">
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
                            <div class="button-group-responsive">
                                <button type="button" class="btn btn-secondary me-2 mb-2" id="saveDraftBtn">Save Draft</button>
                                <button type="submit" class="btn btn-primary mb-2" id="nextBtn">
                                    Continue to Interior Assessment <i class="bi bi-arrow-right ms-1"></i>
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
<link rel="stylesheet" href="{{ asset('css/panel-cards.css') }}">
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

/* Condition-based persistent colors for body panels */
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

/* Panel card highlighting */
.panel-card.highlighted {
    border-color: #dc3545;
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
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
    
    /* Make the button container stack vertically on tablets */
    .mt-4.d-flex.justify-content-between {
        flex-direction: column !important;
        gap: 10px;
    }
    
    #backBtn {
        width: 100%;
        margin-bottom: 5px;
    }
}

/* Ensure 5px margin bottom for Save Draft on all screen sizes */
#saveDraftBtn {
    margin-bottom: 5px !important;
}
</style>
@endsection

@section('additional-js')
<script src="{{ asset('js/inspection-cards.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the reusable InspectionCards system
    InspectionCards.init({
        // Required Configuration
        formId: 'panelAssessmentForm',
        containerId: 'panelAssessments',
        storageKey: 'panelAssessmentData',
        
        // Body Panel specific configuration
        hasOverlays: true,
        overlaySelector: '.panel-overlay',
        
        // Panel items data
        items: [
            { id: 'windscreen', category: 'Windscreen', panelId: 'windscreen' },
            { id: 'bonnet', category: 'Bonnet', panelId: 'bonnet' },
            { id: 'boot', category: 'Boot', panelId: 'boot' },
            { id: 'roof', category: 'Roof', panelId: 'roof' },
            { id: 'rear-window', category: 'Rear Window', panelId: 'rear-window' },
            { id: 'front-bumper', category: 'Front Bumper', panelId: 'front-bumper' },
            { id: 'rear-bumper', category: 'Rear Bumper', panelId: 'rear-bumper' },
            { id: 'lf-headlight', category: 'Left Front Headlight', panelId: 'lf-headlight' },
            { id: 'fr-headlight', category: 'Right Front Headlight', panelId: 'fr-headlight' },
            { id: 'lr-taillight', category: 'Left Rear Taillight', panelId: 'lr-taillight' },
            { id: 'rr-taillight', category: 'Right Rear Taillight', panelId: 'rr-taillight' },
            { id: 'lf-mirror', category: 'Left Front Mirror', panelId: 'lf-mirror' },
            { id: 'fr-mirror', category: 'Right Front Mirror', panelId: 'fr-mirror' },
            { id: 'lf-fender', category: 'Left Front Fender', panelId: 'lf-fender' },
            { id: 'fr-fender', category: 'Right Front Fender', panelId: 'fr-fender' },
            { id: 'lf-door', category: 'Left Front Door', panelId: 'lf-door' },
            { id: 'fr-door', category: 'Right Front Door', panelId: 'fr-door' },
            { id: 'lr-door', category: 'Left Rear Door', panelId: 'lr-door' },
            { id: 'rr-door', category: 'Right Rear Door', panelId: 'rr-door' },
            { id: 'lr-quarter-panel', category: 'Left Rear Quarter Panel', panelId: 'lr-quarter-panel' },
            { id: 'rr-quarter-panel', category: 'Right Rear Quarter Panel', panelId: 'rr-quarter-panel' }
        ],
        
        // Custom field configuration
        fields: {
            condition: { 
                enabled: true, 
                label: 'Condition', 
                options: ['Good', 'Average', 'Bad'] 
            },
            comments: { 
                enabled: true, 
                label: 'Additional comments', 
                type: 'text', 
                placeholder: 'Additional comments' 
            }
        },
        
        // Callback for form submission
        onFormSubmit: function(data) {
            sessionStorage.setItem('panelAssessmentData', JSON.stringify(data));
            window.location.href = '/inspection/interior';
        }
    });
    
    // Handle navigation buttons
    document.getElementById('backBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to go back? Any unsaved data will be lost.')) {
            window.location.href = '/inspection/visual';
        }
    });
    
    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        InspectionCards.saveData();
        alert('Draft saved successfully!');
    });
    
    document.getElementById('nextBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form submission
        InspectionCards.saveData();
        window.location.href = '/inspection/interior';
    });
});
</script>
<script src="{{ asset('js/vehicle-responsive.js') }}"></script>
@endsection