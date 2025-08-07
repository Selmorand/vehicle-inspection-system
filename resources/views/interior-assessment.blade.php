@extends('layouts.app')

@section('title', 'Interior Assessment')

@section('content')
<div class="container-fluid px-4">
    <!-- Progress Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/inspection/visual" style="color: var(--primary-color);">Visual Inspection</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/body-panel" style="color: var(--primary-color);">Body Panel Assessment</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Interior Assessment</li>
                    <li class="breadcrumb-item text-muted">Service Booklet</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Interior Assessment</h2>
        <p class="text-muted">Click on vehicle interior components or hover over form labels to highlight areas</p>
    </div>

    <div class="row">
        <!-- Vehicle Interior Visual Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Vehicle Interior Components</h5>
                </div>
                <div class="card-body">
                    <div class="interior-wrapper">
                        <div class="interior-container">
                            <!-- Base interior image -->
                            <img src="/images/interior/Interior.png" alt="Interior Base" class="base-interior" id="baseInterior">
                            
                            <!-- Interior panel overlays -->
                            <!-- Dash -->
                            <img src="/images/interior/dash.png" 
                                 class="panel-overlay" 
                                 data-panel="dash" 
                                 style="position: absolute; left: 44.9%; top: 10.4%; width: 13.4%; height: 12.0%;"
                                 title="Dash" 
                                 alt="Dash">
                                 
                            <!-- Centre Console -->
                            <img src="/images/interior/centre-console.png" 
                                 class="panel-overlay" 
                                 data-panel="centre-console" 
                                 style="position: absolute; left: 45.1%; top: 28.7%; width: 13.0%; height: 23.2%;"
                                 title="Centre Console" 
                                 alt="Centre Console">
                                 
                            <!-- Steering Wheel -->
                            <img src="/images/interior/steering-wheel.png" 
                                 class="panel-overlay" 
                                 data-panel="steering-wheel" 
                                 style="position: absolute; left: 38.5%; top: 18.6%; width: 8.8%; height: 14.5%;"
                                 title="Steering Wheel" 
                                 alt="Steering Wheel">
                                 
                            <!-- Driver Seat -->
                            <img src="/images/interior/driver-seat.png" 
                                 class="panel-overlay" 
                                 data-panel="driver-seat" 
                                 style="position: absolute; left: 25.4%; top: 35.8%; width: 18.3%; height: 34.1%;"
                                 title="Driver Seat" 
                                 alt="Driver Seat">
                                 
                            <!-- Passenger Seat -->
                            <img src="/images/interior/passenger-seat.png" 
                                 class="panel-overlay" 
                                 data-panel="passenger-seat" 
                                 style="position: absolute; left: 59.7%; top: 35.8%; width: 18.3%; height: 34.1%;"
                                 title="Passenger Seat" 
                                 alt="Passenger Seat">
                                 
                            <!-- FR Door Panel -->
                            <img src="/images/interior/fr-door-panel.png" 
                                 class="panel-overlay" 
                                 data-panel="fr-door-panel" 
                                 style="position: absolute; left: 79.6%; top: 23.9%; width: 20.4%; height: 50.4%;"
                                 title="FR Door Panel" 
                                 alt="FR Door Panel">
                                 
                            <!-- FL Door Panel -->
                            <img src="/images/interior/fl-door-panel.png" 
                                 class="panel-overlay" 
                                 data-panel="fl-door-panel" 
                                 style="position: absolute; left: 0.0%; top: 23.9%; width: 20.4%; height: 50.4%;"
                                 title="FL Door Panel" 
                                 alt="FL Door Panel">
                                 
                            <!-- Rear Seat -->
                            <img src="/images/interior/rear-seat.png" 
                                 class="panel-overlay" 
                                 data-panel="rear-seat" 
                                 style="position: absolute; left: 25.4%; top: 74.3%; width: 53.2%; height: 25.7%;"
                                 title="Rear Seat" 
                                 alt="Rear Seat">
                                 
                            <!-- RR Door Panel -->
                            <img src="/images/interior/rr-door-panel.png" 
                                 class="panel-overlay" 
                                 data-panel="rr-door-panel" 
                                 style="position: absolute; left: 79.6%; top: 74.3%; width: 20.4%; height: 25.7%;"
                                 title="RR Door Panel" 
                                 alt="RR Door Panel">
                                 
                            <!-- LR Door Panel -->
                            <img src="/images/interior/lr-door-panel.png" 
                                 class="panel-overlay" 
                                 data-panel="lr-door-panel" 
                                 style="position: absolute; left: 0.0%; top: 74.3%; width: 20.4%; height: 25.7%;"
                                 title="LR Door Panel" 
                                 alt="LR Door Panel">
                                 
                            <!-- Backboard -->
                            <img src="/images/interior/backboard.png" 
                                 class="panel-overlay" 
                                 data-panel="backboard" 
                                 style="position: absolute; left: 25.4%; top: 70.0%; width: 53.2%; height: 4.3%;"
                                 title="Backboard" 
                                 alt="Backboard">
                                 
                            <!-- Boot -->
                            <img src="/images/interior/boot.png" 
                                 class="panel-overlay" 
                                 data-panel="boot" 
                                 style="position: absolute; left: 38.5%; top: 2.5%; width: 26.8%; height: 7.9%;"
                                 title="Boot" 
                                 alt="Boot">
                                 
                            <!-- Gear Lever -->
                            <img src="/images/interior/gearlever.png" 
                                 class="panel-overlay" 
                                 data-panel="gearlever" 
                                 style="position: absolute; left: 50.7%; top: 51.9%; width: 7.4%; height: 8.6%;"
                                 title="Gear Lever" 
                                 alt="Gear Lever">
                                 
                            <!-- Buttons -->
                            <img src="/images/interior/buttons.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons" 
                                 style="position: absolute; left: 49.3%; top: 22.5%; width: 5.6%; height: 6.2%;"
                                 title="Buttons" 
                                 alt="Buttons">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Interior Assessment Form -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Interior Assessment Details</h5>
                </div>
                <div class="card-body">
                    <form id="interiorAssessmentForm">
                        @csrf
                        
                        <!-- Dynamic interior assessments will be generated by JavaScript -->
                        <div id="interiorAssessments">
                            <!-- Interior forms will be added here -->
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" id="backBtn">
                                <i class="bi bi-arrow-left me-1"></i>Back to Body Panel Assessment
                            </button>
                            <div class="button-group-responsive">
                                <button type="button" class="btn btn-secondary me-2 mb-2" id="saveDraftBtn">Save Draft</button>
                                <button type="submit" class="btn btn-primary mb-2" id="nextBtn">
                                    Continue to Service Booklet <i class="bi bi-arrow-right ms-1"></i>
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
<link rel="stylesheet" href="{{ asset('css/panel-cards.css') }}">
<style>
/* Interior container and base styling */
.interior-container {
    position: relative;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
}

