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
                        
                        <!-- Buttons RL: x=455, y=705, w=30, h=33 -->
                        <img src="/images/interior/buttons-RL.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 45.27%; top: 49.06%; width: 2.99%; height: 2.30%; z-index: 2;"
                             title="Buttons RL" 
                             alt="Buttons RL">
                        
                        <!-- Buttons RR: x=527, y=710, w=30, h=30 -->
                        <img src="/images/interior/buttons-RR.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             style="position: absolute; left: 52.44%; top: 49.41%; width: 2.99%; height: 2.09%; z-index: 2;"
                             title="Buttons RR" 
                             alt="Buttons RR">
                        
                        <!-- Driver Seat: x=632, y=409, w=300, h=377 -->
                        <img src="/images/interior/driver-seat.png" 
                             class="panel-overlay" 
                             data-panel="driver-seat"
                             style="position: absolute; left: 62.89%; top: 28.46%; width: 29.85%; height: 26.24%;"
                             title="Driver Seat" 
                             alt="Driver Seat">
                        
                        <!-- Passenger Seat: x=79, y=409, w=300, h=377 -->
                        <img src="/images/interior/passenger-seat.png" 
                             class="panel-overlay" 
                             data-panel="passenger-seat"
                             style="position: absolute; left: 7.86%; top: 28.46%; width: 29.85%; height: 26.24%;"
                             title="Passenger Seat" 
                             alt="Passenger Seat">
                        
                        <!-- FR Door Panel: x=962, y=280, w=43, h=506 -->
                        <img src="/images/interior/fr-dOORPANEL.png" 
                             class="panel-overlay" 
                             data-panel="fr-door-panel"
                             style="position: absolute; left: 95.72%; top: 19.48%; width: 4.28%; height: 35.20%;"
                             title="FR Door Panel" 
                             alt="FR Door Panel">
                        
                        <!-- FL Door Panel: x=0, y=280, w=43, h=506 -->
                        <img src="/images/interior/FL Doorpanel.png" 
                             class="panel-overlay" 
                             data-panel="fl-door-panel"
                             style="position: absolute; left: 0%; top: 19.48%; width: 4.28%; height: 35.20%;"
                             title="FL Door Panel" 
                             alt="FL Door Panel">
                        
                        <!-- Rear Seat: x=79, y=795, w=853, h=284 -->
                        <img src="/images/interior/Rear-Seat.png" 
                             class="panel-overlay" 
                             data-panel="rear-seat"
                             style="position: absolute; left: 7.86%; top: 55.31%; width: 84.88%; height: 19.76%;"
                             title="Rear Seat" 
                             alt="Rear Seat">
                        
                        <!-- Backboard: x=79, y=1089, w=853, h=172 -->
                        <img src="/images/interior/backboard.png" 
                             class="panel-overlay" 
                             data-panel="backboard"
                             style="position: absolute; left: 7.86%; top: 75.78%; width: 84.88%; height: 11.97%;"
                             title="Backboard" 
                             alt="Backboard">
                        
                        <!-- RR Door Panel: x=962, y=795, w=43, h=466 -->
                        <img src="/images/interior/RR-Door-Panel.png" 
                             class="panel-overlay" 
                             data-panel="rr-door-panel"
                             style="position: absolute; left: 95.72%; top: 55.31%; width: 4.28%; height: 32.43%;"
                             title="RR Door Panel" 
                             alt="RR Door Panel">
                        
                        <!-- LR Door Panel: x=0, y=795, w=43, h=466 -->
                        <img src="/images/interior/LR-DoorPanel.png" 
                             class="panel-overlay" 
                             data-panel="lr-door-panel"
                             style="position: absolute; left: 0%; top: 55.31%; width: 4.28%; height: 32.43%;"
                             title="LR Door Panel" 
                             alt="LR Door Panel">
                        
                        <!-- Boot: x=79, y=1273, w=853, h=164 -->
                        <img src="/images/interior/Boot.png" 
                             class="panel-overlay" 
                             data-panel="boot"
                             style="position: absolute; left: 7.86%; top: 88.61%; width: 84.88%; height: 11.41%;"
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
                        
                        <!-- Dynamic interior assessments will be generated by JavaScript -->
                        <div id="interiorAssessments">
                            <!-- Interior forms will be added here -->
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" id="backBtn">
                                <i class="bi bi-arrow-left me-1"></i>Back to Specific Areas
                            </button>
                            <div class="button-group-responsive">
                                <button type="button" class="btn btn-secondary me-2 mb-2" id="saveDraftBtn">Save Draft</button>
                                <button type="submit" class="btn btn-primary mb-2" id="nextBtn">
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
    height: auto;
    overflow: visible;
    padding: 15px;
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
    opacity: 0;
    position: absolute !important;
}

