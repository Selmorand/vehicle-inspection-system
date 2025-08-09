@extends('layouts.app')

@section('title', 'Body Panel Preview - Simple Data View')

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
    
    .panel-preview-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .panel-preview-header {
        background: #4f959b;
        color: white;
        padding: 1rem 1.5rem;
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .panel-preview-body {
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
    
    .image-indicator {
        color: #4f959b;
        font-weight: 500;
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
        <h1 class="h3 mb-0">Body Panel Assessment - Simple Preview</h1>
        <p class="mb-0 mt-2 opacity-90">This shows exactly what data is being captured from your form</p>
    </div>
    
    <!-- Summary Section -->
    <div class="preview-summary">
        <div class="summary-stat">
            <strong>Total Panels Assessed:</strong> {{ $totalPanels }}
        </div>
        <div class="summary-stat">
            <strong>Total Images Captured:</strong> {{ $totalImages }}
        </div>
        <div class="summary-stat">
            <strong>Data Size:</strong> {{ number_format($rawDataSize / 1024, 2) }} KB
        </div>
    </div>
    
    <!-- Panel Data Display -->
    @if(count($panels) > 0)
        @foreach($panels as $panelId => $panel)
            <div class="panel-preview-card">
                <div class="panel-preview-header">
                    {{ $panel['name'] }}
                    @if(isset($panel['has_images']) && $panel['has_images'])
                        <span class="float-end">
                            <i class="bi bi-camera-fill"></i> {{ $panel['image_count'] }} image(s)
                        </span>
                    @endif
                </div>
                <div class="panel-preview-body">
                    @if(isset($panel['data']['condition']))
                        <div class="data-row">
                            <div class="data-label">Condition:</div>
                            <div class="data-value">
                                <span class="condition-badge condition-{{ strtolower($panel['data']['condition']) }}">
                                    {{ ucfirst($panel['data']['condition']) }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    @if(isset($panel['data']['comments']) && $panel['data']['comments'])
                        <div class="data-row">
                            <div class="data-label">Comments:</div>
                            <div class="data-value">{{ $panel['data']['comments'] }}</div>
                        </div>
                    @endif
                    
                    @if(isset($panel['data']['additional_comments']) && $panel['data']['additional_comments'])
                        <div class="data-row">
                            <div class="data-label">Additional Comments:</div>
                            <div class="data-value">{{ $panel['data']['additional_comments'] }}</div>
                        </div>
                    @endif
                    
                    @if(isset($panel['has_images']) && $panel['has_images'])
                        <div class="data-row">
                            <div class="data-label">Images:</div>
                            <div class="data-value">
                                <span class="image-indicator">
                                    <i class="bi bi-check-circle-fill"></i> {{ $panel['image_count'] }} image(s) captured
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="panel-preview-card">
            <div class="panel-preview-body">
                <div class="no-data">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">No Panel Data Found</h4>
                    <p>Please go back and fill out at least one panel assessment before previewing.</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Data Verification Notice -->
    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle"></i> Data Verification</h5>
        <p class="mb-2">This preview shows the raw data captured from your Body Panel Assessment form.</p>
        <ul class="mb-0">
            <li>✅ If you see your panel selections above, the data capture is working correctly</li>
            <li>✅ This is the exact data that will be saved to the database</li>
            <li>✅ The final report will display this data in a more polished format</li>
        </ul>
    </div>
</div>
@endsection