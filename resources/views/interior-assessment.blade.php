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
                            <img src="/images/interior/interiorMain.png" alt="Interior Base" class="base-interior" id="baseInterior">
                            
                            <!-- Interior panel overlays with correct positioning -->
                            <!-- Dash -->
                            <img src="/images/interior/Dash.png" 
                                 class="panel-overlay" 
                                 data-panel="dash"
                                 style="position: absolute; left: 6.07%; top: 4.25%; width: 88.36%; height: 17.68%; z-index: 2;"
                                 title="Dash" 
                                 alt="Dash">
                        
                            <!-- Steering Wheel -->
                            <img src="/images/interior/steering-wheel.png" 
                                 class="panel-overlay" 
                                 data-panel="steering-wheel"
                                 style="position: absolute; left: 59.20%; top: 17.68%; width: 23.88%; height: 8.56%; z-index: 3;"
                                 title="Steering Wheel" 
                                 alt="Steering Wheel">
                        
                            <!-- Individual Button Components - All as one group with z-index 100 -->
                            <img src="/images/interior/buttons-RF.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 87.16%; top: 19.69%; width: 8.46%; height: 5.92%;"
                                 title="Buttons RF" 
                                 alt="Buttons RF">
                        
                            <img src="/images/interior/buttons-centre.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 47.36%; top: 18.86%; width: 6.47%; height: 4.59%;"
                                 title="Buttons Centre" 
                                 alt="Buttons Centre">
                        
                            <img src="/images/interior/buttons-ML.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 45.27%; top: 26.72%; width: 2.99%; height: 2.92%;"
                                 title="Buttons ML" 
                                 alt="Buttons ML">
                        
                            <img src="/images/interior/buttons-MR.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 52.44%; top: 26.93%; width: 2.99%; height: 2.78%;"
                                 title="Buttons MR" 
                                 alt="Buttons MR">
                        
                            <img src="/images/interior/buttons-FL.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 7.66%; top: 22.61%; width: 3.58%; height: 2.51%;"
                                 title="Buttons FL" 
                                 alt="Buttons FL">
                        
                            <img src="/images/interior/buttons-RL.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 10.35%; top: 51.42%; width: 3.28%; height: 2.30%;"
                                 title="Buttons RL" 
                                 alt="Buttons RL">
                        
                            <img src="/images/interior/buttons-RR.png" 
                                 class="panel-overlay buttons-group" 
                                 data-panel="buttons"
                                 style="position: absolute; left: 87.66%; top: 50.87%; width: 3.88%; height: 2.71%;"
                                 title="Buttons RR" 
                                 alt="Buttons RR">
                        
                            <!-- Driver Seat -->
                            <img src="/images/interior/driver-seat.png" 
                                 class="panel-overlay" 
                                 data-panel="driver-seat"
                                 style="position: absolute; left: 55.52%; top: 18.86%; width: 34.43%; height: 31.25%; z-index: 2;"
                                 title="Driver Seat" 
                                 alt="Driver Seat">
                        
                            <!-- Passenger Seat -->
                            <img src="/images/interior/passenger-seat.png" 
                                 class="panel-overlay" 
                                 data-panel="passenger-seat"
                                 style="position: absolute; left: 11.44%; top: 20.74%; width: 33.03%; height: 29.23%; z-index: 2;"
                                 title="Passenger Seat" 
                                 alt="Passenger Seat">
                        
                            <!-- FR Door Panel -->
                            <img src="/images/interior/fr-dOORPANEL.png" 
                                 class="panel-overlay" 
                                 data-panel="fr-door-panel"
                                 style="position: absolute; left: 87.86%; top: 14.13%; width: 9.65%; height: 32.78%; z-index: 2;"
                                 title="FR Door Panel" 
                                 alt="FR Door Panel">
                        
                            <!-- FL Door Panel -->
                            <img src="/images/interior/FL Doorpanel.png" 
                                 class="panel-overlay" 
                                 data-panel="fl-door-panel"
                                 style="position: absolute; left: 3.08%; top: 14.13%; width: 10.05%; height: 33.47%; z-index: 2;"
                                 title="FL Door Panel" 
                                 alt="FL Door Panel">
                        
                            <!-- Rear Seat -->
                            <img src="/images/interior/Rear-Seat.png" 
                                 class="panel-overlay" 
                                 data-panel="rear-seat"
                                 style="position: absolute; left: 13.03%; top: 49.55%; width: 73.33%; height: 27.84%; z-index: 2;"
                                 title="Rear Seat" 
                                 alt="Rear Seat">
                        
                            <!-- Backboard -->
                            <img src="/images/interior/backboard.png" 
                                 class="panel-overlay" 
                                 data-panel="backboard"
                                 style="position: absolute; left: 10.65%; top: 76.53%; width: 80.80%; height: 19.14%; z-index: 2;"
                                 title="Backboard" 
                                 alt="Backboard">
                        
                            <!-- RR Door Panel -->
                            <img src="/images/interior/RR-Door-Panel.png" 
                                 class="panel-overlay" 
                                 data-panel="rr-door-panel"
                                 style="position: absolute; left: 84.98%; top: 47.11%; width: 11.84%; height: 30.83%; z-index: 2;"
                                 title="RR Door Panel" 
                                 alt="RR Door Panel">
                        
                            <!-- LR Door Panel -->
                            <img src="/images/interior/LR-DoorPanel.png" 
                                 class="panel-overlay" 
                                 data-panel="lr-door-panel"
                                 style="position: absolute; left: 4.38%; top: 47.18%; width: 13.03%; height: 30.83%; z-index: 2;"
                                 title="LR Door Panel" 
                                 alt="LR Door Panel">
                        
                            <!-- Boot -->
                            <img src="/images/interior/Boot.png" 
                                 class="panel-overlay" 
                                 data-panel="boot"
                                 style="position: absolute; left: 10.25%; top: 91.15%; width: 80.70%; height: 8.70%; z-index: 2;"
                                 title="Boot" 
                                 alt="Boot">
                        
                            <!-- Centre Console -->
                            <img src="/images/interior/Centre-Consol.png" 
                                 class="panel-overlay" 
                                 data-panel="centre-console"
                                 style="position: absolute; left: 39.20%; top: 17.82%; width: 22.59%; height: 33.68%; z-index: 2;"
                                 title="Centre Console" 
                                 alt="Centre Console">
                        
                            <!-- Gear Lever -->
                            <img src="/images/interior/Gear-Lever.png" 
                                 class="panel-overlay" 
                                 data-panel="gearlever"
                                 style="position: absolute; left: 47.56%; top: 27.00%; width: 5.37%; height: 4.52%; z-index: 4;"
                                 title="Gear Lever" 
                                 alt="Gear Lever">
                        
                            <!-- Air Vents -->
                            <img src="/images/interior/Airvents.png" 
                                 class="panel-overlay" 
                                 data-panel="air-vents"
                                 style="position: absolute; left: 7.06%; top: 12.67%; width: 86.37%; height: 10.44%; z-index: 2;"
                                 title="Air Vents" 
                                 alt="Air Vents">

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
/* Interior container - responsive for tablet-first design */
.interior-container {
    position: relative;
    max-width: 1005px;
    width: 100%;
    margin: 0 auto;
    background-color: #f8f9fa;
    padding: 0;
    overflow: visible;
}

