@extends('layouts.app')

@section('title', 'Inspection Report - ' . ($report->report_number ?? 'Report'))

@section('additional-css')
<!-- jQuery (required for lightbox) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    
    .report-header .meta {
        font-size: 0.95rem;
        opacity: 0.8;
        margin-top: 1rem;
    }
    
    .report-actions {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    
    .report-actions .btn {
        margin-left: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
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
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
    }
    
    .info-label {
        font-weight: bold;
        color: #495057;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-size: 1.1rem;
        color: #212529;
    }
    
    .assessment-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .assessment-table th {
        background: #4f959b;
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    .assessment-table td {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        vertical-align: top;
    }
    
    .assessment-table tr:nth-child(even) {
        background: #f8f9fa;
    }
    
    .assessment-table tr:hover {
        background: #e3f2fd;
        transition: background-color 0.2s;
    }
    
    .condition-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    
    .condition-good {
        background: #d4edda;
        color: #155724;
        border: 2px solid #c3e6cb;
    }
    
    .condition-average {
        background: #fff3cd;
        color: #856404;
        border: 2px solid #ffeaa7;
    }
    
    .condition-bad {
        background: #f8d7da;
        color: #721c24;
        border: 2px solid #f5c6cb;
    }
    
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .image-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .image-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    
    .image-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    
    .image-card img:hover {
        opacity: 0.9;
    }
    
    .image-caption {
        padding: 1rem;
        text-align: center;
        font-weight: 600;
        color: #495057;
        background: #f8f9fa;
        border-top: 3px solid #4f959b;
    }
    
    .summary-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid #4f959b;
        border-radius: 12px;
        padding: 2rem;
        margin-top: 2rem;
    }
    
    .summary-box h3 {
        color: #4f959b;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }
    
    .print-hide {
        display: block;
    }
    
    .empty-section {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
        font-style: italic;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
    }
    
    @media print {
        .print-hide {
            display: none !important;
        }
        
        .web-report {
            box-shadow: none;
            border-radius: 0;
        }
        
        .report-actions {
            display: none;
        }
        
        .section {
            page-break-inside: avoid;
        }
        
        .image-card {
            break-inside: avoid;
        }
    }
    
    @media (max-width: 768px) {
        .report-content {
            padding: 1rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .image-gallery {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .report-header {
            padding: 1.5rem 1rem;
        }
        
        .report-header h1 {
            font-size: 2rem;
        }
        
        .report-actions {
            position: static;
            text-align: center;
            margin-top: 1rem;
        }
        
        .assessment-table {
            font-size: 0.9rem;
        }
        
        .assessment-table th,
        .assessment-table td {
            padding: 0.75rem 0.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .image-gallery {
            grid-template-columns: 1fr;
        }
        
        .report-header h1 {
            font-size: 1.75rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="web-report">
        <!-- Report Header -->
        <div class="report-header">
            <div class="report-actions print-hide">
                <a href="{{ route('reports.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left"></i> Back to Reports
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
            
            <h1>ALPHA VEHICLE INSPECTION</h1>
            <div class="subtitle">Professional Vehicle Assessment Report</div>
            <div class="meta">
                <strong>Report #:</strong> {{ $report->report_number }}<br>
                <strong>Generated:</strong> {{ $report->created_at->format('F j, Y \a\t g:i A') }}
            </div>
        </div>

        <div class="report-content">
            <!-- Client & Vehicle Information -->
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-car-front"></i>
                    Vehicle Information
                </h2>
                
                <div class="info-grid">
                    <!-- Client fields completely removed - Visual Inspection form doesn't collect client info -->
                    <div class="info-card">
                        <div class="info-label">Inspection Date</div>
                        <div class="info-value">{{ $inspectionData['inspection']['date'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Vehicle Make</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['make'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Vehicle Model</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['model'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Year</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['year'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Mileage</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['mileage'] ?? 'Not specified' }} km</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">VIN Number</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['vin'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">License Plate</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['license_plate'] ?? 'Not specified' }}</div>
                    </div>
                    <!-- Additional Vehicle Fields -->
                    <div class="info-card">
                        <div class="info-label">Vehicle Type</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['vehicle_type'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Colour</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['colour'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Fuel Type</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['fuel_type'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Transmission</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['transmission'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Doors</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['doors'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Engine Number</div>
                        <div class="info-value">{{ $inspectionData['vehicle']['engine_number'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Inspector</div>
                        <div class="info-value">{{ $inspectionData['inspection']['inspector'] ?? 'Not specified' }}</div>
                    </div>
                </div>
            </div>

            <!-- Visual Inspection Images -->
            @if(!empty($inspectionData['images']['visual']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-camera"></i>
                    Visual Inspection Images
                </h2>
                
                <div class="image-gallery">
                    @foreach($inspectionData['images']['visual'] as $image)
                    <div class="image-card">
                        <a href="{{ $image['data_url'] }}" data-lightbox="visual-images" 
                           data-title="{{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Visual inspection')) }}">
                            <img src="{{ $image['data_url'] }}" 
                                 alt="{{ $image['area_name'] ?? 'Visual inspection image' }}"
                                 loading="lazy">
                        </a>
                        <div class="image-caption">
                            {{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Visual inspection')) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Diagnostic Report Section -->
            @if(!empty($inspectionData['inspection']['diagnostic_report']) || !empty($inspectionData['inspection']['diagnostic_file']['name']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Diagnostic Report
                </h2>
                
                @if(!empty($inspectionData['inspection']['diagnostic_report']))
                <div class="info-card mb-3">
                    <div class="info-label">Diagnostic Findings</div>
                    <div class="info-value" style="white-space: pre-wrap;">{{ $inspectionData['inspection']['diagnostic_report'] }}</div>
                </div>
                @endif
                
                @if(!empty($inspectionData['inspection']['diagnostic_file']['name']))
                <div class="info-card">
                    <div class="info-label">Attached PDF Report</div>
                    <div class="info-value">
                        <i class="bi bi-file-pdf text-danger"></i> {{ $inspectionData['inspection']['diagnostic_file']['name'] }}
                        <br>
                        <small class="text-muted">Size: {{ number_format($inspectionData['inspection']['diagnostic_file']['size'] / 1024, 2) }} KB</small>
                        <br>
                        @if(!empty($inspectionData['inspection']['diagnostic_file']['data']))
                        <a href="{{ $inspectionData['inspection']['diagnostic_file']['data'] }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-eye"></i> View PDF
                        </a>
                        <a href="{{ $inspectionData['inspection']['diagnostic_file']['data'] }}" 
                           download="{{ $inspectionData['inspection']['diagnostic_file']['name'] }}" 
                           class="btn btn-sm btn-outline-secondary mt-2 ms-2">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Body Panel Assessment -->
            @if(!empty($inspectionData['body_panels']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-car-front"></i>
                    Body Panel Assessment
                </h2>

                <!-- Vehicle Body Panels Visual Section -->
                <section id="vehicle-diagram" aria-label="Vehicle Body Panels" style="margin-bottom: 2rem;">
                    <div class="vehicle-diagram-container">
                        <!-- Base vehicle image -->
                        <div class="vehicle-base-wrapper">
                            <img src="{{ asset('images/panels/FullVehicle.png') }}" alt="Vehicle Base" class="layer-base" id="vehicleBase">
                            
                            <!-- Panel overlay images with condition styling -->
                            @foreach($inspectionData['body_panels'] as $panel)
                                @if($panel['condition'])
                                @php
                                    $panelId = str_replace('_', '-', $panel['panel_id']);
                                    $imageName = $panelId . '.png';
                                    // Handle special cases and CSV typos
                                    if ($panelId === 'rear-bumber') $imageName = 'rear-bumper.png';
                                    if ($panelId === 'lr-quarter-panel') $imageName = 'lr-quarter-panel.png';
                                    if ($panelId === 'rr-quarter-panel') $imageName = 'rr-quarter-panel.png';
                                    if (str_contains($panelId, 'rim') && !str_ends_with($imageName, '.png')) {
                                        $imageName = $panelId . '.png';
                                    }
                                @endphp
                                <img src="/images/panels/{{ $imageName }}" 
                                     class="panel-overlay panel-{{ $panelId }} condition-{{ strtolower($panel['condition']) }}" 
                                     data-panel="{{ $panel['panel_id'] }}"
                                     data-condition="{{ $panel['condition'] }}"
                                     onclick="scrollToPanelCard('{{ $panel['panel_id'] }}')"
                                     title="{{ $panel['panel_name'] }} - {{ ucfirst($panel['condition']) }}"
                                     alt="{{ $panel['panel_name'] }}">
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Legend -->
                        <div class="condition-legend">
                            <div class="legend-title">Condition Status</div>
                            <div class="legend-item">
                                <span class="legend-color good"></span>
                                <span class="legend-label">Good</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color average"></span>
                                <span class="legend-label">Average</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color bad"></span>
                                <span class="legend-label">Poor</span>
                            </div>
                        </div>
                    </div>
                </section>
                
                <style>
                    /* Vehicle Diagram Styles */
                    .vehicle-diagram-container {
                        position: relative;
                        max-width: 1005px;
                        width: 100%;
                        margin: 0 auto;
                        background: #f8f9fa;
                        border-radius: 8px;
                        padding: 2rem;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                        overflow: visible;
                    }
                    
                    .vehicle-base-wrapper {
                        position: relative;
                        max-width: 1005px;
                        width: 100%;
                        margin: 0 auto;
                        background-color: #f8f9fa;
                        padding: 0;
                        overflow: visible;
                    }
                    
                    .layer-base {
                        width: 100%;
                        height: auto;
                        display: block;
                        max-width: 1005px;
                    }
                    
                    /* Panel overlay positioning - matches body-panel-assessment.blade.php */
                    .panel-overlay {
                        cursor: pointer;
                        transition: all 0.3s ease;
                        opacity: 0.7;
                        position: absolute !important;
                        border-radius: 3px;
                        z-index: 2;
                    }
                    
                    .panel-overlay:hover {
                        opacity: 0.9;
                    }
                    
                    /* Panel positions using exact coordinates from panelimages2.csv (converted to percentages) */
                    /* Base image dimensions: 1005px width × 1353px height */
                    
                    .panel-bonnet { top: 24.32%; left: 68.06%; width: 26.97%; height: 24.83%; }
                    .panel-boot { top: 26.83%; left: 7.26%; width: 14.03%; height: 19.73%; }
                    .panel-fr-door { top: 2.22%; left: 44.08%; width: 22.89%; height: 15.67%; }
                    .panel-fr-fender { top: 6.21%; left: 61.89%; width: 31.84%; height: 16.26%; }
                    .panel-fr-headlight { top: 85.37%; left: 6.97%; width: 9.05%; height: 2.51%; }
                    .panel-fr-mirror { top: 80.93%; left: 3.98%; width: 4.78%; height: 2.36%; }
                    .panel-front-bumper { top: 87.21%; left: 4.18%; width: 37.21%; height: 6.28%; }
                    .panel-lf-door { top: 52.85%; left: 32.64%; width: 22.99%; height: 15.67%; }
                    .panel-lf-fender { top: 56.91%; left: 5.87%; width: 31.84%; height: 16.26%; }
                    .panel-lf-headlight { top: 85.37%; left: 29.35%; width: 9.15%; height: 2.51%; }
                    .panel-lf-mirror { top: 80.93%; left: 36.62%; width: 4.78%; height: 2.36%; }
                    .panel-lr-door { top: 52.62%; left: 52.34%; width: 20.60%; height: 16.56%; }
                    .panel-lr-quarter-panel { top: 58.24%; left: 67.06%; width: 26.97%; height: 10.35%; }
                    .panel-lr-taillight { top: 82.89%; left: 61.89%; width: 9.15%; height: 3.84%; }
                    .panel-rear-bumper { top: 87.36%; left: 59.20%; width: 33.83%; height: 5.03%; }
                    .panel-rear-bumber { top: 87.36%; left: 59.20%; width: 33.83%; height: 5.03%; } /* Handle CSV typo */
                    .panel-rear-window { top: 27.20%; left: 15.82%; width: 15.62%; height: 18.48%; }
                    .panel-roof { top: 28.09%; left: 29.75%; width: 28.16%; height: 16.34%; }
                    .panel-rr-door { top: 2.07%; left: 26.47%; width: 20.80%; height: 16.56%; }
                    .panel-rr-quarter-panel { top: 7.54%; left: 5.57%; width: 26.97%; height: 10.42%; }
                    .panel-rr-taillight { top: 82.89%; left: 81.59%; width: 9.15%; height: 3.84%; }
                    .panel-windscreen { top: 25.87%; left: 57.31%; width: 14.63%; height: 20.62%; }
                    .panel-rr-rim { top: 13.38%; left: 19.30%; width: 10.45%; height: 7.32%; border-radius: 50%; }
                    .panel-rf-rim { top: 13.38%; left: 70.95%; width: 10.45%; height: 7.32%; border-radius: 50%; }
                    .panel-lf-rim { top: 64.01%; left: 18.11%; width: 10.45%; height: 7.32%; border-radius: 50%; }
                    .panel-lr-rim { top: 64.01%; left: 69.75%; width: 10.45%; height: 7.32%; border-radius: 50%; }
                    
                    /* Condition colors using CSS filters for images */
                    .panel-overlay.condition-good {
                        filter: brightness(0) saturate(100%) invert(58%) sepia(95%) saturate(1352%) hue-rotate(87deg) brightness(119%) contrast(119%); /* Green filter */
                    }
                    
                    .panel-overlay.condition-average {
                        filter: brightness(0) saturate(100%) invert(82%) sepia(78%) saturate(1919%) hue-rotate(3deg) brightness(103%) contrast(101%); /* Amber/Orange filter */
                    }
                    
                    .panel-overlay.condition-bad {
                        filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%); /* Red filter */
                    }
                    
                    /* Legend Styles */
                    .condition-legend {
                        position: absolute;
                        bottom: 1rem;
                        right: 1rem;
                        background: rgba(255, 255, 255, 0.95);
                        padding: 1rem;
                        border-radius: 6px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                        min-width: 120px;
                    }
                    
                    .legend-title {
                        font-weight: bold;
                        font-size: 0.9rem;
                        margin-bottom: 0.5rem;
                        color: #495057;
                    }
                    
                    .legend-item {
                        display: flex;
                        align-items: center;
                        margin-bottom: 0.25rem;
                        font-size: 0.85rem;
                    }
                    
                    .legend-color {
                        width: 16px;
                        height: 16px;
                        border-radius: 3px;
                        margin-right: 0.5rem;
                        border: 1px solid rgba(0,0,0,0.1);
                    }
                    
                    .legend-color.good {
                        background-color: #28a745;
                    }
                    
                    .legend-color.average {
                        background-color: #ffc107;
                    }
                    
                    .legend-color.bad {
                        background-color: #dc3545;
                    }
                    
                    .legend-label {
                        color: #495057;
                    }
                    
                    /* Responsive adjustments */
                    @media (max-width: 768px) {
                        .vehicle-diagram-container {
                            padding: 1rem;
                        }
                        
                        .condition-legend {
                            position: static;
                            margin-top: 1rem;
                            width: fit-content;
                        }
                    }

                    .panel-card {
                        border: 1px solid #dee2e6;
                        border-radius: 8px;
                        margin-bottom: 1.5rem;
                        overflow: hidden;
                    }
                    .panel-header {
                        background: #f8f9fa;
                        padding: 1rem;
                        border-bottom: 1px solid #dee2e6;
                    }
                    .panel-row {
                        display: flex;
                        align-items: center;
                        gap: 2rem;
                        flex-wrap: wrap;
                    }
                    .panel-name {
                        font-weight: bold;
                        font-size: 1.1rem;
                        color: #495057;
                        min-width: 200px;
                    }
                    .panel-condition {
                        min-width: 120px;
                    }
                    .panel-condition select {
                        padding: 0.25rem 0.5rem;
                        border: 1px solid #ced4da;
                        border-radius: 4px;
                        background-color: white;
                        font-size: 0.9rem;
                    }
                    .panel-comment {
                        flex: 1;
                        min-width: 200px;
                    }
                    .panel-comment-label {
                        font-weight: 600;
                        color: #6c757d;
                        margin-right: 0.5rem;
                    }
                    .panel-images {
                        padding: 1rem;
                        background: white;
                    }
                    .images-row {
                        display: flex;
                        gap: 1rem;
                        overflow-x: auto;
                        padding: 0.5rem 0;
                    }
                    .image-thumbnail {
                        position: relative;
                        min-width: 120px;
                        height: 120px;
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        overflow: hidden;
                    }
                    .image-thumbnail img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        cursor: pointer;
                    }
                    .image-delete {
                        position: absolute;
                        top: 5px;
                        right: 5px;
                        background: rgba(220, 53, 69, 0.9);
                        color: white;
                        border: none;
                        border-radius: 50%;
                        width: 24px;
                        height: 24px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        font-size: 16px;
                        line-height: 1;
                    }
                    .condition-Good, .condition-good {
                        background-color: #d4edda;
                        color: #155724;
                        padding: 0.25rem 0.75rem;
                        border-radius: 4px;
                        display: inline-block;
                    }
                    .condition-Average, .condition-average {
                        background-color: #fff3cd;
                        color: #856404;
                        padding: 0.25rem 0.75rem;
                        border-radius: 4px;
                        display: inline-block;
                    }
                    .condition-Bad, .condition-bad {
                        background-color: #f8d7da;
                        color: #721c24;
                        padding: 0.25rem 0.75rem;
                        border-radius: 4px;
                        display: inline-block;
                    }
                </style>
                
                @foreach($inspectionData['body_panels'] as $panel)
                <div class="panel-card" data-panel-card="{{ $panel['panel_id'] }}">
                    <!-- First Row: Panel Heading, Condition, Comments -->
                    <div class="panel-header">
                        <div class="panel-row">
                            <div class="panel-name">{{ $panel['panel_name'] }}</div>
                            
                            <div class="panel-condition">
                                @if($panel['condition'])
                                <span class="condition-{{ $panel['condition'] }}">
                                    {{ ucfirst($panel['condition']) }}
                                </span>
                                @else
                                <span class="text-muted">No condition set</span>
                                @endif
                            </div>
                            
                            @if($panel['comment_type'] || $panel['additional_comment'])
                            <div class="panel-comment">
                                @if($panel['comment_type'])
                                <span class="panel-comment-label">COMMENTS:</span>
                                <span>{{ $panel['comment_type'] }}</span>
                                @endif
                                
                                @if($panel['additional_comment'])
                                <br>
                                <span class="panel-comment-label">ADDITIONAL COMMENTS:</span>
                                <span>{{ $panel['additional_comment'] }}</span>
                                @endif
                                
                                @if($panel['other_notes'])
                                <br>
                                <span class="panel-comment-label">OTHER NOTES:</span>
                                <span>{{ $panel['other_notes'] }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Second Row: Images -->
                    @if(!empty($panel['images']))
                    <div class="panel-images">
                        <div class="images-row">
                            @foreach($panel['images'] as $image)
                            <div class="image-thumbnail">
                                <a href="{{ $image['url'] }}" data-lightbox="panel-{{ $panel['panel_id'] }}" 
                                   data-title="{{ $panel['panel_name'] }}">
                                    <img src="{{ $image['thumbnail'] }}" alt="{{ $panel['panel_name'] }} image">
                                </a>
                                <span class="image-delete" title="Image from inspection">×</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
                
                @if(empty($inspectionData['body_panels']))
                <div class="alert alert-info">
                    No body panel assessments recorded for this inspection.
                </div>
                @endif
            </div>
            @endif

            <!-- Specific Area Images -->
            @if(!empty($inspectionData['images']['specific_areas']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-zoom-in"></i>
                    Specific Area Images
                </h2>
                
                <div class="image-gallery">
                    @foreach($inspectionData['images']['specific_areas'] as $image)
                    <div class="image-card">
                        <a href="{{ $image['data_url'] }}" data-lightbox="specific-images" 
                           data-title="{{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Specific area')) }}">
                            <img src="{{ $image['data_url'] }}" 
                                 alt="{{ $image['area_name'] ?? 'Specific area image' }}"
                                 loading="lazy">
                        </a>
                        <div class="image-caption">
                            {{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Specific area')) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Interior Assessment -->
            @if(!empty($inspectionData['interior']['assessments']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-house-door"></i>
                    Interior Assessment
                </h2>
                
                <div class="table-responsive">
                    <table class="assessment-table">
                        <thead>
                            <tr>
                                <th>Component</th>
                                <th>Colour</th>
                                <th>Condition</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspectionData['interior']['assessments'] as $component => $assessment)
                            <tr>
                                <td><strong>{{ ucwords(str_replace('-', ' ', $component)) }}</strong></td>
                                <td>{{ ucfirst($assessment['colour'] ?? '-') }}</td>
                                <td>
                                    <span class="condition-badge condition-{{ $assessment['condition'] ?? 'good' }}">
                                        {{ ucfirst($assessment['condition'] ?? 'Good') }}
                                    </span>
                                </td>
                                <td>{{ $assessment['comment'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Interior Images -->
            @if(!empty($inspectionData['images']['interior']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-house"></i>
                    Interior Images
                </h2>
                
                <div class="image-gallery">
                    @foreach($inspectionData['images']['interior'] as $image)
                    <div class="image-card">
                        <a href="{{ $image['data_url'] }}" data-lightbox="interior-images" 
                           data-title="{{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Interior')) }}">
                            <img src="{{ $image['data_url'] }}" 
                                 alt="{{ $image['area_name'] ?? 'Interior image' }}"
                                 loading="lazy">
                        </a>
                        <div class="image-caption">
                            {{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Interior')) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Tyres & Rims Assessment -->
            @if(!empty($inspectionData['tyres']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-circle"></i>
                    Tyres & Rims Assessment
                </h2>
                
                <h3 style="color: #4f959b; margin-bottom: 1rem;">Tyres</h3>
                <div class="table-responsive">
                    <table class="assessment-table">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Tread Depth</th>
                                <th>Condition</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['lf' => 'Left Front', 'rf' => 'Right Front', 'lr' => 'Left Rear', 'rr' => 'Right Rear'] as $pos => $label)
                                @if(!empty($inspectionData['tyres'][$pos]))
                                <tr>
                                    <td><strong>{{ $label }}</strong></td>
                                    <td>{{ $inspectionData['tyres'][$pos]['brand'] ?? '-' }}</td>
                                    <td>{{ $inspectionData['tyres'][$pos]['size'] ?? '-' }}</td>
                                    <td>{{ $inspectionData['tyres'][$pos]['tread_depth'] ?? '-' }}mm</td>
                                    <td>
                                        <span class="condition-badge condition-{{ $inspectionData['tyres'][$pos]['condition'] ?? 'good' }}">
                                            {{ ucfirst($inspectionData['tyres'][$pos]['condition'] ?? 'Good') }}
                                        </span>
                                    </td>
                                    <td>{{ $inspectionData['tyres'][$pos]['notes'] ?? '-' }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(!empty($inspectionData['tyres']['spare']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Spare Tyre</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ $inspectionData['tyres']['spare']['type'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ $inspectionData['tyres']['spare']['condition'] ?? 'good' }}">
                                {{ ucfirst($inspectionData['tyres']['spare']['condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Notes</div>
                        <div class="info-value">{{ $inspectionData['tyres']['spare']['notes'] ?? '-' }}</div>
                    </div>
                </div>
                @endif

                @if(!empty($inspectionData['rims']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Rims</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ $inspectionData['rims']['type'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ $inspectionData['rims']['condition'] ?? 'good' }}">
                                {{ ucfirst($inspectionData['rims']['condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Notes</div>
                        <div class="info-value">{{ $inspectionData['rims']['notes'] ?? '-' }}</div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Mechanical Report -->
            @if(!empty($inspectionData['mechanical']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-gear"></i>
                    Mechanical Report
                </h2>
                
                <h3 style="color: #4f959b; margin-bottom: 1rem;">Engine Performance</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Engine Startup</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['engine_startup'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Idling Quality</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['idling_quality'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Acceleration</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['acceleration'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Engine Noises</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['engine_noises'] ?? '-' }}</div>
                    </div>
                </div>

                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Fluid Levels</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Oil Level</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['oil_level'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Coolant Level</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['coolant_level'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Brake Fluid</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['brake_fluid'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Power Steering</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['power_steering_fluid'] ?? '-' }}</div>
                    </div>
                </div>

                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Brakes</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Performance</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['brake_performance'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Pad Thickness (Front)</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['brake_pad_thickness_front'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Pad Thickness (Rear)</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['brake_pad_thickness_rear'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Transmission</div>
                        <div class="info-value">{{ $inspectionData['mechanical']['transmission_type'] ?? '-' }}</div>
                    </div>
                </div>

                @if(!empty($inspectionData['mechanical']['notes']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Additional Notes</h3>
                <div class="info-card">
                    <div class="info-value">{{ $inspectionData['mechanical']['notes'] }}</div>
                </div>
                @endif
            </div>
            @endif

            <!-- Engine Compartment Assessment -->
            @if(!empty($inspectionData['engine_compartment']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-cpu"></i>
                    Engine Compartment Assessment
                </h2>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Overall Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['engine_compartment']['overall_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['engine_compartment']['overall_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Oil Leaks</div>
                        <div class="info-value">{{ ucfirst($inspectionData['engine_compartment']['oil_leaks'] ?? 'None') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Coolant Leaks</div>
                        <div class="info-value">{{ ucfirst($inspectionData['engine_compartment']['coolant_leaks'] ?? 'None') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Belt Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['engine_compartment']['belt_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['engine_compartment']['belt_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Battery Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['engine_compartment']['battery_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['engine_compartment']['battery_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Battery Age</div>
                        <div class="info-value">{{ $inspectionData['engine_compartment']['battery_age'] ?? '-' }}</div>
                    </div>
                </div>
                
                @if(!empty($inspectionData['engine_compartment']['notes']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Engine Compartment Notes</h3>
                <div class="info-card">
                    <div class="info-value">{{ $inspectionData['engine_compartment']['notes'] }}</div>
                </div>
                @endif
            </div>
            @endif

            <!-- Physical Hoist Inspection -->
            @if(!empty($inspectionData['physical_hoist']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-wrench"></i>
                    Physical Hoist Inspection (Undercarriage)
                </h2>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Undercarriage Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['physical_hoist']['undercarriage_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['physical_hoist']['undercarriage_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Rust Present</div>
                        <div class="info-value">{{ ucfirst($inspectionData['physical_hoist']['rust_present'] ?? 'No') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Exhaust Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['physical_hoist']['exhaust_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['physical_hoist']['exhaust_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Suspension Condition</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['physical_hoist']['suspension_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['physical_hoist']['suspension_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Brake Lines</div>
                        <div class="info-value">
                            <span class="condition-badge condition-{{ strtolower($inspectionData['physical_hoist']['brake_lines'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['physical_hoist']['brake_lines'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if(!empty($inspectionData['physical_hoist']['notes']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Hoist Inspection Notes</h3>
                <div class="info-card">
                    <div class="info-value">{{ $inspectionData['physical_hoist']['notes'] }}</div>
                </div>
                @endif
            </div>
            @endif

            <!-- Service History -->
            @if(!empty($inspectionData['service']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-tools"></i>
                    Service History
                </h2>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Service History Available</div>
                        <div class="info-value">{{ ucfirst($inspectionData['service']['has_history'] ?? 'No') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Last Service Date</div>
                        <div class="info-value">{{ $inspectionData['service']['last_service_date'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Last Service Mileage</div>
                        <div class="info-value">{{ $inspectionData['service']['last_service_mileage'] ?? '-' }} km</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Service Provider</div>
                        <div class="info-value">{{ $inspectionData['service']['service_provider'] ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Next Service Due</div>
                        <div class="info-value">{{ $inspectionData['service']['next_service_due'] ?? '-' }}</div>
                    </div>
                </div>
                
                @if(!empty($inspectionData['service']['notes']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Service Notes</h3>
                <div class="info-card">
                    <div class="info-value">{{ $inspectionData['service']['notes'] }}</div>
                </div>
                @endif
            </div>
            @endif

            <!-- Summary & Recommendations -->
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-clipboard-check"></i>
                    Inspection Summary
                </h2>
                
                <div class="summary-box">
                    <h3>Overall Assessment</h3>
                    <p>This vehicle inspection has been completed according to professional standards. All accessible components have been assessed for condition, safety, and functionality.</p>
                    
                    @if(!empty($inspectionData['inspection']['notes']))
                    <h3>Inspector Notes</h3>
                    <p>{{ $inspectionData['inspection']['notes'] }}</p>
                    @endif
                    
                    <h3>Report Validity</h3>
                    <p>This report is confidential and intended solely for the use of the client named above. The inspection was conducted on {{ $inspectionData['inspection']['date'] ?? 'the specified date' }} and reflects the vehicle's condition at that time.</p>
                    
                    <div class="text-center mt-4">
                        <p><strong>&copy; {{ date('Y') }} ALPHA Vehicle Inspection. All rights reserved.</strong></p>
                        <p class="text-muted">Report generated on {{ $inspectionData['generated_at'] ?? date('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" onerror="console.log('Lightbox CDN failed, using fallback')"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configure lightbox if available
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2',
            'fadeDuration': 300,
            'imageFadeDuration': 300
        });
    } else {
        // Fallback: create our own simple modal
        createSimpleModal();
        
        document.querySelectorAll('[data-lightbox]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showImageModal(this.href, this.getAttribute('data-title'));
            });
        });
    }
    
    function createSimpleModal() {
        if (document.getElementById('simple-modal')) return;
        
        const modal = document.createElement('div');
        modal.id = 'simple-modal';
        modal.innerHTML = `
            <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; display: none; align-items: center; justify-content: center;">
                <div class="modal-content" style="position: relative; max-width: 90%; max-height: 90%;">
                    <span class="modal-close" style="position: absolute; top: 10px; right: 20px; color: white; font-size: 30px; cursor: pointer; z-index: 10000;">&times;</span>
                    <img class="modal-image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    <div class="modal-title" style="color: white; text-align: center; padding: 10px; font-size: 16px;"></div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Close modal when clicking overlay or close button
        const overlay = modal.querySelector('.modal-overlay');
        const closeBtn = modal.querySelector('.modal-close');
        
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        
        closeBtn.addEventListener('click', function() {
            overlay.style.display = 'none';
        });
        
        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                overlay.style.display = 'none';
            }
        });
    }
    
    function showImageModal(src, title) {
        const modal = document.getElementById('simple-modal');
        const overlay = modal.querySelector('.modal-overlay');
        const img = modal.querySelector('.modal-image');
        const titleDiv = modal.querySelector('.modal-title');
        
        img.src = src;
        titleDiv.textContent = title || 'Inspection Image';
        overlay.style.display = 'flex';
    }
    
    // Function to show PDF in modal
    function showPdfInModal(pdfData, fileName) {
        // Create a new modal for PDF
        const pdfModal = document.createElement('div');
        pdfModal.innerHTML = `
            <div class="pdf-modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10000; display: flex; align-items: center; justify-content: center;">
                <div class="pdf-modal-content" style="position: relative; width: 90%; height: 90%; background: white; border-radius: 8px; padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <h5 style="margin: 0;">${fileName}</h5>
                        <button class="pdf-close-btn" style="background: #dc3545; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;">Close</button>
                    </div>
                    <iframe src="${pdfData}" style="width: 100%; height: calc(100% - 50px); border: none; border-radius: 4px;"></iframe>
                </div>
            </div>
        `;
        document.body.appendChild(pdfModal);
        
        // Close modal handler
        pdfModal.querySelector('.pdf-close-btn').addEventListener('click', function() {
            pdfModal.remove();
        });
        
        // Close on overlay click
        pdfModal.querySelector('.pdf-modal-overlay').addEventListener('click', function(e) {
            if (e.target === this) {
                pdfModal.remove();
            }
        });
        
        // Close on Escape key
        const escHandler = function(e) {
            if (e.key === 'Escape') {
                pdfModal.remove();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }
    
    // Add loading states for images
    const images = document.querySelectorAll('.image-card img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.style.opacity = '0.5';
            this.closest('.image-card').style.border = '2px solid #dc3545';
            const caption = this.closest('.image-card').querySelector('.image-caption');
            if (caption) {
                caption.innerHTML += ' <span style="color: #dc3545;">(Failed to load)</span>';
            }
        });
    });
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Function to scroll to panel card when clicking overlay
function scrollToPanelCard(panelId) {
    // Clean panel ID to match card data attributes
    const cleanPanelId = panelId.replace('body_panel_', '').replace('_', '-');
    
    // Find the matching panel card
    const panelCard = document.querySelector(`[data-panel-card="${cleanPanelId}"]`) || 
                     document.querySelector(`[data-panel-card="${panelId}"]`) ||
                     document.querySelector(`[data-panel-card="body_panel_${cleanPanelId}"]`);
    
    if (panelCard) {
        // Highlight the panel card temporarily
        panelCard.style.transition = 'all 0.3s ease';
        panelCard.style.backgroundColor = '#fff3cd';
        panelCard.style.border = '2px solid #ffc107';
        
        // Scroll to the panel card
        panelCard.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        
        // Remove highlight after 2 seconds
        setTimeout(() => {
            panelCard.style.backgroundColor = '';
            panelCard.style.border = '';
        }, 2000);
    } else {
        console.log('Panel card not found for ID:', panelId, 'Cleaned ID:', cleanPanelId);
        // Fallback: scroll to the body panel section
        const bodyPanelSection = document.querySelector('#vehicle-diagram').closest('.section');
        if (bodyPanelSection) {
            bodyPanelSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
}
</script>
@endsection