.base-interior {
    width: 100%;
    height: auto;
    display: block;
}

/* Panel overlay styling */
.panel-overlay {
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0;
    position: absolute !important;
}

/* Hover effects for panels */
.panel-overlay:hover {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

.panel-overlay.active {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
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
    // Initialize the reusable InspectionCards system for interior assessment
    InspectionCards.init({
        // Required Configuration
        formId: 'interiorAssessmentForm',
        containerId: 'interiorAssessments',
        storageKey: 'interiorAssessmentData',
        
        // Interior specific configuration
        hasColorField: true,
        hasOverlays: true,
        overlaySelector: '.panel-overlay',
        
        // Color options for interior
        colorOptions: [
            { value: '', text: 'Select Color' },
            { value: 'Red & Black', text: 'Red & Black' },
            { value: 'Black', text: 'Black' },
            { value: 'Grey', text: 'Grey' },
            { value: 'Beige', text: 'Beige' },
            { value: 'Brown', text: 'Brown' },
            { value: 'Blue', text: 'Blue' },
            { value: 'Other', text: 'Other' }
        ],
        
        // Interior items data
        items: [
            { id: 'interior_77', category: 'Dash', panelId: 'dash' },
            { id: 'interior_78', category: 'Steering Wheel', panelId: 'steering-wheel' },
            { id: 'interior_79', category: 'Buttons', panelId: 'buttons' },
            { id: 'interior_80', category: 'Driver Seat', panelId: 'driver-seat' },
            { id: 'interior_81', category: 'Passenger Seat', panelId: 'passenger-seat' },
            { id: 'interior_82', category: 'Rooflining', panelId: null },
            { id: 'interior_83', category: 'FR Door Panel', panelId: 'fr-door-panel' },
            { id: 'interior_84', category: 'FL Door Panel', panelId: 'fl-door-panel' },
            { id: 'interior_85', category: 'Rear Seat', panelId: 'rear-seat' },
            { id: 'interior_86', category: 'Additional Seats', panelId: null },
            { id: 'interior_87', category: 'Backboard', panelId: 'backboard' },
            { id: 'interior_88', category: 'RR Door Panel', panelId: 'rr-door-panel' },
            { id: 'interior_89', category: 'LR Door Panel', panelId: 'lr-door-panel' },
            { id: 'interior_90', category: 'Boot', panelId: 'boot' },
            { id: 'interior_91', category: 'Centre Console', panelId: 'centre-console' },
            { id: 'interior_92', category: 'Gear Lever', panelId: 'gearlever' },
            { id: 'interior_93', category: 'Other', panelId: null }
        ],
        
        // Custom field configuration for interior
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
            sessionStorage.setItem('interiorAssessmentData', JSON.stringify(data));
            window.location.href = '/inspection/service-booklet';
        }
    });
    
    // Handle navigation buttons
    document.getElementById('backBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to go back? Any unsaved data will be lost.')) {
            window.location.href = '/inspection/body-panel';
        }
    });
    
    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        InspectionCards.saveData();
        alert('Draft saved successfully!');
    });
    
    document.getElementById('nextBtn').addEventListener('click', function() {
        InspectionCards.saveData();
        window.location.href = '/inspection/service-booklet';
    });
});
</script>
@endsection