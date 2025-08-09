@extends('layouts.app')

@section('title', 'Physical Hoist Inspection Preview - Simple Data View')

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
        min-width: 180px;
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
        margin-right: 0.5rem;
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
    
    .category-icon {
        margin-right: 0.5rem;
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
        <h1 class="h3 mb-0">Physical Hoist Inspection - Simple Preview</h1>
        <p class="mb-0 mt-2 opacity-90">This shows exactly what data is being captured from your physical hoist inspection form</p>
    </div>
    
    <!-- Summary Section -->
    <div class="preview-summary">
        <div class="summary-stat">
            <strong>Suspension Components:</strong> {{ $totalSuspensionComponents }}
        </div>
        <div class="summary-stat">
            <strong>Engine Components:</strong> {{ $totalEngineComponents }}
        </div>
        <div class="summary-stat">
            <strong>Drivetrain Components:</strong> {{ $totalDrivetrainComponents }}
        </div>
        <div class="summary-stat">
            <strong>Total Images:</strong> {{ $totalImages }}
        </div>
        <div class="summary-stat">
            <strong>Data Size:</strong> {{ number_format($rawDataSize / 1024, 2) }} KB
        </div>
    </div>
    
    <!-- Suspension System Section -->
    @if(count($suspensionComponents) > 0)
        <div class="section-header">
            <i class="bi bi-gear-wide-connected category-icon"></i>Suspension System Assessment
        </div>
        
        @foreach($suspensionComponents as $componentId => $component)
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
                    @if(isset($component['data']['primary_condition']))
                        <div class="data-row">
                            <div class="data-label">Primary Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['primary_condition']) }}">
                                    {{ $component['data']['primary_condition'] }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    @if(isset($component['data']['secondary_condition']))
                        <div class="data-row">
                            <div class="data-label">Secondary Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['secondary_condition']) }}">
                                    {{ $component['data']['secondary_condition'] }}
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
    
    <!-- Engine System Section -->
    @if(count($engineComponents) > 0)
        <div class="section-header">
            <i class="bi bi-wrench category-icon"></i>Engine System Assessment
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
                    @if(isset($component['data']['primary_condition']))
                        <div class="data-row">
                            <div class="data-label">Primary Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['primary_condition']) }}">
                                    {{ $component['data']['primary_condition'] }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    @if(isset($component['data']['secondary_condition']))
                        <div class="data-row">
                            <div class="data-label">Secondary Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['secondary_condition']) }}">
                                    {{ $component['data']['secondary_condition'] }}
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
    
    <!-- Drivetrain System Section -->
    @if(count($drivetrainComponents) > 0)
        <div class="section-header">
            <i class="bi bi-arrow-repeat category-icon"></i>Drivetrain System Assessment
        </div>
        
        @foreach($drivetrainComponents as $componentId => $component)
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
                    @if(isset($component['data']['primary_condition']))
                        <div class="data-row">
                            <div class="data-label">Primary Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['primary_condition']) }}">
                                    {{ $component['data']['primary_condition'] }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    @if(isset($component['data']['secondary_condition']))
                        <div class="data-row">
                            <div class="data-label">Secondary Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($component['data']['secondary_condition']) }}">
                                    {{ $component['data']['secondary_condition'] }}
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
    @if(count($suspensionComponents) == 0 && count($engineComponents) == 0 && count($drivetrainComponents) == 0)
        <div class="component-preview-card">
            <div class="component-preview-body">
                <div class="no-data">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">No Physical Hoist Assessment Data Found</h4>
                    <p>Please go back and fill out at least one suspension, engine, or drivetrain component assessment before previewing.</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Debug Section (temporary) -->
    @if(isset($dataToProcess) && count($dataToProcess) > 0)
        <div class="alert alert-warning mt-4">
            <h5><i class="bi bi-bug"></i> Debug Information (Raw Form Data)</h5>
            <div style="max-height: 300px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 12px;">
                <div style="color: #d63384; font-weight: bold;">SUSPENSION FIELDS:</div>
                @foreach($dataToProcess as $key => $value)
                    @if(str_contains($key, '_shock_') || str_contains($key, '_control_arm_'))
                        <div><strong>{{ $key }}:</strong> {{ $value }}</div>
                    @endif
                @endforeach
                
                <div style="color: #d63384; font-weight: bold; margin-top: 10px;">ENGINE FIELDS:</div>
                @foreach($dataToProcess as $key => $value)
                    @if(str_contains($key, 'engine_') || str_contains($key, 'gearbox_') || str_contains($key, 'timing_') || str_contains($key, 'sump') || str_contains($key, '_main_seal'))
                        <div><strong>{{ $key }}:</strong> {{ $value }}</div>
                    @endif
                @endforeach
                
                <div style="color: #d63384; font-weight: bold; margin-top: 10px;">DRIVETRAIN FIELDS:</div>
                @foreach($dataToProcess as $key => $value)
                    @if(str_contains($key, '_cv_') || str_contains($key, 'propshaft') || str_contains($key, 'centre_') || str_contains($key, 'differential_'))
                        <div><strong>{{ $key }}:</strong> {{ $value }}</div>
                    @endif
                @endforeach
                
                <div style="color: #d63384; font-weight: bold; margin-top: 10px;">TOTALS:</div>
                <div><strong>Suspension Components Found:</strong> {{ count($suspensionComponents) }}</div>
                <div><strong>Engine Components Found:</strong> {{ count($engineComponents) }}</div>
                <div><strong>Drivetrain Components Found:</strong> {{ count($drivetrainComponents) }}</div>
            </div>
            <small class="text-muted">This shows all form fields with values that were captured, organized by category.</small>
        </div>
    @endif

    <!-- Data Verification Notice -->
    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle"></i> Data Verification</h5>
        <p class="mb-2">This preview shows the raw data captured from your Physical Hoist Inspection form.</p>
        <ul class="mb-0">
            <li>✅ If you see your assessments above, the data capture is working correctly</li>
            <li>✅ This is the exact data that will be saved to the database</li>
            <li>✅ The final report will display this data in a more polished format</li>
            <li>🔧 Each component has primary and secondary condition fields for detailed assessment</li>
            <li>📸 Camera functionality allows capturing images of specific components</li>
            <li>🚗 Three categories: Suspension (shocks, mounts), Engine (oils, seals), Drivetrain (CV joints, propshaft)</li>
        </ul>
    </div>
</div>
@endsection