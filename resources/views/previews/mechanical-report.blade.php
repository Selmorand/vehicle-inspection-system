@extends('layouts.app')

@section('title', 'Mechanical Report Preview - Simple Data View')

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
        min-width: 150px;
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
    
    .brake-data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .brake-field {
        background: #f8f9fa;
        padding: 0.75rem;
        border-radius: 6px;
        border-left: 4px solid #4f959b;
    }
    
    .brake-field-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .brake-field-value {
        font-size: 1rem;
        color: #212529;
        font-weight: 500;
    }
    
    .life-indicator {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: bold;
        color: white;
        display: inline-block;
    }
    
    .life-good {
        background-color: #28a745;
    }
    
    .life-average {
        background-color: #ffc107;
        color: #212529;
    }
    
    .life-bad {
        background-color: #dc3545;
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
    
    .road-test-info {
        background: #e8f4f8;
        border: 1px solid #4f959b;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .road-test-info h5 {
        color: #4f959b;
        margin-bottom: 1rem;
    }
    
    .brake-disclaimer {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
        color: #856404;
        font-size: 0.9rem;
    }
    
    .brake-disclaimer h5 {
        color: #856404;
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
        <h1 class="h3 mb-0">Mechanical Report - Simple Preview</h1>
        <p class="mb-0 mt-2 opacity-90">This shows exactly what data is being captured from your mechanical report form</p>
    </div>
    
    <!-- Summary Section -->
    <div class="preview-summary">
        <div class="summary-stat">
            <strong>Mechanical Components Assessed:</strong> {{ $totalMechanicalComponents }}
        </div>
        <div class="summary-stat">
            <strong>Braking Components Assessed:</strong> {{ $totalBrakingComponents }}
        </div>
        <div class="summary-stat">
            <strong>Total Images Captured:</strong> {{ $totalImages }}
        </div>
        <div class="summary-stat">
            <strong>Data Size:</strong> {{ number_format($rawDataSize / 1024, 2) }} KB
        </div>
    </div>
    
    <!-- Road Test Information -->
    <div class="road-test-info">
        <h5><i class="bi bi-speedometer2"></i> Road Test Information</h5>
        <div class="row">
            <div class="col-md-6">
                <strong>Test Distance:</strong> 0-5 Km
            </div>
            <div class="col-md-6">
                <strong>Speed Achieved:</strong> Up to 100 km/h
            </div>
        </div>
    </div>
    
    <!-- Mechanical Components Section -->
    @if(count($mechanicalComponents) > 0)
        <div class="section-header">
            <i class="bi bi-gear-fill"></i> Mechanical Components Assessment
        </div>
        
        @foreach($mechanicalComponents as $componentId => $component)
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
    
    <!-- Braking System Section -->
    @if(count($brakingComponents) > 0)
        <div class="section-header">
            <i class="bi bi-disc"></i> Braking System Assessment
        </div>
        
        @foreach($brakingComponents as $positionId => $brake)
            <div class="component-preview-card">
                <div class="component-preview-header">
                    {{ $brake['name'] }} Brake System
                    @if(isset($brake['has_images']) && $brake['has_images'])
                        <span class="float-end">
                            <i class="bi bi-camera-fill"></i> {{ $brake['image_count'] }} image(s)
                        </span>
                    @endif
                </div>
                <div class="component-preview-body">
                    <div class="brake-data-grid">
                        @if(isset($brake['data']['pad_life']))
                            <div class="brake-field">
                                <div class="brake-field-label">Brake Pad Life:</div>
                                <div class="brake-field-value">
                                    @php
                                        $padLife = $brake['data']['pad_life'];
                                        $lifeClass = 'life-good';
                                        if (str_replace('%', '', $padLife) < 50) $lifeClass = 'life-average';
                                        if (str_replace('%', '', $padLife) < 25) $lifeClass = 'life-bad';
                                    @endphp
                                    <span class="life-indicator {{ $lifeClass }}">{{ $padLife }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if(isset($brake['data']['pad_condition']))
                            <div class="brake-field">
                                <div class="brake-field-label">Pad Condition:</div>
                                <div class="brake-field-value">
                                    <span class="condition-badge condition-{{ strtolower($brake['data']['pad_condition']) }}">
                                        {{ $brake['data']['pad_condition'] }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        
                        @if(isset($brake['data']['disc_life']))
                            <div class="brake-field">
                                <div class="brake-field-label">Brake Disc Life:</div>
                                <div class="brake-field-value">
                                    @php
                                        $discLife = $brake['data']['disc_life'];
                                        $lifeClass = 'life-good';
                                        if (str_replace('%', '', $discLife) < 50) $lifeClass = 'life-average';
                                        if (str_replace('%', '', $discLife) < 25) $lifeClass = 'life-bad';
                                    @endphp
                                    <span class="life-indicator {{ $lifeClass }}">{{ $discLife }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if(isset($brake['data']['disc_condition']))
                            <div class="brake-field">
                                <div class="brake-field-label">Disc Condition:</div>
                                <div class="brake-field-value">
                                    <span class="condition-badge condition-{{ strtolower($brake['data']['disc_condition']) }}">
                                        {{ $brake['data']['disc_condition'] }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if(isset($brake['data']['comments']) && $brake['data']['comments'])
                        <div class="data-row">
                            <div class="data-label">Comments:</div>
                            <div class="data-value">{{ $brake['data']['comments'] }}</div>
                        </div>
                    @endif
                    
                    @if(isset($brake['has_images']) && $brake['has_images'])
                        <div class="image-indicator">
                            <i class="bi bi-check-circle-fill"></i> {{ $brake['image_count'] }} image(s) captured for this brake position
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        
        <!-- Braking System Disclaimer -->
        <div class="brake-disclaimer">
            <h5><i class="bi bi-exclamation-triangle"></i> Important Braking System Information</h5>
            <p class="mb-2"><strong>Although the visible brake discs and pads only show some signs of general serviceable wear, it is strongly advised to remove all road wheels and examine the inner brake components, which are obscured on this vehicle prior to purchase, replacing any worn or badly corroded parts.</strong></p>
            <p class="mb-0"><strong>If this vehicle is fitted with an electronic parking brake, please ensure that you are conversant with its operation.</strong></p>
        </div>
    @endif
    
    <!-- No Data Message -->
    @if(count($mechanicalComponents) == 0 && count($brakingComponents) == 0)
        <div class="component-preview-card">
            <div class="component-preview-body">
                <div class="no-data">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">No Mechanical Assessment Data Found</h4>
                    <p>Please go back and fill out at least one mechanical component or braking system assessment before previewing.</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Debug Section (temporary) -->
    @if(isset($debugData) && count($debugData) > 0)
        <div class="alert alert-warning mt-4">
            <h5><i class="bi bi-bug"></i> Debug Information (Raw Form Data)</h5>
            <div style="max-height: 300px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 12px;">
                <div style="color: #d63384; font-weight: bold;">MECHANICAL FIELDS:</div>
                @foreach($debugData as $key => $value)
                    @if(!str_contains($key, 'brake_'))
                        <div><strong>{{ $key }}:</strong> {{ $value }}</div>
                    @endif
                @endforeach
                
                <div style="color: #d63384; font-weight: bold; margin-top: 10px;">BRAKING FIELDS:</div>
                @foreach($debugData as $key => $value)
                    @if(str_contains($key, 'brake_'))
                        <div><strong>{{ $key }}:</strong> {{ $value }}</div>
                    @endif
                @endforeach
                
                <div style="color: #d63384; font-weight: bold; margin-top: 10px;">TOTALS:</div>
                <div><strong>Mechanical Components Found:</strong> {{ count($mechanicalComponents) }}</div>
                <div><strong>Braking Components Found:</strong> {{ count($brakingComponents) }}</div>
            </div>
            <small class="text-muted">This shows all form fields with values that were captured, separated by type.</small>
        </div>
    @endif

    <!-- Data Verification Notice -->
    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle"></i> Data Verification</h5>
        <p class="mb-2">This preview shows the raw data captured from your Mechanical Report form.</p>
        <ul class="mb-0">
            <li>✅ If you see your assessments above, the data capture is working correctly</li>
            <li>✅ This is the exact data that will be saved to the database</li>
            <li>✅ The final report will display this data in a more polished format</li>
            <li>🔧 Mechanical components include engine, transmission, steering, brakes, electrical systems, etc.</li>
            <li>🛞 Braking system includes pad life, disc life, conditions, and detailed assessments</li>
        </ul>
    </div>
</div>
@endsection