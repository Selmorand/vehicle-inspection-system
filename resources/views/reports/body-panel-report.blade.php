@extends('layouts.app')

@section('title', 'Body Panel Assessment Report - ' . ($report->report_number ?? 'Report'))

@section('additional-css')
<!-- Use local fallback for lightbox CSS if CDN fails -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" onerror="this.remove()">
<style>
    .web-report {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .report-header {
        background: linear-gradient(135deg, #4f959b 0%, #3d7a7f 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }
    
    .report-header h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .report-header .subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin: 0.5rem 0;
    }
    
    .report-content {
        padding: 2rem;
    }
    
    .section {
        margin-bottom: 3rem;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 2rem;
    }
    
    .section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .section-title {
        color: #4f959b;
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        border-bottom: 3px solid #4f959b;
        padding-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.75rem;
        font-size: 1.5rem;
    }

    .info-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
    }

    .info-card h5 {
        color: #4f959b;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .info-card p {
        margin-bottom: 0.5rem;
    }

    /* Body Panel Card Layout - Based on screenshot 12.png */
    .panel-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .panel-card-title {
        background: #4f959b;
        color: white;
        padding: 1rem 1.5rem;
        font-size: 1.2rem;
        font-weight: bold;
        margin: 0;
    }
    
    .panel-card-content {
        padding: 1.5rem;
    }
    
    .panel-details {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        margin-bottom: 1rem;
        align-items: center;
    }
    
    .panel-detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .panel-detail-label {
        font-weight: bold;
        color: #495057;
    }
    
    .condition-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-weight: bold;
        font-size: 0.9rem;
        color: white;
        text-transform: capitalize;
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
    
    .panel-images {
        margin-top: 1rem;
    }
    
    .panel-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .panel-image {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .panel-image:hover {
        transform: scale(1.05);
    }
    
    .panel-image img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    
    .panel-image .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc3545;
        font-size: 12px;
        cursor: pointer;
    }

    /* Vehicle Diagram Section */
    .vehicle-diagram-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .body-panel-container {
        position: relative;
        max-width: 1005px;
        width: 100%;
        margin: 0 auto;
        background-color: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .base-body-panel {
        width: 100%;
        height: auto;
        display: block;
        max-width: 1005px;
    }
    
    .panel-overlay {
        position: absolute !important;
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .panel-overlay.condition-good {
        filter: brightness(0) saturate(100%) invert(24%) sepia(56%) saturate(1347%) hue-rotate(88deg) brightness(88%) contrast(94%);
    }
    
    .panel-overlay.condition-average {
        filter: brightness(0) saturate(100%) invert(76%) sepia(48%) saturate(1678%) hue-rotate(11deg) brightness(96%) contrast(91%);
    }
    
    .panel-overlay.condition-bad {
        filter: brightness(0) saturate(100%) invert(16%) sepia(99%) saturate(7404%) hue-rotate(3deg) brightness(90%) contrast(114%);
    }

    @media (max-width: 768px) {
        .panel-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .panel-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="web-report">
        <!-- Report Header -->
        <div class="report-header">
            <h1>ALPHA Vehicle Inspection</h1>
            <div class="subtitle">Body Panel Assessment Report</div>
            <div class="meta">
                Report #{{ $report->report_number }} | Generated on {{ $report->inspection_date }}
            </div>
        </div>
        
        <div class="report-content">
            
            <!-- Test Report Notice -->
            <div class="section">
                <div class="alert alert-info">
                    <h4><i class="bi bi-info-circle"></i> Body Panel Assessment Test Report</h4>
                    <p>This is a test report showing how the Body Panel Assessment data will be displayed in the final inspection report.</p>
                    @if(isset($inspectionData['data_source']))
                        <p><strong>Data Source:</strong> {{ $inspectionData['data_source'] }}</p>
                    @endif
                </div>
            </div>

            <!-- Vehicle Panel Diagram -->
            @if(isset($inspectionData['panelDiagram']) && !empty($inspectionData['panelDiagram']['panels']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-diagram-3"></i>
                    Vehicle Panel Overview
                </h2>
                <div class="vehicle-diagram-section">
                    <div class="body-panel-container">
                        <img src="/images/panels/FullVehicle.png" alt="Vehicle Base" class="base-body-panel">
                        
                        @foreach($inspectionData['panelDiagram']['panels'] as $panel)
                            @if(isset($inspectionData['inspection']['body_panels']))
                                @php
                                    $panelCondition = '';
                                    foreach($inspectionData['inspection']['body_panels'] as $bodyPanel) {
                                        if(strtolower(str_replace(' ', '_', $bodyPanel['name'])) === strtolower(str_replace('-', '_', $panel['id']))) {
                                            $panelCondition = strtolower($bodyPanel['condition']);
                                            break;
                                        }
                                    }
                                @endphp
                                @if($panelCondition)
                                    <img src="{{ $inspectionData['panelDiagram']['basePath'] }}{{ $panel['image_file'] }}" 
                                         alt="{{ $panel['name'] }}" 
                                         class="panel-overlay condition-{{ $panelCondition }}"
                                         style="left: {{ (($panel['x'] ?? 0) / 1005) * 100 }}%; top: {{ (($panel['y'] ?? 0) / 1353) * 100 }}%; width: {{ (($panel['w'] ?? 0) / 1005) * 100 }}%; height: {{ (($panel['h'] ?? 0) / 1353) * 100 }}%;"
                                         title="{{ $panel['name'] }} - {{ ucfirst($panelCondition) }}">
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <span class="condition-badge condition-good me-2">Good</span>
                            <span class="condition-badge condition-average me-2">Average</span>
                            <span class="condition-badge condition-bad me-2">Bad</span>
                            Panel colors indicate assessment condition
                        </small>
                    </div>
                </div>
            </div>
            @endif

            <!-- Body Panel Assessments -->
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-card-checklist"></i>
                    Body Panel Assessments
                </h2>
                
                @if(isset($inspectionData['inspection']['body_panels']) && !empty($inspectionData['inspection']['body_panels']))
                    @foreach($inspectionData['inspection']['body_panels'] as $panel)
                    <div class="panel-card">
                        <h3 class="panel-card-title">{{ $panel['name'] }}</h3>
                        <div class="panel-card-content">
                            <!-- Panel Details Row -->
                            <div class="panel-details">
                                <div class="panel-detail-item">
                                    <span class="panel-detail-label">Condition:</span>
                                    <span class="condition-badge condition-{{ strtolower($panel['condition']) }}">
                                        {{ $panel['condition'] }}
                                    </span>
                                </div>
                                
                                <div class="panel-detail-item">
                                    <span class="panel-detail-label">Comments:</span>
                                    <span>{{ $panel['comments'] ?: 'No comments' }}</span>
                                </div>
                                
                                <div class="panel-detail-item">
                                    <span class="panel-detail-label">Additional Comments:</span>
                                    <span>{{ $panel['additional_comments'] ?: 'None' }}</span>
                                </div>
                            </div>
                            
                            <!-- Images Row -->
                            @if(!empty($panel['images']))
                            <div class="panel-images">
                                <strong>Images:</strong>
                                <div class="panel-images-grid">
                                    @foreach($panel['images'] as $image)
                                    <div class="panel-image">
                                        <a href="{{ $image['data'] ?? $image['src'] }}" data-lightbox="panel-{{ $loop->parent->index }}" data-title="{{ $panel['name'] }} Image">
                                            <img src="{{ $image['data'] ?? $image['src'] }}" alt="Panel Image">
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="panel-images">
                                <span class="text-muted">No images captured for this panel</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">
                        <h4><i class="bi bi-exclamation-triangle"></i> No Panel Assessments Found</h4>
                        <p>No body panel assessment data was submitted. Please:</p>
                        <ul>
                            <li>Go back to the <a href="/inspection/body-panel" target="_blank">Body Panel Assessment page</a></li>
                            <li>Fill out assessments for the panels you want to include</li>
                            <li>Continue through the inspection process to generate the final report</li>
                        </ul>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('additional-js')
<!-- Use local fallback for lightbox JS if CDN fails -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" onerror="console.log('Lightbox CDN failed, using inline modal fallback')"></script>

<script>
// Fallback modal functionality if lightbox fails
if (typeof lightbox === 'undefined') {
    document.addEventListener('DOMContentLoaded', function() {
        // Create simple modal for image viewing
        const modalHtml = `
            <div class="modal fade" id="imageModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Image View</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" class="img-fluid" style="max-height: 70vh;">
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Handle image clicks
        document.querySelectorAll('.panel-image a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const imgSrc = this.getAttribute('href');
                document.getElementById('modalImage').src = imgSrc;
                new bootstrap.Modal(document.getElementById('imageModal')).show();
            });
        });
    });
}
</script>
@endsection