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
                    <li class="breadcrumb-item"><a href="/inspection/specific-areas" style="color: var(--primary-color);">Specific Area Images</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Interior Assessment</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Interior Assessment</h2>
        <p class="text-muted">Click on interior components or hover over form labels to highlight areas</p>
    </div>

    <div class="row">
        <!-- Interior Visual Section -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm interior-visual-card">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Vehicle Interior Components</h5>
                </div>
                <div class="card-body">
                    <div class="interior-container">
                        <!-- Base interior image -->
                        <img src="/images/interior/interiorMain.png" 
                             alt="Interior View" 
                             class="base-interior" 
                             id="baseInterior">
                        
                        <!-- Interior panel overlays with coordinates from CSV -->
                        
                        <!-- Dash: x=61, y=61, w=888, h=254 -->
                        <img src="/images/interior/Dash.png" 
                             class="panel-overlay" 
                             data-panel="dash"
                             style="position: absolute; left: 6.07%; top: 4.25%; width: 88.36%; height: 17.68%; z-index: 2;"
                             title="Dash" 
                             alt="Dash">
                        
                        <!-- Steering Wheel: x=595, y=254, w=240, h=123 -->
                        <img src="/images/interior/steering-wheel.png" 
                             class="panel-overlay" 
                             data-panel="steering-wheel"
                             style="position: absolute; left: 59.20%; top: 17.68%; width: 23.88%; height: 8.56%; z-index: 3;"
                             title="Steering Wheel" 
                             alt="Steering Wheel">
                        
                        <!-- Main Buttons Panel: x=79, y=270, w=853, h=507 -->
                        <!-- Note: Using individual button components only, no main buttons.png -->
                        <!--<img src="/images/interior/buttons.png" 
                             class="panel-overlay" 
                             data-panel="buttons"
                             style="position: absolute; left: 79px; top: 270px; width: 853px; height: 507px;"
                             title="Buttons" 
                             alt="Buttons">-->
                        
                        <!-- Individual Button Components with higher z-index -->
                        <!-- Buttons RF: x=876, y=283, w=85, h=85 -->
                        <img src="/images/interior/buttons-RF.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 87.16%; top: 19.69%; width: 8.46%; height: 5.92%; z-index: 2;"
                             title="Buttons RF" 
                             alt="Buttons RF">
                        
                        <!-- Buttons Centre: x=476, y=271, w=65, h=66 -->
                        <img src="/images/interior/buttons-centre.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 47.36%; top: 18.86%; width: 6.47%; height: 4.59%; z-index: 2;"
                             title="Buttons Centre" 
                             alt="Buttons Centre">
                        
                        <!-- Buttons ML: x=455, y=384, w=30, h=42 -->
                        <img src="/images/interior/buttons-ML.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 45.27%; top: 26.72%; width: 2.99%; height: 2.92%; z-index: 2;"
                             title="Buttons ML" 
                             alt="Buttons ML">
                        
                        <!-- Buttons MR: x=527, y=387, w=30, h=40 -->
                        <img src="/images/interior/buttons-MR.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 52.44%; top: 26.93%; width: 2.99%; height: 2.78%; z-index: 2;"
                             title="Buttons MR" 
                             alt="Buttons MR">
                        
                        <!-- Buttons FL: x=77, y=325, w=36, h=36 -->
                        <img src="/images/interior/buttons-FL.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 7.66%; top: 22.61%; width: 3.58%; height: 2.51%; z-index: 2;"
                             title="Buttons FL" 
                             alt="Buttons FL">
                        
                        <!-- Buttons RL: x=104, y=739, w=33, h=33 -->
                        <img src="/images/interior/buttons-RL.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 10.35%; top: 51.42%; width: 3.28%; height: 2.30%; z-index: 2;"
                             title="Buttons RL" 
                             alt="Buttons RL">
                        
                        <!-- Buttons RR: x=881, y=731, w=39, h=39 -->
                        <img src="/images/interior/buttons-RR.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 87.66%; top: 50.87%; width: 3.88%; height: 2.71%; z-index: 2;"
                             title="Buttons RR" 
                             alt="Buttons RR">
                        
                        <!-- Driver Seat: x=558, y=271, w=346, h=449 -->
                        <img src="/images/interior/driver-seat.png" 
                             class="panel-overlay" 
                             data-panel="driver-seat"
                             style="position: absolute; left: 55.52%; top: 18.86%; width: 34.43%; height: 31.25%;"
                             title="Driver Seat" 
                             alt="Driver Seat">
                        
                        <!-- Passenger Seat: x=115, y=298, w=332, h=420 -->
                        <img src="/images/interior/passenger-seat.png" 
                             class="panel-overlay" 
                             data-panel="passenger-seat"
                             style="position: absolute; left: 11.44%; top: 20.74%; width: 33.03%; height: 29.23%;"
                             title="Passenger Seat" 
                             alt="Passenger Seat">
                        
                        <!-- FR Door Panel: x=883, y=203, w=97, h=471 -->
                        <img src="/images/interior/fr-dOORPANEL.png" 
                             class="panel-overlay" 
                             data-panel="fr-door-panel"
                             style="position: absolute; left: 87.86%; top: 14.13%; width: 9.65%; height: 32.78%;"
                             title="FR Door Panel" 
                             alt="FR Door Panel">
                        
                        <!-- FL Door Panel: x=31, y=203, w=101, h=481 -->
                        <img src="/images/interior/FL Doorpanel.png" 
                             class="panel-overlay" 
                             data-panel="fl-door-panel"
                             style="position: absolute; left: 3.08%; top: 14.13%; width: 10.05%; height: 33.47%;"
                             title="FL Door Panel" 
                             alt="FL Door Panel">
                        
                        <!-- Rear Seat: x=131, y=712, w=737, h=400 -->
                        <img src="/images/interior/Rear-Seat.png" 
                             class="panel-overlay" 
                             data-panel="rear-seat"
                             style="position: absolute; left: 13.03%; top: 49.55%; width: 73.33%; height: 27.84%;"
                             title="Rear Seat" 
                             alt="Rear Seat">
                        
                        <!-- Backboard: x=107, y=1100, w=812, h=275 -->
                        <img src="/images/interior/backboard.png" 
                             class="panel-overlay" 
                             data-panel="backboard"
                             style="position: absolute; left: 10.65%; top: 76.53%; width: 80.80%; height: 19.14%;"
                             title="Backboard" 
                             alt="Backboard">
                        
                        <!-- RR Door Panel: x=854, y=677, w=119, h=443 -->
                        <img src="/images/interior/RR-Door-Panel.png" 
                             class="panel-overlay" 
                             data-panel="rr-door-panel"
                             style="position: absolute; left: 84.98%; top: 47.11%; width: 11.84%; height: 30.83%;"
                             title="RR Door Panel" 
                             alt="RR Door Panel">
                        
                        <!-- LR Door Panel: x=44, y=678, w=131, h=443 -->
                        <img src="/images/interior/LR-DoorPanel.png" 
                             class="panel-overlay" 
                             data-panel="lr-door-panel"
                             style="position: absolute; left: 4.38%; top: 47.18%; width: 13.03%; height: 30.83%;"
                             title="LR Door Panel" 
                             alt="LR Door Panel">
                        
                        <!-- Boot: x=103, y=1310, w=811, h=125 -->
                        <img src="/images/interior/Boot.png" 
                             class="panel-overlay" 
                             data-panel="boot"
                             style="position: absolute; left: 10.25%; top: 91.15%; width: 80.70%; height: 8.70%;"
                             title="Boot" 
                             alt="Boot">
                        
                        <!-- Centre Console: x=394, y=256, w=227, h=484 -->
                        <img src="/images/interior/Centre-Consol.png" 
                             class="panel-overlay" 
                             data-panel="centre-console"
                             style="position: absolute; left: 39.20%; top: 17.82%; width: 22.59%; height: 33.68%;"
                             title="Centre Console" 
                             alt="Centre Console">
                        
                        <!-- Gear Lever: x=478, y=388, w=54, h=65 -->
                        <img src="/images/interior/Gear-Lever.png" 
                             class="panel-overlay" 
                             data-panel="gearlever"
                             style="position: absolute; left: 47.56%; top: 27.00%; width: 5.37%; height: 4.52%;"
                             title="Gear Lever" 
                             alt="Gear Lever">
                        
                        <!-- Air Vents: x=71, y=182, w=868, h=150 -->
                        <img src="/images/interior/Airvents.png" 
                             class="panel-overlay" 
                             data-panel="air-vents"
                             style="position: absolute; left: 7.06%; top: 12.67%; width: 86.37%; height: 10.44%; z-index: 1;"
                             title="Air Vents" 
                             alt="Air Vents">
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Form Section -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Interior Assessment Details</h5>
                </div>
                <div class="card-body">
                    <form id="interiorAssessmentForm">
                        @csrf
                        
                        <!-- No header row needed - labels will be above each item like body panel -->
                        
                        <!-- Dynamic interior assessments will be generated by JavaScript -->
                        <div id="interiorAssessments">
                            <!-- Interior forms will be added here -->
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" id="backBtn">
                                <i class="bi bi-arrow-left me-1"></i>Back to Specific Areas
                            </button>
                            <div>
                                <button type="button" class="btn btn-secondary me-2" id="saveDraftBtn">Save Draft</button>
                                <button type="submit" class="btn btn-primary" id="nextBtn">
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
/* Card body height constraint for interior image */
.interior-visual-card .card-body {
    height: auto; /* Let it size to content */
    overflow: visible; /* Allow panel overlays to be visible */
    padding: 0; /* Remove all padding */
}

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