/* Base interior image - fully responsive */
.base-interior {
    width: 100%;
    height: auto;
    display: block;
    max-width: 1005px;
}

/* Panel overlay styling */
.panel-overlay {
    cursor: pointer;
    transition: all 0.3s ease;
    /*opacity: 0.15;*/
    position: absolute !important;
   
}

/* Buttons group with higher z-index */
.buttons-group {
    z-index: 100 !important;
}

/* Hover effects for panels */
.panel-overlay:hover {
    opacity: 0.7;
    
}

.panel-overlay.active {
    opacity: 0.7;
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
    // Wait a moment for any other scripts to initialize
    setTimeout(() => {
        // Handle buttons group as a single unit
        const buttonsGroup = document.querySelectorAll('.buttons-group');
        console.log('Found button elements:', buttonsGroup.length); // Debug
        
        // Function to handle all buttons as one
        function syncButtonsState(action, activeState = null) {
            const allButtons = document.querySelectorAll('.buttons-group');
            allButtons.forEach(btn => {
                if (action === 'toggle') {
                    if (activeState) {
                        btn.classList.add('active');
                        btn.style.opacity = '0.7';
                    } else {
                        btn.classList.remove('active');
                        btn.style.opacity = '';
                    }
                } else if (action === 'hover') {
                    btn.style.opacity = '0.7';
                } else if (action === 'leave') {
                    if (!btn.classList.contains('active')) {
                        btn.style.opacity = '';
                    }
                }
            });
        }
    
    buttonsGroup.forEach((button, index) => {
        console.log(`Button ${index}:`, button.alt, button.className); // Debug each button
        
        // Ensure consistent opacity initially
        button.style.opacity = '';
        
        // Click handler - all buttons act as one
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isActive = this.classList.contains('active');
            syncButtonsState('toggle', !isActive);
            
            // Also trigger the form panel for buttons
            const buttonsFormPanel = document.querySelector('#interiorAssessments [data-panel-id="interior_79"]');
            if (buttonsFormPanel) {
                buttonsFormPanel.scrollIntoView({ behavior: 'smooth' });
            }
        });
        
        // Hover handlers - all buttons respond together
        button.addEventListener('mouseenter', function(e) {
            e.stopPropagation();
            syncButtonsState('hover');
        });
        
        button.addEventListener('mouseleave', function(e) {
            e.stopPropagation();
            syncButtonsState('leave');
        });
    });
    }, 100); // End of setTimeout
    
    // Override the panel highlighting for buttons to highlight all button overlays
    const originalHighlightPanel = window.highlightPanel || function() {};
    window.highlightPanel = function(panelId) {
        if (panelId === 'buttons') {
            // Highlight all button overlays together
            document.querySelectorAll('.buttons-group').forEach(btn => {
                btn.classList.add('active');
                btn.style.opacity = '0.7';
            });
        } else {
            // For other panels, use default behavior
            originalHighlightPanel(panelId);
        }
    };
    
    // Override the panel unhighlighting for buttons
    const originalUnhighlightPanel = window.unhighlightPanel || function() {};
    window.unhighlightPanel = function(panelId) {
        if (panelId === 'buttons') {
            // Unhighlight all button overlays together
            document.querySelectorAll('.buttons-group').forEach(btn => {
                btn.classList.remove('active');
                btn.style.opacity = '';
            });
        } else {
            // For other panels, use default behavior
            originalUnhighlightPanel(panelId);
        }
    };
    
    // Watch for changes to the buttons panel card title
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const target = mutation.target;
                if (target.dataset.panelLabel === 'buttons') {
                    const isActive = target.classList.contains('active');
                    document.querySelectorAll('.buttons-group').forEach(btn => {
                        if (isActive) {
                            btn.classList.add('active');
                            btn.style.opacity = '0.7';
                        } else {
                            btn.classList.remove('active');
                            btn.style.opacity = '';
                        }
                    });
                }
            }
        });
    });
    
    // Start observing after cards are initialized
    setTimeout(() => {
        const panelTitles = document.querySelectorAll('.panel-card-title');
        panelTitles.forEach(title => {
            observer.observe(title, { attributes: true, attributeFilter: ['class'] });
            
            // Add hover and click handlers for buttons panel
            if (title.dataset.panelLabel === 'buttons') {
                // Click handler
                title.addEventListener('click', function() {
                    setTimeout(() => {
                        const isActive = this.classList.contains('active');
                        document.querySelectorAll('.buttons-group').forEach(btn => {
                            if (isActive) {
                                btn.classList.add('active');
                                btn.style.opacity = '0.7';
                            } else {
                                btn.classList.remove('active');
                                btn.style.opacity = '';
                            }
                        });
                    }, 10);
                });
                
                // Hover handlers - highlight all buttons when hovering over form panel
                title.addEventListener('mouseenter', function() {
                    document.querySelectorAll('.buttons-group').forEach(btn => {
                        if (!btn.classList.contains('active')) {
                            btn.style.opacity = '0.5'; // Lighter opacity for hover
                        }
                    });
                });
                
                title.addEventListener('mouseleave', function() {
                    document.querySelectorAll('.buttons-group').forEach(btn => {
                        if (!btn.classList.contains('active')) {
                            btn.style.opacity = '';
                        }
                    });
                });
                
                // Also add hover to the parent panel card
                const panelCard = title.closest('.panel-card');
                if (panelCard) {
                    panelCard.addEventListener('mouseenter', function() {
                        if (title.dataset.panelLabel === 'buttons') {
                            document.querySelectorAll('.buttons-group').forEach(btn => {
                                if (!btn.classList.contains('active')) {
                                    btn.style.opacity = '0.5';
                                }
                            });
                        }
                    });
                    
                    panelCard.addEventListener('mouseleave', function() {
                        if (title.dataset.panelLabel === 'buttons') {
                            document.querySelectorAll('.buttons-group').forEach(btn => {
                                if (!btn.classList.contains('active')) {
                                    btn.style.opacity = '';
                                }
                            });
                        }
                    });
                }
            }
        });
    }, 500);
    
    // Monitor the buttons condition dropdown and sync all button overlays
    setTimeout(() => {
        // Find the buttons condition dropdown
        const buttonsConditionSelect = document.querySelector('select[name="interior_79-condition"]');
        if (buttonsConditionSelect) {
            console.log('Found buttons condition dropdown');
            
            // Function to update all button overlays based on condition
            function updateButtonsCondition(condition) {
                const allButtons = document.querySelectorAll('.buttons-group');
                
                // Remove all condition classes first
                allButtons.forEach(btn => {
                    btn.classList.remove('condition-good', 'condition-average', 'condition-bad');
                    btn.style.opacity = '';
                });
                
                // Add the new condition class to all buttons
                if (condition) {
                    allButtons.forEach(btn => {
                        btn.classList.add(`condition-${condition}`);
                        // Set opacity based on condition
                        if (condition === 'good') {
                            btn.style.opacity = '0.8';
                            btn.style.filter = 'brightness(0) saturate(100%) invert(25%) sepia(98%) saturate(1044%) hue-rotate(73deg) brightness(92%) contrast(101%)';
                        } else if (condition === 'average') {
                            btn.style.opacity = '0.8';
                            btn.style.filter = 'brightness(0) saturate(100%) invert(66%) sepia(68%) saturate(3428%) hue-rotate(8deg) brightness(102%) contrast(95%)';
                        } else if (condition === 'bad') {
                            btn.style.opacity = '0.8';
                            btn.style.filter = 'brightness(0) saturate(100%) invert(16%) sepia(90%) saturate(3122%) hue-rotate(348deg) brightness(93%) contrast(87%)';
                        }
                    });
                }
            }
            
            // Listen for changes to the dropdown
            buttonsConditionSelect.addEventListener('change', function() {
                const selectedCondition = this.value;
                console.log('Buttons condition changed to:', selectedCondition);
                updateButtonsCondition(selectedCondition);
            });
            
            // Apply initial condition if one is selected
            if (buttonsConditionSelect.value) {
                updateButtonsCondition(buttonsConditionSelect.value);
            }
        }
        
        // Also ensure clicking any button image selects the buttons panel in the form
        document.querySelectorAll('.buttons-group').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Find and click the buttons panel title in the form
                const buttonsPanel = document.querySelector('[data-panel-label="buttons"]');
                if (buttonsPanel && !buttonsPanel.classList.contains('active')) {
                    buttonsPanel.click();
                }
                
                // Sync all buttons visual state
                const allButtons = document.querySelectorAll('.buttons-group');
                const isActive = this.classList.contains('active');
                
                allButtons.forEach(button => {
                    if (!isActive) {
                        button.classList.add('active');
                    } else {
                        button.classList.remove('active');
                    }
                });
            });
            
            // Add hover synchronization - all buttons respond together
            btn.addEventListener('mouseenter', function(e) {
                e.stopPropagation();
                const allButtons = document.querySelectorAll('.buttons-group');
                
                // Apply hover effect to all buttons
                allButtons.forEach(button => {
                    if (!button.classList.contains('active')) {
                        // Enhance existing opacity/filter or set default hover
                        const currentOpacity = button.style.opacity || '0';
                        if (parseFloat(currentOpacity) < 0.7) {
                            button.style.opacity = '0.7';
                        }
                        
                        // Add hover class for additional styling if needed
                        button.classList.add('hover-state');
                    }
                });
            });
            
            btn.addEventListener('mouseleave', function(e) {
                e.stopPropagation();
                const allButtons = document.querySelectorAll('.buttons-group');
                
                // Remove hover effect from all buttons
                allButtons.forEach(button => {
                    button.classList.remove('hover-state');
                    
                    if (!button.classList.contains('active')) {
                        // Reset to condition-based opacity or hide
                        const condition = button.classList.contains('condition-good') ? 'good' :
                                         button.classList.contains('condition-average') ? 'average' :
                                         button.classList.contains('condition-bad') ? 'bad' : null;
                        
                        if (condition) {
                            button.style.opacity = '0.8'; // Maintain condition opacity
                        } else {
                            button.style.opacity = ''; // Reset to CSS default
                        }
                    }
                });
            });
        });
    }, 1000); // Wait for form to be fully initialized
    
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
            { id: 'interior_94', category: 'Air Vents', panelId: 'air-vents' },
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
        notify.draft('Draft saved successfully!');
    });
    
    document.getElementById('nextBtn').addEventListener('click', async function(e) {
        e.preventDefault(); // Prevent form submission
        
        console.log('Interior Assessment: Starting save and navigation...');
        
        // Get form data and images from InspectionCards
        let formData = {};
        let imageData = {};
        
        try {
            if (window.InspectionCards && typeof InspectionCards.getFormData === 'function') {
                formData = InspectionCards.getFormData();
                imageData = InspectionCards.getImages();
                console.log('Interior Form Data:', formData);
                console.log('Interior Images:', imageData);
            }
        } catch (e) {
            console.error('Error getting InspectionCards data:', e);
        }
        
        // Get current inspection ID from session storage
        const inspectionId = sessionStorage.getItem('currentInspectionId');
        console.log('Current Inspection ID:', inspectionId);
        
        // Prepare API data
        const apiData = {
            inspection_id: inspectionId,
            components: [],
            images: imageData
        };
        
        // Extract component data from form data
        const componentMap = {};
        for (const [key, value] of Object.entries(formData)) {
            const match = key.match(/^([^-]+)-(.+)$/);
            if (match) {
                const componentId = match[1];
                const fieldName = match[2];
                
                if (!componentMap[componentId]) {
                    componentMap[componentId] = { component_name: componentId };
                }
                
                // Map field names to expected backend format
                if (fieldName === 'condition') {
                    componentMap[componentId].condition = value;
                } else if (fieldName === 'colour') {
                    componentMap[componentId].colour = value;
                } else if (fieldName === 'comments') {
                    componentMap[componentId].comment = value;
                } else {
                    componentMap[componentId][fieldName] = value;
                }
            }
        }
        
        // Convert component map to array
        apiData.components = Object.values(componentMap).filter(component => 
            component.condition || component.colour || component.comment
        );
        
        console.log('Interior API Data being sent:', apiData);
        
        try {
            // Save to database via API
            const response = await fetch('/api/inspection/interior', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(apiData)
            });
            
            console.log('Interior API Response status:', response.status);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Interior API Error Response:', errorText);
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }
            
            const result = await response.json();
            console.log('Interior API Response:', result);
            
            if (result.success) {
                console.log('✅ Interior assessment saved successfully!');
                
                // Also save to sessionStorage for compatibility
                InspectionCards.saveData();
                
                // Show success message
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                    background-color: #28a745; color: white; border-radius: 5px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 9999;
                `;
                notification.textContent = 'Interior assessment saved to database successfully!';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                    window.location.href = '/inspection/service-booklet';
                }, 1500);
            } else {
                throw new Error(result.message || 'Failed to save interior assessment');
            }
        } catch (error) {
            console.error('Database save failed:', error);
            notify.error('Database save failed: ' + error.message + '. Data saved locally only.', { duration: 6000 });
            
            // Save to sessionStorage anyway and continue
            InspectionCards.saveData();
            setTimeout(() => {
                window.location.href = '/inspection/service-booklet';
            }, 2000);
        }
    });
});
</script>
@endsection