@extends('layouts.app')

@section('title', 'Service Booklet Preview - Simple Data View')

@section('additional-css')
<style>
    .preview-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .preview-header {
        background: linear-gradient(135deg, #4f959b 0%, #3d7a7f 100%);
        color: white;
        padding: 2rem;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0;
    }
    
    .preview-summary {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-radius: 0 0 8px 8px;
    }
    
    .service-preview-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .service-preview-header {
        background: #4f959b;
        color: white;
        padding: 1rem 1.5rem;
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .service-preview-body {
        padding: 1.5rem;
    }
    
    .service-field {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .service-field:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .field-label {
        font-weight: bold;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .field-value {
        color: #212529;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 4px;
        border-left: 4px solid #4f959b;
        white-space: pre-wrap;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .image-indicator {
        color: #4f959b;
        font-weight: 500;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 4px;
        border-left: 4px solid #4f959b;
    }
    
    .no-data {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
    
    .back-button {
        margin-bottom: 2rem;
    }
    
    .summary-stat {
        display: inline-block;
        margin-right: 2rem;
    }
    
    .summary-stat strong {
        color: #4f959b;
    }
</style>
@endsection

@section('content')
<div class="preview-container">
    <!-- Back Button -->
    <div class="back-button">
        <button onclick="window.close()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Close Preview
        </button>
    </div>
    
    <!-- Preview Header -->
    <div class="preview-header">
        <h1 class="h3 mb-0">Service Booklet - Simple Preview</h1>
        <p class="mb-0 mt-2 opacity-90">This shows exactly what data is being captured from your service booklet form</p>
    </div>
    
    <!-- Summary Section -->
    <div class="preview-summary">
        <div class="summary-stat">
            <strong>Total Fields Completed:</strong> {{ $totalFields }}
        </div>
        <div class="summary-stat">
            <strong>Total Images Captured:</strong> {{ $totalImages }}
        </div>
        <div class="summary-stat">
            <strong>Data Size:</strong> {{ number_format($rawDataSize / 1024, 2) }} KB
        </div>
    </div>
    
    <!-- Service Data Display -->
    @if(count($serviceData) > 0)
        <div class="service-preview-card">
            <div class="service-preview-header">
                Service Booklet Documentation
                @if(isset($serviceData['images']) && $serviceData['images']['has_images'])
                    <span class="float-end">
                        <i class="bi bi-camera-fill"></i> {{ $serviceData['images']['count'] }} image(s)
                    </span>
                @endif
            </div>
            <div class="service-preview-body">
                @foreach($serviceData as $key => $field)
                    @if($key !== 'images')
                        <div class="service-field">
                            <div class="field-label">{{ $field['name'] }}:</div>
                            <div class="field-value">{{ $field['value'] }}</div>
                        </div>
                    @endif
                @endforeach
                
                @if(isset($serviceData['images']) && $serviceData['images']['has_images'])
                    <div class="service-field">
                        <div class="field-label">{{ $serviceData['images']['name'] }}:</div>
                        <div class="image-indicator">
                            <i class="bi bi-check-circle-fill"></i> {{ $serviceData['images']['count'] }} image(s) captured
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="service-preview-card">
            <div class="service-preview-body">
                <div class="no-data">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">No Service Booklet Data Found</h4>
                    <p>Please go back and add service booklet images or comments before previewing.</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Data Verification Notice -->
    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle"></i> Data Verification</h5>
        <p class="mb-2">This preview shows the raw data captured from your Service Booklet form.</p>
        <ul class="mb-0">
            <li>✅ If you see your comments above, the data capture is working correctly</li>
            <li>✅ This is the exact data that will be saved to the database</li>
            <li>✅ The final report will display this data in a more polished format</li>
            <li>📋 Service Booklet captures: Service History Comments, Service Recommendations, and Photos of service booklet pages</li>
        </ul>
    </div>
</div>
@endsection