/* Interior visual card body - responsive height */
.interior-visual-card .card-body {
    overflow: visible;
    padding: 15px;
}

/* Base interior image - fully responsive */
.base-interior {
    width: 100%;
    height: auto;
    display: block;
    max-width: 1005px;
}

/* Panel overlay base styling - responsive positioning using percentages */
.panel-overlay {
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0; /* Start invisible */
    position: absolute !important;
    /* Convert all pixel values to percentages for responsive scaling */
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

/* Condition-based persistent colors - simplified for Good/Average/Bad */
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

/* Special handling for button groups - they all highlight together */
.buttons-group:hover ~ .buttons-group,
.buttons-group:hover,
.buttons-group.active {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* When hovering any button part, highlight all button parts */
.interior-container:has(.buttons-group:hover) .buttons-group {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
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

/* Color dropdown preview */
.color-preview {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 1px solid #dee2e6;
    border-radius: 3px;
    vertical-align: middle;
    margin-left: 5px;
}

/* Responsive design for tablets and mobile */
@media (max-width: 991px) {
    .interior-container {
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
    
    // Interior components mapping - matching data panel names to categories
    const componentMapping = {
        'dash': 'Dash',
        'steering-wheel': 'Steering wheel',
        'buttons': 'buttons',
        'driver-seat': 'driver seat',
        'passenger-seat': 'passanger seat',  // Note: matching JSON spelling
        'fr-door-panel': 'FR door panel',
        'fl-door-panel': 'FL door panel',
        'rear-seat': 'Rear seat',
        'backboard': 'Backboard',
        'rr-door-panel': 'RR door panel',
        'lr-door-panel': 'LR door panel',
        'boot': 'Boot',
        'centre-console': 'Centre console',
        'gearlever': 'Gearlever',
        'air-vents': 'Air vents'
    };
    
    // Interior assessment items from JSON - with proper capitalization
    const interiorItems = [
        { id: 'interior_77', category: 'Dash', panelId: 'dash' },
        { id: 'interior_78', category: 'Steering Wheel', panelId: 'steering-wheel' },
        { id: 'interior_79', category: 'Buttons', panelId: 'buttons' },
        { id: 'interior_80', category: 'Driver Seat', panelId: 'driver-seat' },
        { id: 'interior_81', category: 'Passenger Seat', panelId: 'passenger-seat' },
        { id: 'interior_82', category: 'Rooflining', panelId: null }, // No visual panel
        { id: 'interior_83', category: 'FR Door Panel', panelId: 'fr-door-panel' },
        { id: 'interior_84', category: 'FL Door Panel', panelId: 'fl-door-panel' },
        { id: 'interior_85', category: 'Rear Seat', panelId: 'rear-seat' },
        { id: 'interior_86', category: 'Additional Seats', panelId: null }, // No visual panel
        { id: 'interior_87', category: 'Backboard', panelId: 'backboard' },
        { id: 'interior_88', category: 'RR Door Panel', panelId: 'rr-door-panel' },
        { id: 'interior_89', category: 'LR Door Panel', panelId: 'lr-door-panel' },
        { id: 'interior_90', category: 'Boot', panelId: 'boot' },
        { id: 'interior_91', category: 'Centre Console', panelId: 'centre-console' },
        { id: 'interior_92', category: 'Gear Lever', panelId: 'gearlever' },
        { id: 'interior_93', category: 'Air Vents', panelId: 'air-vents' }
    ];
    
    // Color options from JSON
    const colorOptions = [
        { value: '', text: 'Select Color', color: null },
        { value: 'Red & Black', text: 'Red & Black', color: '#b30000' },
        { value: 'Black', text: 'Black', color: '#000000' },
        { value: 'Grey', text: 'Grey', color: '#808080' },
        { value: 'Beige', text: 'Beige', color: '#f5f5dc' },
        { value: 'Brown', text: 'Brown', color: '#8b4513' },
        { value: 'Blue', text: 'Blue', color: '#0000cd' },
        { value: 'Other', text: 'Other', color: '#cccccc' }
    ];

    // Generate form fields for each interior component
    const assessmentContainer = document.getElementById('interiorAssessments');
    interiorItems.forEach(item => {
        const panelDiv = document.createElement('div');
        panelDiv.className = 'panel-assessment';
        panelDiv.dataset.panel = item.panelId || item.id;
        
        // Create color options HTML
        let colorOptionsHtml = '';
        colorOptions.forEach(opt => {
            colorOptionsHtml += `<option value="${opt.value}">${opt.text}</option>`;
        });
        
        panelDiv.innerHTML = `
            <div class="form-label-wrapper p-2 rounded" data-panel-label="${item.panelId || item.id}">
                <label class="form-label fw-bold mb-1">${item.category}</label>
            </div>
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select form-select-sm color-select" name="${item.id}-colour">
                        ${colorOptionsHtml}
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" name="${item.id}-condition">
                        <option value="">Condition</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="bad">Bad</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <textarea class="form-control form-control-sm" 
                           name="${item.id}-comments" 
                           placeholder="Additional comments"
                           rows="1"></textarea>
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
            
            // Handle button groups - highlight all button components
            if (panelId === 'buttons') {
                document.querySelectorAll('[data-panel="buttons"]').forEach(btn => {
                    btn.classList.add('active');
                });
            }
            
            const correspondingLabel = document.querySelector(`[data-panel-label="${panelId}"]`);
            if (correspondingLabel) {
                correspondingLabel.classList.add('active');
                // Scroll form into view
                correspondingLabel.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        // Hover handlers for visual feedback
        overlay.addEventListener('mouseenter', function() {
            // Find corresponding assessment by matching panel ID to category
            let correspondingAssessment = null;
            
            // For buttons, handle all button components
            if (this.classList.contains('buttons-group') || panelId === 'buttons') {
                correspondingAssessment = document.querySelector('.panel-assessment[data-panel="buttons"]');
            } else {
                correspondingAssessment = document.querySelector(`.panel-assessment[data-panel="${panelId}"]`);
            }
            
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
            // Handle buttons specially
            if (panelId === 'buttons') {
                document.querySelectorAll('[data-panel="buttons"]').forEach(panel => {
                    if (!panel.classList.contains('condition-good') && 
                        !panel.classList.contains('condition-average') && 
                        !panel.classList.contains('condition-bad')) {
                        panel.classList.add('active');
                    }
                });
            } else {
                const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (correspondingPanel && 
                    !correspondingPanel.classList.contains('condition-good') && 
                    !correspondingPanel.classList.contains('condition-average') && 
                    !correspondingPanel.classList.contains('condition-bad')) {
                    correspondingPanel.classList.add('active');
                }
            }
        });
        
        label.addEventListener('mouseleave', function() {
            if (panelId === 'buttons') {
                document.querySelectorAll('[data-panel="buttons"]').forEach(panel => {
                    panel.classList.remove('active');
                });
            } else {
                const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (correspondingPanel) {
                    correspondingPanel.classList.remove('active');
                }
            }
        });
        
        // Click handler for form labels
        label.addEventListener('click', function() {
            if (panelId === 'buttons') {
                // Click the main buttons panel
                const mainButtonsPanel = document.querySelector('.panel-overlay[data-panel="buttons"]:not(.buttons-group)');
                if (mainButtonsPanel) {
                    mainButtonsPanel.click();
                }
            } else {
                const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (correspondingPanel) {
                    correspondingPanel.click();
                }
            }
        });
    });
    
    // Handle condition changes - update panel colors
    const conditionSelects = document.querySelectorAll('select[name$="-condition"]');
    conditionSelects.forEach(select => {
        select.addEventListener('change', function() {
            const itemId = this.name.replace('-condition', '');
            const interiorItem = interiorItems.find(item => item.id === itemId);
            
            if (interiorItem && interiorItem.panelId) {
                // Handle buttons specially
                if (interiorItem.panelId === 'buttons') {
                    document.querySelectorAll('[data-panel="buttons"]').forEach(panel => {
                        // Remove existing condition classes
                        panel.classList.remove('condition-good', 'condition-average', 'condition-bad', 'active');
                        
                        // Add new condition class
                        if (this.value) {
                            panel.classList.add(`condition-${this.value}`);
                        }
                    });
                } else {
                    const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${interiorItem.panelId}"]`);
                    
                    if (correspondingPanel) {
                        // Remove existing condition classes
                        correspondingPanel.classList.remove('condition-good', 'condition-average', 'condition-bad', 'active');
                        
                        // Add new condition class
                        if (this.value) {
                            correspondingPanel.classList.add(`condition-${this.value}`);
                        }
                    }
                }
            }
        });
    });

    // Form submission handler
    document.getElementById('interiorAssessmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save the interior assessment data
        saveCurrentProgress();
        
        // Navigate to interior specific images section
        window.location.href = '/inspection/interior-images';
    });

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        // Save current progress before going back
        saveCurrentProgress();
        window.location.href = '/inspection/specific-areas';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        saveCurrentProgress();
        alert('Interior assessment draft saved successfully!');
    });
});

