@extends('layouts.app')

@section('title', 'Service Booklet')

@section('content')
<div class="container">
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
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Service Booklet</li>
                    <li class="breadcrumb-item text-muted">Final Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Service Booklet Documentation</h2>
        <p class="text-muted">Take photos of service booklet pages and add any relevant comments about the vehicle's service history.</p>
    </div>

    <form id="service-booklet-form" enctype="multipart/form-data">
        @csrf
        
        <!-- Service Booklet Assessment Cards -->
        <div id="serviceBookletAssessments">
            <!-- Service booklet cards will be generated here -->
        </div>

        <!-- Action buttons -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-secondary me-3" onclick="goBack()">
                <i class="bi bi-arrow-left me-1"></i>Back to Interior Assessment
            </button>
            <button type="button" class="btn btn-secondary me-3" onclick="saveDraft()">
                Save Draft
            </button>
            <button type="button" class="btn btn-primary" onclick="continueToFinalReport()">
                Continue to Tyres & Rims Assessment <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('additional-css')
<link rel="stylesheet" href="{{ asset('css/panel-cards.css') }}">
@endsection

@section('additional-js')
<script src="{{ asset('js/inspection-cards.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the reusable InspectionCards system for service booklet
    InspectionCards.init({
        // Required Configuration
        formId: 'service-booklet-form',
        containerId: 'serviceBookletAssessments',
        storageKey: 'serviceBookletData',
        
        // Service booklet specific configuration
        hasColorField: false,
        hasOverlays: false,
        
        // Service booklet items - in order: Images first, then text sections
        items: [
            { id: 'service_images', category: 'Service Booklet Images', panelId: null, hasCamera: true },
            { id: 'service_comments', category: 'Service History Comments', panelId: null, hasCamera: false },
            { id: 'service_recommendations', category: 'Service Recommendations', panelId: null, hasCamera: false }
        ],
        
        // Custom field configuration for service booklet
        fields: {
            condition: { 
                enabled: false
            },
            comments: { 
                enabled: true, 
                label: 'Notes', 
                type: 'textarea', 
                placeholder: 'Add relevant information...',
                rows: 6
            }
        },
        
        // Custom placeholders for each section
        customPlaceholders: {
            'service_images': 'Take photos of service booklet pages',
            'service_comments': 'Add relevant comments about the vehicle\'s service history, maintenance records, or observations from the service booklet...',
            'service_recommendations': 'Any recommended services or maintenance based on the service history review...'
        },
        
        // Callback for form submission
        onFormSubmit: function(data) {
            sessionStorage.setItem('serviceBookletData', JSON.stringify(data));
            window.location.href = '/inspection/tyres-rims';
        }
    });
    
    // Display inspection progress summary
    displayInspectionSummary();
});

function displayInspectionSummary() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    
    if (visualData) {
        const data = JSON.parse(visualData);
        const breadcrumbContainer = document.querySelector('.breadcrumb').parentElement.parentElement;
        const summaryDiv = document.createElement('div');
        summaryDiv.className = 'row mb-3';
        summaryDiv.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info">
                    <strong>Inspection Progress:</strong>
                    ${data.manufacturer || 'Unknown'} ${data.model || 'Vehicle'} (${data.vehicle_type || 'Vehicle'}) | 
                    VIN: ${data.vin || 'Not specified'} | 
                    Inspector: ${data.inspector_name || 'Not specified'} |
                    Progress: Visual ✓ | Body Panels ✓ | Interior Assessment ✓ | Service Booklet
                </div>
            </div>
        `;
        breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
    }
}

function goBack() {
    if (confirm('Are you sure you want to go back? Any unsaved data will be lost.')) {
        window.location.href = '/inspection/interior';
    }
}

function saveDraft() {
    InspectionCards.saveData();
    alert('Service booklet draft saved successfully!');
}

async function continueToFinalReport() {
    console.log('Service Booklet: Starting save and navigation...');
    
    // Get current inspection ID
    const inspectionId = sessionStorage.getItem('currentInspectionId');
    console.log('Current Inspection ID:', inspectionId);
    
    // Get form data and images from InspectionCards
    let formData = {};
    let imageData = {};
    
    try {
        if (window.InspectionCards && typeof InspectionCards.getFormData === 'function') {
            formData = InspectionCards.getFormData();
            imageData = InspectionCards.getImages();
            console.log('Service Booklet Form Data:', formData);
            console.log('Service Booklet Images:', imageData);
        }
    } catch (e) {
        console.error('Error getting InspectionCards data:', e);
    }
    
    // Extract service comments and recommendations from form data
    const serviceComments = formData['service_comments-comments'] || '';
    const serviceRecommendations = formData['service_recommendations-comments'] || '';
    
    // Prepare API data (JSON like interior assessment)
    const apiData = {
        inspection_id: inspectionId,
        service_comments: serviceComments,
        service_recommendations: serviceRecommendations,
        images: imageData
    };
    
    console.log('Service booklet API data prepared:', apiData);
    
    try {
        // Save to database via API (JSON like interior assessment)
        const response = await fetch('/api/inspection/service-booklet', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(apiData)
        });
        
        console.log('Service booklet API Response status:', response.status);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Service booklet API Error Response:', errorText);
            throw new Error(`HTTP ${response.status}: ${errorText}`);
        }
        
        const result = await response.json();
        console.log('Service booklet API Response:', result);
        
        if (result.success) {
            console.log('✅ Service booklet saved successfully!');
            
            // Also save to sessionStorage for compatibility
            InspectionCards.saveData();
            
            // Show success message
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                background-color: #28a745; color: white; border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 9999;
            `;
            notification.textContent = 'Service booklet saved to database successfully!';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
                window.location.href = '/inspection/tyres-rims';
            }, 1500);
        } else {
            throw new Error(result.message || 'Failed to save service booklet');
        }
    } catch (error) {
        console.error('Database save failed:', error);
        alert('Warning: Data saved locally only. Database save failed: ' + error.message);
        
        // Save to sessionStorage anyway and continue
        InspectionCards.saveData();
        setTimeout(() => {
            window.location.href = '/inspection/tyres-rims';
        }, 2000);
    }
}
</script>