/* Hover effects for panels - red highlight when hovering */
.panel-overlay:hover {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* Active state - temporary red highlight */
.panel-overlay.active {
    opacity: 0.7;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* Panel card styling - same as body panel */
.panel-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.panel-card-title {
    font-size: 16px;
    font-weight: 600;
    color: #2b2b2b;
    margin-bottom: 12px;
}

.panel-controls {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.panel-controls select,
.panel-controls input,
.panel-controls textarea {
    flex: 1;
    min-width: 120px;
}

.panel-controls textarea {
    resize: none;
}

.photo-btn {
    background: white;
    border: 2px solid #4f959b;
    color: #4f959b;
    padding: 6px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.photo-btn:hover {
    background: #4f959b;
    color: white;
}

.photo-btn i {
    font-size: 16px;
}

/* Image gallery */
.image-gallery {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
}

.image-thumbnail-container {
    position: relative;
    width: 150px;
    height: 150px;
}

.image-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    cursor: pointer;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: background 0.2s;
}

.remove-image:hover {
    background: #dc3545;
}

/* Image modal */
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.9);
}

.image-modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 90%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.image-modal-close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.image-modal-close:hover {
    color: #bbb;
}

/* Panel assessment highlighting */
.panel-assessment {
    transition: all 0.3s ease;
}

.panel-card.highlighted {
    border-color: #dc3545;
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
}

/* Color select styling */
.color-select option[value="Red & Black"] { background-color: #b30000; color: white; }
.color-select option[value="Black"] { background-color: #000000; color: white; }
.color-select option[value="Grey"] { background-color: #808080; color: white; }
.color-select option[value="Beige"] { background-color: #f5f5dc; }
.color-select option[value="Brown"] { background-color: #8b4513; color: white; }
.color-select option[value="Blue"] { background-color: #0000cd; color: white; }
.color-select option[value="Other"] { background-color: #cccccc; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .panel-controls {
        flex-direction: column;
    }
    
    .panel-controls select,
    .panel-controls input,
    .panel-controls textarea {
        width: 100%;
    }
    
    .photo-btn {
        width: 100%;
        justify-content: center;
    }
    
    .image-thumbnail-container {
        width: 100px;
        height: 100px;
    }
    
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Interior assessment items
    const interiorItems = [
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
        { id: 'interior_93', category: 'Air Vents', panelId: 'air-vents' }
    ];
    
    // Color options
    const colorOptions = [
        { value: '', text: 'Select Color' },
        { value: 'Red & Black', text: 'Red & Black' },
        { value: 'Black', text: 'Black' },
        { value: 'Grey', text: 'Grey' },
        { value: 'Beige', text: 'Beige' },
        { value: 'Brown', text: 'Brown' },
        { value: 'Blue', text: 'Blue' },
        { value: 'Other', text: 'Other' }
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
            <div class="panel-card" data-panel-card="${item.panelId || item.id}">
                <div class="panel-card-title" data-panel-label="${item.panelId || item.id}">${item.category}</div>
                <div class="panel-controls">
                    <select class="form-select form-select-sm color-select" name="${item.id}-colour">
                        ${colorOptionsHtml}
                    </select>
                    <select class="form-select form-select-sm" name="${item.id}-condition">
                        <option value="">Condition</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="bad">Bad</option>
                    </select>
                    <textarea class="form-control form-control-sm" 
                           name="${item.id}-comments" 
                           placeholder="Additional comments"
                           rows="1"></textarea>
                    <button type="button" class="photo-btn" data-panel="${item.panelId || item.id}">
                        <i class="bi bi-camera-fill"></i> Photo
                    </button>
                    <input type="file" accept="image/*" capture="environment" 
                           class="d-none camera-input" id="camera-${item.panelId || item.id}">
                </div>
                <div class="image-gallery" id="gallery-${item.panelId || item.id}" style="display: none;">
                    <!-- Images will be added here -->
                </div>
            </div>
        `;
        
        assessmentContainer.appendChild(panelDiv);
    });

    // Initialize camera functionality
    initializeCameraHandlers();
    
    // Two-way highlighting functionality
    const panelOverlays = document.querySelectorAll('.panel-overlay');
    const formLabels = document.querySelectorAll('[data-panel-label]');
    const panelAssessments = document.querySelectorAll('.panel-assessment');

    // Handle panel click
    panelOverlays.forEach(overlay => {
        const panelId = overlay.dataset.panel;
        
        // Click handler - highlights form field
        overlay.addEventListener('click', function() {
            // Remove active class from all panels and labels
            panelOverlays.forEach(p => p.classList.remove('active'));
            formLabels.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked panel
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
                correspondingLabel.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        // Hover handlers for visual feedback
        overlay.addEventListener('mouseenter', function() {
            let correspondingCard = null;
            
            // For buttons, handle all button components
            if (this.classList.contains('buttons-group') || panelId === 'buttons') {
                correspondingCard = document.querySelector('.panel-card[data-panel-card="buttons"]');
            } else {
                correspondingCard = document.querySelector(`.panel-card[data-panel-card="${panelId}"]`);
            }
            
            if (correspondingCard) {
                correspondingCard.classList.add('highlighted');
            }
        });
        
        overlay.addEventListener('mouseleave', function() {
            let correspondingCard = null;
            
            if (this.classList.contains('buttons-group') || panelId === 'buttons') {
                correspondingCard = document.querySelector('.panel-card[data-panel-card="buttons"]');
            } else {
                correspondingCard = document.querySelector(`.panel-card[data-panel-card="${panelId}"]`);
            }
            
            if (correspondingCard) {
                correspondingCard.classList.remove('highlighted');
            }
        });
    });

    // Handle form label hover - highlights corresponding panel
    formLabels.forEach(label => {
        const panelId = label.dataset.panelLabel;
        
        label.addEventListener('mouseenter', function() {
            if (panelId === 'buttons') {
                document.querySelectorAll('[data-panel="buttons"]').forEach(btn => {
                    btn.classList.add('active');
                });
            } else {
                const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (correspondingPanel) {
                    correspondingPanel.classList.add('active');
                }
            }
        });
        
        label.addEventListener('mouseleave', function() {
            if (panelId === 'buttons') {
                document.querySelectorAll('[data-panel="buttons"]').forEach(btn => {
                    btn.classList.remove('active');
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
            const correspondingPanel = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
            if (correspondingPanel) {
                correspondingPanel.click();
            }
        });
    });

    // Form submission handler
    document.getElementById('interiorAssessmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save the interior assessment data
        saveCurrentProgress();
        
        // Navigate to next section (update this as needed)
        alert('Interior assessment saved! (Frontend only - backend integration pending)');
    });

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        saveCurrentProgress();
        window.location.href = '/inspection/specific-areas';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        saveCurrentProgress();
        alert('Interior assessment draft saved successfully!');
    });
});

// Initialize camera handlers
function initializeCameraHandlers() {
    // Storage for panel images
    if (!window.interiorImages) {
        window.interiorImages = {};
    }

    // Create modal for full image view if it doesn't exist
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
        modal.onclick = function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        };
    }

    // Add click handlers to photo buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.photo-btn')) {
            const btn = e.target.closest('.photo-btn');
            const panelId = btn.dataset.panel;
            const fileInput = document.getElementById(`camera-${panelId}`);
            fileInput.click();
        }
    });

    // Handle file input changes
    document.querySelectorAll('.camera-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const panelId = this.id.replace('camera-', '');
                processImage(file, panelId);
            }
        });
    });
}

// Process captured image
function processImage(file, panelId) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const imageData = e.target.result;
        const imageId = `${panelId}-${Date.now()}`;
        
        // Store image data
        if (!window.interiorImages[panelId]) {
            window.interiorImages[panelId] = [];
        }
        
        window.interiorImages[panelId].push({
            id: imageId,
            data: imageData,
            timestamp: new Date().toISOString()
        });
        
        // Display the image
        displayImage(imageId, imageData, panelId);
        
        // Clear the file input
        document.getElementById(`camera-${panelId}`).value = '';
    };
    
    reader.readAsDataURL(file);
}

// Display image in gallery
function displayImage(imageId, imageData, panelId) {
    const gallery = document.getElementById(`gallery-${panelId}`);
    
    // Show gallery if hidden
    if (gallery.style.display === 'none') {
        gallery.style.display = 'flex';
    }
    
    const container = document.createElement('div');
    container.className = 'image-thumbnail-container';
    container.id = `img-container-${imageId}`;
    
    container.innerHTML = `
        <img src="${imageData}" class="image-thumbnail" onclick="showFullImage('${imageId}', '${panelId}')">
        <button class="remove-image" onclick="removeImage('${imageId}', '${panelId}')">×</button>
    `;
    
    gallery.appendChild(container);
}

// Show full image in modal
function showFullImage(imageId, panelId) {
    const imageInfo = window.interiorImages[panelId].find(img => img.id === imageId);
    if (imageInfo) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.style.display = 'block';
        modalImg.src = imageInfo.data;
    }
}

// Remove image
function removeImage(imageId, panelId) {
    // Remove from storage
    window.interiorImages[panelId] = window.interiorImages[panelId].filter(img => img.id !== imageId);
    
    // Remove from DOM
    const container = document.getElementById(`img-container-${imageId}`);
    if (container) {
        container.remove();
    }
    
    // Hide gallery if no images left
    const gallery = document.getElementById(`gallery-${panelId}`);
    if (window.interiorImages[panelId].length === 0) {
        delete window.interiorImages[panelId];
        gallery.style.display = 'none';
    }
}

// Load previous visual inspection data and display summary
function loadPreviousData() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    if (visualData) {
        const data = JSON.parse(visualData);
        displayInspectionSummary(data);
    }
    
    // Load any existing interior assessment data
    const interiorData = sessionStorage.getItem('interiorAssessmentData');
    if (interiorData) {
        restoreInteriorAssessments(JSON.parse(interiorData));
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
                Inspector: ${data.inspector_name}
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
    
    // Include images in saved data
    if (window.interiorImages && Object.keys(window.interiorImages).length > 0) {
        interiorData.images = window.interiorImages;
    }
    
    sessionStorage.setItem('interiorAssessmentData', JSON.stringify(interiorData));
}

// Restore previous interior assessments
function restoreInteriorAssessments(data) {
    Object.keys(data).forEach(key => {
        if (key === 'images') {
            // Restore images
            window.interiorImages = data.images;
            Object.keys(data.images).forEach(panelId => {
                data.images[panelId].forEach(imageInfo => {
                    displayImage(imageInfo.id, imageInfo.data, panelId);
                });
            });
        } else {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        }
    });
}
</script>
@endsection