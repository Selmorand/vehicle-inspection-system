@extends('layouts.app')

@section('title', 'Physical Hoist Inspection')

@section('additional-css')
<link rel="stylesheet" href="{{ asset('css/panel-cards.css') }}">
@endsection

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
                    <li class="breadcrumb-item"><a href="/inspection/engine-compartment" style="color: var(--primary-color);">Engine Compartment</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Physical Hoist</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Physical Hoist Inspection</h2>
        <p class="text-muted">Complete under-vehicle inspection using physical hoist - suspension, engine, and drivetrain components</p>
    </div>

    <form id="physicalHoistForm">
        @csrf
        
        <!-- Suspension System Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Suspension System Assessment</h5>
                        <small class="text-light">6 Components - Suspension components inspection</small>
                    </div>
                    <div class="card-body">
                        <div id="suspensionAssessments">
                            <!-- Suspension component cards will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Engine System Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Engine System Assessment</h5>
                        <small class="text-light">6 Components - Engine components inspection</small>
                    </div>
                    <div class="card-body">
                        <div id="engineAssessments">
                            <!-- Engine component cards will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Drivetrain System Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Drivetrain System Assessment</h5>
                        <small class="text-light">6 Components - Drivetrain components inspection</small>
                    </div>
                    <div class="card-body">
                        <div id="drivetrainAssessments">
                            <!-- Drivetrain component cards will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/inspection/engine-compartment'">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-primary me-2" id="saveDraftBtn">
                            <i class="bi bi-save"></i> Save Draft
                        </button>
                    </div>
                    
                    <button type="button" class="btn btn-success" id="completeInspectionBtn">
                        Complete Inspection <i class="bi bi-check-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/inspection-cards.js') }}"></script>
