@extends('layouts.app')

@section('title', 'Engine Compartment Assessment Preview - Simple Data View')

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
    
    .section-header {
        background: #4f959b;
        color: white;
        padding: 1rem 1.5rem;
        margin: 2rem 0 1rem 0;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .findings-section {
        background: #fff8dc;
        border: 1px solid #f0e68c;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .finding-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: white;
        border-radius: 6px;
        border-left: 4px solid #4f959b;
    }
    
    .finding-item:last-child {
        margin-bottom: 0;
    }
    
    .finding-icon {
        color: #4f959b;
        font-size: 1.2rem;
        margin-right: 1rem;
        margin-top: 0.2rem;
    }
    
    .finding-content {
        flex: 1;
    }
    
    .finding-text {
        font-size: 0.95rem;
        color: #2b2b2b;
        line-height: 1.4;
        margin-bottom: 0;
    }
    
    .finding-note {
        background: #e8f4f8;
        padding: 0.75rem;
        border-radius: 4px;
        border-left: 4px solid #17a2b8;
        margin-top: 0.5rem;
        font-style: italic;
        color: #495057;
    }
    
    .component-preview-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .component-preview-header {
        background: #e8f4f8;
        color: #2b2b2b;
        padding: 1rem 1.5rem;
        font-weight: bold;
        border-bottom: 1px solid #dee2e6;
    }
    
    .component-preview-body {
        padding: 1.5rem;
    }
    
    .data-row {
        display: flex;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .data-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .data-label {
        font-weight: bold;
        color: #495057;
        min-width: 120px;
        text-transform: capitalize;
    }
    
    .data-value {
        color: #212529;
        flex: 1;
    }
    
    .condition-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-weight: bold;
        color: white;
        display: inline-block;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    
    .condition-good {
        background-color: #277020;
    }
    
    .condition-average {
        background-color: #f5a409;
    }
    
    .condition-bad {
        background-color: #c62121;
    }
    
    .condition-na {
        background-color: #6c757d;
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
    
    .engine-info {
        background: #e8f4f8;
        border: 1px solid #4f959b;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .engine-info h5 {
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
        <h1 class="h3 mb-0">Engine Compartment Assessment - Simple Preview</h1>
        <p class="mb-0 mt-2 opacity-90">This shows exactly what data is being captured from your engine compartment assessment form</p>
    </div>
    
    <!-- Summary Section -->
    <div class="preview-summary">
        <div class="summary-stat">
            <strong>Findings Recorded:</strong> {{ $totalFindings }}
        </div>
        <div class="summary-stat">
            <strong>Components Assessed:</strong> {{ $totalComponents }}
        </div>
        <div class="summary-stat">
            <strong>Total Images Captured:</strong> {{ $totalImages }}
        </div>
        <div class="summary-stat">
            <strong>Data Size:</strong> {{ number_format($rawDataSize / 1024, 2) }} KB
        </div>
    </div>
    
    <!-- Engine Compartment Information -->
    <div class="engine-info">
        <h5><i class="bi bi-gear-fill"></i> Engine Compartment Assessment</h5>
        <p class="mb-0">This assessment documents engine compartment findings, observations, and component conditions to ensure comprehensive inspection coverage.</p>
    </div>
    
    <!-- Findings Section -->
    @if(count($findings) > 0)
        <div class="section-header">
            <i class="bi bi-clipboard-check-fill"></i> Inspection Findings & Observations
        </div>
        
        <div class="findings-section">
            @foreach($findings as $finding)
                <div class="finding-item">
                    <div class="finding-icon">
                        @if($finding['type'] == 'note')
                            <i class="bi bi-pencil-square"></i>
                        @else
                            <i class="bi bi-check-circle-fill"></i>
                        @endif
                    </div>
                    <div class="finding-content">
                        @if($finding['type'] == 'note')
                            <div class="finding-note">
                                <strong>{{ $finding['name'] }}:</strong><br>
                                {{ $finding['value'] }}
                            </div>
                        @else
                            <div class="finding-text">
                                {{ $finding['name'] }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <!-- Engine Components Section -->
    @if(count($engineComponents) > 0)
        <div class="section-header">
            <i class="bi bi-wrench"></i> Engine Component Assessment
        </div>
        
        @foreach($engineComponents as $componentId => $component)
            <div class="component-preview-card">
                <div class="component-preview-header">
                    {{ $component['name'] }}
                    @if(isset($component['has_images']) && $component['has_images'])
                        <span class="float-end">
                            <i class="bi bi-camera-fill"></i> {{ $component['image_count'] }} image(s)
                        </span>
                    @endif
                </div>
                <div class="component-preview-body">
                    @if(isset($component['data']['condition']))
                        <div class="data-row">
                            <div class="data-label">Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['condition']) }}">
                                    {{ $component['data']['condition'] }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    @if(isset($component['data']['comments']) && $component['data']['comments'])
                        <div class="data-row">
                            <div class="data-label">Comments:</div>
                            <div class="data-value">{{ $component['data']['comments'] }}</div>
                        </div>
                    @endif
                    
                    @if(isset($component['has_images']) && $component['has_images'])
                        <div class="image-indicator">
                            <i class="bi bi-check-circle-fill"></i> {{ $component['image_count'] }} image(s) captured for this component
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
    
    <!-- No Data Message -->
    @if(count($findings) == 0 && count($engineComponents) == 0)
        <div class="component-preview-card">
            <div class="component-preview-body">
                <div class="no-data">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">No Engine Compartment Assessment Data Found</h4>
                    <p>Please go back and fill out the assessment:<br>
                    1. Check relevant findings boxes<br>
                    2. Add notes if needed<br>
                    3. Assess engine components<br>
                    4. Upload images if required</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Data Verification Notice -->
    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle"></i> Data Verification</h5>
        <p class="mb-2">This preview shows the raw data captured from your Engine Compartment Assessment form.</p>
        <ul class="mb-0">
            <li>✅ If you see your findings and assessments above, the data capture is working correctly</li>
            <li>✅ This is the exact data that will be saved to the database</li>
            <li>✅ The final report will display this data in a more polished format</li>
            <li>📋 Engine components include: Brake fluid, coolant, oil levels, battery, belts, mounts, etc.</li>
            <li>🔍 Findings include: Engine number verification, deficiencies, structural damage, component presence</li>
        </ul>
    </div>
</div>
@endsection