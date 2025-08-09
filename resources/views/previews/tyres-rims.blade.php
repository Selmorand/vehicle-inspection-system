@extends('layouts.app')

@section('title', 'Tyres & Rims Assessment Preview - Simple Data View')

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
    
    .tyre-preview-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .tyre-preview-header {
        background: #4f959b;
        color: white;
        padding: 1rem 1.5rem;
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .tyre-preview-body {
        padding: 1.5rem;
    }
    
    .tyre-data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .data-field {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #4f959b;
    }
    
    .data-label {
        font-weight: bold;
        color: #495057;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }
    
    .data-value {
        color: #212529;
        font-size: 1rem;
    }
    
    .image-indicator {
        color: #4f959b;
        font-weight: 500;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 6px;
        border-left: 4px solid #28a745;
        margin-top: 1rem;
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
    
    .tyre-disclaimer {
        background: #e8f4f8;
        border: 1px solid #4f959b;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
        color: #2b2b2b;
    }
    
    .tyre-disclaimer h5 {
        color: #4f959b;
        margin-bottom: 1rem;
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
        <h1 class="h3 mb-0">Tyres & Rims Assessment - Simple Preview</h1>
        <p class="mb-0 mt-2 opacity-90">This shows exactly what data is being captured from your tyres & rims assessment form</p>
    </div>
    
    <!-- Summary Section -->
    <div class="preview-summary">
        <div class="summary-stat">
            <strong>Total Tyres Assessed:</strong> {{ $totalTyres }}
        </div>
        <div class="summary-stat">
            <strong>Total Images Captured:</strong> {{ $totalImages }}
        </div>
        <div class="summary-stat">
            <strong>Data Size:</strong> {{ number_format($rawDataSize / 1024, 2) }} KB
        </div>
    </div>
    
    <!-- Tyre Data Display -->
    @if(count($tyres) > 0)
        @foreach($tyres as $tyreId => $tyre)
            <div class="tyre-preview-card">
                <div class="tyre-preview-header">
                    {{ $tyre['name'] }}
                    @if(isset($tyre['has_images']) && $tyre['has_images'])
                        <span class="float-end">
                            <i class="bi bi-camera-fill"></i> {{ $tyre['image_count'] }} image(s)
                        </span>
                    @endif
                </div>
                <div class="tyre-preview-body">
                    <div class="tyre-data-grid">
                        @if(isset($tyre['data']['size']))
                            <div class="data-field">
                                <div class="data-label">Size:</div>
                                <div class="data-value">{{ $tyre['data']['size'] }}</div>
                            </div>
                        @endif
                        
                        @if(isset($tyre['data']['manufacture']))
                            <div class="data-field">
                                <div class="data-label">Manufacture:</div>
                                <div class="data-value">{{ $tyre['data']['manufacture'] }}</div>
                            </div>
                        @endif
                        
                        @if(isset($tyre['data']['model']))
                            <div class="data-field">
                                <div class="data-label">Model:</div>
                                <div class="data-value">{{ $tyre['data']['model'] }}</div>
                            </div>
                        @endif
                        
                        @if(isset($tyre['data']['tread_depth']))
                            <div class="data-field">
                                <div class="data-label">Tread Depth:</div>
                                <div class="data-value">{{ $tyre['data']['tread_depth'] }}</div>
                            </div>
                        @endif
                        
                        @if(isset($tyre['data']['damages']))
                            <div class="data-field">
                                <div class="data-label">Damages:</div>
                                <div class="data-value">{{ $tyre['data']['damages'] }}</div>
                            </div>
                        @endif
                    </div>
                    
                    @if(isset($tyre['has_images']) && $tyre['has_images'])
                        <div class="image-indicator">
                            <i class="bi bi-check-circle-fill"></i> {{ $tyre['image_count'] }} image(s) captured for this tyre
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="tyre-preview-card">
            <div class="tyre-preview-body">
                <div class="no-data">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">No Tyre Assessment Data Found</h4>
                    <p>Please go back and fill out at least one tyre assessment before previewing.</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Tyre Safety Information -->
    <div class="tyre-disclaimer">
        <h5><i class="bi bi-shield-check"></i> Tyre Safety Information</h5>
        <p class="mb-2">It is recommended that tyres are replaced when the tread depth reaches 2mm. If uneven tyre wear is noted, this may indicate incorrect geometry, which can result in excessive and rapid tyre wear. A full steering and geometry check is therefore recommended.</p>
        <p class="mb-2">If this vehicle is fitted with "Run Flat" tyres and no spare wheel, the tyre's effectiveness in a puncture situation cannot be commented on.</p>
        <p class="mb-0">It is advised to have tyres of the correct size and of similar make, tread pattern and tread depth across axles. This will benefit steering and handling, the operation of the transmission, 4 wheel drive, traction control, ABS and puncture detection systems. This can also prevent premature transmission wear or failure.</p>
    </div>
    
    <!-- Data Verification Notice -->
    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle"></i> Data Verification</h5>
        <p class="mb-2">This preview shows the raw data captured from your Tyres & Rims Assessment form.</p>
        <ul class="mb-0">
            <li>✅ If you see your tyre assessments above, the data capture is working correctly</li>
            <li>✅ This is the exact data that will be saved to the database</li>
            <li>✅ The final report will display this data in a more polished format</li>
            <li>🚗 Tyre fields include: Size, Manufacture, Model, Tread Depth, Damages, plus photos</li>
        </ul>
    </div>
</div>
@endsection