<script>
// Initialize Physical Hoist Inspection
document.addEventListener('DOMContentLoaded', function() {
    
    // Define common field configuration
    const commonFields = {
        primary_condition: {
            enabled: true,
            label: 'Primary Condition',
            type: 'select',
            options: ['Good', 'Average', 'Bad', 'N/A']
        },
        secondary_condition: {
            enabled: true,
            label: 'Secondary Condition',
            type: 'select',
            options: ['Good', 'Average', 'Bad', 'N/A']
        },
        comments: {
            enabled: true,
            label: 'Comments',
            type: 'textarea'
        }
    };

    // We need to handle multiple sections differently
    // Create the HTML for all sections first, then initialize InspectionCards once
    
    // Add suspension items to container
    const suspensionContainer = document.getElementById('suspensionAssessments');
    const engineContainer = document.getElementById('engineAssessments');
    const drivetrainContainer = document.getElementById('drivetrainAssessments');
    
    // Initialize ALL components in a single InspectionCards instance
    // This ensures images are properly tracked
    InspectionCards.init({
        formId: 'physicalHoistForm',
        containerId: 'suspensionAssessments', // Primary container
        storageKey: 'physicalHoistData',
        imageStorageKey: 'physicalHoistImages', // Single image storage
        hasOverlays: false,
        items: [
            // Suspension items
            { id: 'front_suspension', category: 'Front Suspension', panelId: 'front-suspension' },
            { id: 'rear_suspension', category: 'Rear Suspension', panelId: 'rear-suspension' },
            { id: 'shock_absorbers', category: 'Shock Absorbers', panelId: 'shock-absorbers' },
            { id: 'springs', category: 'Springs', panelId: 'springs' },
            { id: 'suspension_bushes', category: 'Suspension Bushes', panelId: 'suspension-bushes' },
            { id: 'ball_joints', category: 'Ball Joints', panelId: 'ball-joints' },
            // Engine items  
            { id: 'oil_pan', category: 'Oil Pan', panelId: 'oil-pan' },
            { id: 'transmission', category: 'Transmission', panelId: 'transmission' },
            { id: 'exhaust_system', category: 'Exhaust System', panelId: 'exhaust-system' },
            { id: 'engine_mounts', category: 'Engine Mounts', panelId: 'engine-mounts' },
            { id: 'fuel_lines', category: 'Fuel Lines', panelId: 'fuel-lines' },
            { id: 'coolant_lines', category: 'Coolant Lines', panelId: 'coolant-lines' },
            // Drivetrain items
            { id: 'drive_shafts', category: 'Drive Shafts', panelId: 'drive-shafts' },
            { id: 'cv_joints', category: 'CV Joints', panelId: 'cv-joints' },
            { id: 'differential', category: 'Differential', panelId: 'differential' },
            { id: 'propshaft', category: 'Propshaft', panelId: 'propshaft' },
            { id: 'transfer_case', category: 'Transfer Case', panelId: 'transfer-case' },
            { id: 'axles', category: 'Axles', panelId: 'axles' }
        ],
        fields: commonFields
    });
    
    // Now move the engine and drivetrain cards to their proper containers
    setTimeout(() => {
        console.log('Moving cards to proper containers...');
        
        // Move engine cards
        ['oil-pan', 'transmission', 'exhaust-system', 'engine-mounts', 'fuel-lines', 'coolant-lines'].forEach(panelId => {
            const card = document.querySelector(`[data-panel-card="${panelId}"]`);
            if (card && engineContainer) {
                console.log(`Moving engine card: ${panelId}`);
                engineContainer.appendChild(card.closest('.panel-assessment'));
            } else {
                console.log(`Engine card not found: ${panelId}`);
            }
        });
        
        // Move drivetrain cards
        ['drive-shafts', 'cv-joints', 'differential', 'propshaft', 'transfer-case', 'axles'].forEach(panelId => {
            const card = document.querySelector(`[data-panel-card="${panelId}"]`);
            if (card && drivetrainContainer) {
                console.log(`Moving drivetrain card: ${panelId}`);
                drivetrainContainer.appendChild(card.closest('.panel-assessment'));
            } else {
                console.log(`Drivetrain card not found: ${panelId}`);
            }
        });
        
        console.log('Card movement completed');
    }, 100);

    // Complete Inspection Button Handler
    document.getElementById('completeInspectionBtn').addEventListener('click', async function(e) {
        e.preventDefault();

        const inspectionId = sessionStorage.getItem('currentInspectionId') || '124';

        // Prepare API data structure
        const apiData = {
            inspection_id: inspectionId,
            components: [],
            images: []
        };

        // Collect all form data directly from the form
        const formData = new FormData(document.getElementById('physicalHoistForm'));
        
        console.log('Physical Hoist - Form Data Debug:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Process all form fields
        for (let [name, value] of formData.entries()) {
            if (name.includes('-primary_condition') || name.includes('-secondary_condition') || name.includes('-comments')) {
                const [componentId, fieldType] = name.split('-');
                
                // Determine section based on component
                let section = 'general';
                const suspensionComponents = ['front_suspension', 'rear_suspension', 'shock_absorbers', 'springs', 'suspension_bushes', 'ball_joints'];
                const engineComponents = ['oil_pan', 'transmission', 'exhaust_system', 'engine_mounts', 'fuel_lines', 'coolant_lines'];
                const drivetrainComponents = ['drive_shafts', 'cv_joints', 'differential', 'propshaft', 'transfer_case', 'axles'];
                
                if (suspensionComponents.includes(componentId)) {
                    section = 'suspension';
                } else if (engineComponents.includes(componentId)) {
                    section = 'engine';
                } else if (drivetrainComponents.includes(componentId)) {
                    section = 'drivetrain';
                }
                
                // Find existing component or create new one
                let component = apiData.components.find(c => c.component_name === componentId);
                if (!component) {
                    component = {
                        section: section,
                        component_name: componentId,
                        primary_condition: null,
                        secondary_condition: null,
                        comments: null
                    };
                    apiData.components.push(component);
                }
                
                // Set the field value
                if (fieldType === 'primary_condition') {
                    component.primary_condition = value || null;
                } else if (fieldType === 'secondary_condition') {
                    component.secondary_condition = value || null;
                } else if (fieldType === 'comments') {
                    component.comments = value || null;
                }
            }
        }

        // Remove components with no data
        apiData.components = apiData.components.filter(component => 
            component.primary_condition || component.secondary_condition || component.comments
        );

        // Collect images using InspectionCards.getImages() like Engine Compartment does
        try {
            const allImageData = InspectionCards.getImages();
            
            console.log('Physical Hoist - Image Collection Debug:', {
                hasImages: allImageData && Object.keys(allImageData).length > 0,
                imageKeys: allImageData ? Object.keys(allImageData) : [],
                totalImages: allImageData ? Object.values(allImageData).reduce((sum, arr) => sum + (Array.isArray(arr) ? arr.length : 0), 0) : 0
            });

            // Transform image data to physical hoist format
            if (allImageData && typeof allImageData === 'object') {
                for (const [componentType, componentImages] of Object.entries(allImageData)) {
                    if (Array.isArray(componentImages)) {
                        componentImages.forEach(img => {
                            if (img && img.data) {
                                const cleanComponentType = componentType.replace(/-/g, '_');
                                apiData.images.push({
                                    component_type: cleanComponentType,
                                    image_data: img.data
                                });
                                console.log('Added image for component:', cleanComponentType);
                            }
                        });
                    }
                }
            }
        } catch (e) {
            console.error('Error processing images:', e);
        }

        console.log('Physical Hoist - Final API Data:', {
            inspection_id: apiData.inspection_id,
            components_count: apiData.components.length,
            components: apiData.components,
            images_count: apiData.images.length
        });

        try {
            // Save to database via API
            const response = await fetch('/api/inspection/physical-hoist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(apiData)
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }

            const result = await response.json();

            if (result.success) {
                // Show success notification
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                    background: #28a745; color: white; border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
                    font-weight: 500;
                `;
                notification.textContent = '✅ Physical hoist inspection completed successfully!';
                document.body.appendChild(notification);

                // Clear all storage data since inspection is complete
                sessionStorage.removeItem('physicalHoistSuspensionData');
                sessionStorage.removeItem('physicalHoistEngineData');
                sessionStorage.removeItem('physicalHoistDrivetrainData');
                sessionStorage.removeItem('physicalHoistSuspensionImages');
                sessionStorage.removeItem('physicalHoistEngineImages');
                sessionStorage.removeItem('physicalHoistDrivetrainImages');

                // Navigate to completion page or dashboard after delay
                setTimeout(() => {
                    notification.remove();
                    window.location.href = '/dashboard';
                }, 2000);
            } else {
                throw new Error(result.message || 'Failed to save physical hoist inspection');
            }

        } catch (error) {
            console.error('Failed to save physical hoist inspection:', error);

            // Show error notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                background: #dc3545; color: white; border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
            `;
            notification.textContent = '❌ Failed to save physical hoist inspection: ' + error.message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.remove(), 5000);
        }
    });

    // Save Draft Button Handler - Save to database without clearing storage
    document.getElementById('saveDraftBtn').addEventListener('click', async function() {
        // Use the same save logic as Complete button but don't clear storage
        const inspectionId = sessionStorage.getItem('currentInspectionId') || '124';

        // Prepare API data structure
        const apiData = {
            inspection_id: inspectionId,
            components: [],
            images: []
        };

        // Collect all form data directly from the form
        const formData = new FormData(document.getElementById('physicalHoistForm'));
        
        // Process all form fields
        for (let [name, value] of formData.entries()) {
            if (name.includes('-primary_condition') || name.includes('-secondary_condition') || name.includes('-comments')) {
                const [componentId, fieldType] = name.split('-');
                
                // Determine section based on component
                let section = 'general';
                const suspensionComponents = ['front_suspension', 'rear_suspension', 'shock_absorbers', 'springs', 'suspension_bushes', 'ball_joints'];
                const engineComponents = ['oil_pan', 'transmission', 'exhaust_system', 'engine_mounts', 'fuel_lines', 'coolant_lines'];
                const drivetrainComponents = ['drive_shafts', 'cv_joints', 'differential', 'propshaft', 'transfer_case', 'axles'];
                
                if (suspensionComponents.includes(componentId)) {
                    section = 'suspension';
                } else if (engineComponents.includes(componentId)) {
                    section = 'engine';
                } else if (drivetrainComponents.includes(componentId)) {
                    section = 'drivetrain';
                }
                
                // Find existing component or create new one
                let component = apiData.components.find(c => c.component_name === componentId);
                if (!component) {
                    component = {
                        section: section,
                        component_name: componentId,
                        primary_condition: null,
                        secondary_condition: null,
                        comments: null
                    };
                    apiData.components.push(component);
                }
                
                // Set the field value
                if (fieldType === 'primary_condition') {
                    component.primary_condition = value || null;
                } else if (fieldType === 'secondary_condition') {
                    component.secondary_condition = value || null;
                } else if (fieldType === 'comments') {
                    component.comments = value || null;
                }
            }
        }

        // Remove components with no data
        apiData.components = apiData.components.filter(component => 
            component.primary_condition || component.secondary_condition || component.comments
        );

        // Collect images using InspectionCards.getImages()
        try {
            const allImageData = InspectionCards.getImages();

            // Transform image data to physical hoist format
            if (allImageData && typeof allImageData === 'object') {
                for (const [componentType, componentImages] of Object.entries(allImageData)) {
                    if (Array.isArray(componentImages)) {
                        componentImages.forEach(img => {
                            if (img && img.data) {
                                const cleanComponentType = componentType.replace(/-/g, '_');
                                apiData.images.push({
                                    component_type: cleanComponentType,
                                    image_data: img.data
                                });
                            }
                        });
                    }
                }
            }
        } catch (e) {
            console.error('Error processing images:', e);
        }

        try {
            // Save to database via API
            const response = await fetch('/api/inspection/physical-hoist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(apiData)
            });

            if (response.ok) {
                // Show success notification
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                    background: #28a745; color: white; border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
                `;
                notification.textContent = '✅ Draft saved successfully!';
                document.body.appendChild(notification);
                
                setTimeout(() => notification.remove(), 3000);
            } else {
                throw new Error('Failed to save draft');
            }
        } catch (error) {
            console.error('Failed to save draft:', error);
            
            // Show error notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                background: #dc3545; color: white; border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
            `;
            notification.textContent = '❌ Failed to save draft';
            document.body.appendChild(notification);
            
            setTimeout(() => notification.remove(), 3000);
        }
    });
});
</script>
@endsection