// Load previous inspection data and display summary
function loadPreviousData() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    if (visualData) {
        const data = JSON.parse(visualData);
        
        // Display inspection summary at top of page
        displayInspectionSummary(data);
        
        // Load any existing interior assessment data
        const interiorData = sessionStorage.getItem('interiorAssessmentData');
        if (interiorData) {
            restoreInteriorAssessments(JSON.parse(interiorData));
        }
    }
}

// Display summary of inspection data
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
                Progress: Visual ✓ | Body Panels ✓ | Specific Areas ✓ | Interior Assessment
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

// Save current interior assessment progress
function saveCurrentProgress() {
    const formData = new FormData(document.getElementById('interiorAssessmentForm'));
    const interiorData = {};
    
    for (let [key, value] of formData.entries()) {
        if (value && key !== '_token') {
            interiorData[key] = value;
        }
    }
    
    sessionStorage.setItem('interiorAssessmentData', JSON.stringify(interiorData));
}

// Restore previous interior assessments
function restoreInteriorAssessments(data) {
    Object.keys(data).forEach(key => {
        const field = document.querySelector(`[name="${key}"]`);
        if (field) {
            field.value = data[key];
            
            // If it's a condition field, update panel color
            if (key.endsWith('-condition') && data[key]) {
                const event = new Event('change', { bubbles: true });
                field.dispatchEvent(event);
            }
        }
    });
}
</script>
@endsection