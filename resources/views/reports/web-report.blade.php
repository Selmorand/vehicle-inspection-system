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
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.875rem;
        display: inline-block;
    }
    
    /* Legacy condition classes - now use standardized colors */
    .condition-good {
        background-color: #277020;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        display: inline-block;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .condition-average {
        background-color: #f5a409;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        display: inline-block;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .condition-bad {
        background-color: #c62121;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        display: inline-block;
        font-weight: 500;
        font-size: 0.875rem;
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
    
    /* Panel card styling for assessments */
    .panel-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .panel-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 15px 20px;
    }
    
    .panel-name {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }
    
    .panel-details {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .panel-images {
        border-top: 1px solid #e0e0e0;
        padding: 15px 20px;
        background: #fafafa;
    }
    
    .images-label {
        font-weight: 500;
        margin-bottom: 10px;
        color: #495057;
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
    
    /* Medium screens - adjust button sizes */
    @media (max-width: 991px) {
        .report-actions .btn {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
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
                            
                            <!-- All panel overlay images with positioning like input page -->
                            @php
                                // Define all panels with their CSV coordinates (same as input page)
                                $allPanels = [
                                    ['id' => 'fr-fender', 'name' => 'Right Front Fender', 'style' => 'left: 61.89%; top: 6.21%; width: 31.84%; height: 16.26%; z-index: 1;'],
                                    ['id' => 'fr-door', 'name' => 'Right Front Door', 'style' => 'left: 44.08%; top: 2.22%; width: 22.89%; height: 15.67%; z-index: 1;'],
                                    ['id' => 'rf-rim', 'name' => 'Right Front Rim', 'style' => 'left: 70.95%; top: 13.38%; width: 10.45%; height: 7.32%; z-index: 2;'],
                                    ['id' => 'rr-door', 'name' => 'Right Rear Door', 'style' => 'left: 26.47%; top: 2.07%; width: 20.80%; height: 16.56%; z-index: 1;'],
                                    ['id' => 'rr-rim', 'name' => 'Right Rear Rim', 'style' => 'left: 19.30%; top: 13.38%; width: 10.45%; height: 7.32%; z-index: 2;'],
                                    ['id' => 'rr-quarter-panel', 'name' => 'Right Rear Quarter Panel', 'style' => 'left: 5.57%; top: 7.54%; width: 26.97%; height: 10.42%; z-index: 1;'],
                                    ['id' => 'bonnet', 'name' => 'Bonnet', 'style' => 'left: 68.06%; top: 24.32%; width: 26.97%; height: 24.83%; z-index: 1;'],
                                    ['id' => 'windscreen', 'name' => 'Windscreen', 'style' => 'left: 57.31%; top: 25.87%; width: 14.63%; height: 20.62%; z-index: 1;'],
                                    ['id' => 'roof', 'name' => 'Roof', 'style' => 'left: 29.75%; top: 28.09%; width: 28.16%; height: 16.34%; z-index: 1;'],
                                    ['id' => 'rear-window', 'name' => 'Rear Window', 'style' => 'left: 15.82%; top: 27.20%; width: 15.62%; height: 18.48%; z-index: 1;'],
                                    ['id' => 'boot', 'name' => 'Boot', 'style' => 'left: 7.26%; top: 26.83%; width: 14.03%; height: 19.73%; z-index: 1;'],
                                    ['id' => 'lf-fender', 'name' => 'Left Front Fender', 'style' => 'left: 5.87%; top: 56.91%; width: 31.84%; height: 16.26%; z-index: 1;'],
                                    ['id' => 'lf-door', 'name' => 'Left Front Door', 'style' => 'left: 32.64%; top: 52.85%; width: 22.99%; height: 15.67%; z-index: 1;'],
                                    ['id' => 'lf-rim', 'name' => 'Left Front Rim', 'style' => 'left: 18.11%; top: 64.01%; width: 10.45%; height: 7.32%; z-index: 2;'],
                                    ['id' => 'lr-door', 'name' => 'Left Rear Door', 'style' => 'left: 52.34%; top: 52.62%; width: 20.60%; height: 16.56%; z-index: 1;'],
                                    ['id' => 'lr-rim', 'name' => 'Left Rear Rim', 'style' => 'left: 69.75%; top: 64.01%; width: 10.45%; height: 7.32%; z-index: 2;'],
                                    ['id' => 'lr-quarter-panel', 'name' => 'Left Rear Quarter Panel', 'style' => 'left: 67.06%; top: 58.24%; width: 26.97%; height: 10.35%; z-index: 1;'],
                                    ['id' => 'front-bumper', 'name' => 'Front Bumper', 'style' => 'left: 4.18%; top: 87.21%; width: 37.21%; height: 6.28%; z-index: 1;'],
                                    ['id' => 'lf-headlight', 'name' => 'Left Front Headlight', 'style' => 'left: 29.35%; top: 85.37%; width: 9.15%; height: 2.51%; z-index: 1;'],
                                    ['id' => 'fr-headlight', 'name' => 'Right Front Headlight', 'style' => 'left: 6.97%; top: 85.37%; width: 9.05%; height: 2.51%; z-index: 1;'],
                                    ['id' => 'fr-mirror', 'name' => 'Right Front Mirror', 'style' => 'left: 3.98%; top: 80.93%; width: 4.78%; height: 2.36%; z-index: 1;'],
                                    ['id' => 'lf-mirror', 'name' => 'Left Front Mirror', 'style' => 'left: 36.62%; top: 80.93%; width: 4.78%; height: 2.36%; z-index: 1;'],
                                    ['id' => 'lr-taillight', 'name' => 'Left Rear Taillight', 'style' => 'left: 61.89%; top: 82.89%; width: 9.15%; height: 3.84%; z-index: 1;'],
                                    ['id' => 'rr-taillight', 'name' => 'Right Rear Taillight', 'style' => 'left: 81.59%; top: 82.89%; width: 9.15%; height: 3.84%; z-index: 1;'],
                                    ['id' => 'rear-bumper', 'name' => 'Rear Bumper', 'style' => 'left: 59.20%; top: 87.36%; width: 33.83%; height: 5.03%; z-index: 1;']
                                ];
                                
                                // Create a lookup array for panels with conditions
                                $panelConditions = [];
                                foreach($inspectionData['body_panels'] as $panel) {
                                    $panelConditions[str_replace('_', '-', $panel['panel_id'])] = $panel['condition'];
                                }
                            @endphp
                            
                            @foreach($allPanels as $panel)
                                @php
                                    $imageName = $panel['id'] . '.png';
                                    // Handle special cases
                                    if ($panel['id'] === 'rear-bumber') $imageName = 'rear-bumper.png';
                                    
                                    // Check if this panel has a condition
                                    $hasCondition = isset($panelConditions[$panel['id']]);
                                    $condition = $hasCondition ? $panelConditions[$panel['id']] : null;
                                @endphp
                                @if($hasCondition)
                                <div class="panel-overlay panel-{{ $panel['id'] }}" 
                                     data-panel="{{ str_replace('-', '_', $panel['id']) }}"
                                     data-condition="{{ strtolower($condition) }}"
                                     onclick="scrollToPanelCard('{{ str_replace('-', '_', $panel['id']) }}')"
                                     title="{{ $panel['name'] }} - {{ ucfirst($condition) }}"
                                     style="position: absolute; {{ $panel['style'] }} 
                                            -webkit-mask-image: url('/images/panels/{{ $imageName }}'); 
                                            mask-image: url('/images/panels/{{ $imageName }}'); 
                                            -webkit-mask-repeat: no-repeat; 
                                            mask-repeat: no-repeat; 
                                            -webkit-mask-position: center; 
                                            mask-position: center; 
                                            -webkit-mask-size: contain; 
                                            mask-size: contain;">
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Legend below vehicle image -->
                    <div class="condition-legend" style="display: flex; justify-content: center; align-items: center; gap: 30px; margin: 20px auto; padding: 10px;">
                        <div class="legend-title" style="font-weight: 600;">Condition Status:</div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span class="legend-color good"></span>
                            <span class="legend-label">Good</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span class="legend-color average"></span>
                            <span class="legend-label">Average</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span class="legend-color bad"></span>
                            <span class="legend-label">Poor</span>
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
                    
                    /* CSS Variables for condition colors */
                    :root {
                        --good: #2f7d32;
                        --average: #f2a007;
                        --poor: #c62828;
                    }
                    
                    /* Panel overlay using CSS mask to tint only non-transparent PNG pixels */
                    .panel-overlay {
                        cursor: pointer;
                        transition: all 0.3s ease;
                        opacity: 0.8;
                        background-color: var(--panel-color, var(--good));
                    }
                    
                    .panel-overlay:hover {
                        opacity: 0.9;
                    }
                    
                    /* Condition-based colors - PNG mask applied via inline styles */
                    .panel-overlay[data-condition="good"] {
                        --panel-color: var(--good);
                    }
                    
                    .panel-overlay[data-condition="average"] {
                        --panel-color: var(--average);
                    }
                    
                    .panel-overlay[data-condition="bad"] {
                        --panel-color: var(--poor);
                    }
                    
                    /* Interior Diagram Styles - same CSS mask approach as body panels */
                    .interior-diagram-container {
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
                    
                    .interior-base-wrapper {
                        position: relative;
                        max-width: 1005px;
                        width: 100%;
                        margin: 0 auto;
                        background-color: #f8f9fa;
                        padding: 0;
                        overflow: visible;
                    }
                    
                    /* Interior overlay using CSS mask to tint only non-transparent PNG pixels */
                    .interior-overlay {
                        cursor: pointer;
                        transition: all 0.3s ease;
                        opacity: 0.8;
                        background-color: var(--panel-color, var(--good));
                    }
                    
                    .interior-overlay:hover {
                        opacity: 0.9;
                    }
                    
                    /* Interior condition-based colors - PNG mask applied via inline styles */
                    .interior-overlay[data-condition="good"] {
                        --panel-color: var(--good);
                    }
                    
                    .interior-overlay[data-condition="average"] {
                        --panel-color: var(--average);
                    }
                    
                    .interior-overlay[data-condition="bad"] {
                        --panel-color: var(--poor);
                    }
                    
                    /* Legend Styles */
                    .condition-legend {
                        background: rgba(255, 255, 255, 0.95);
                        border-radius: 6px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
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
                            flex-wrap: wrap;
                            gap: 15px !important;
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
                    /* Standardized condition badges - mechanical system style */
                    .condition-Good, .condition-good {
                        background-color: #277020;
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 4px;
                        display: inline-block;
                        font-weight: 500;
                        font-size: 0.875rem;
                    }
                    .condition-Average, .condition-average {
                        background-color: #f5a409;
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 4px;
                        display: inline-block;
                        font-weight: 500;
                        font-size: 0.875rem;
                    }
                    .condition-Bad, .condition-bad {
                        background-color: #c62121;
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 4px;
                        display: inline-block;
                        font-weight: 500;
                        font-size: 0.875rem;
                    }
                    
                    /* Mechanical report now uses .condition-* classes directly */
                </style>
                
                @foreach($inspectionData['body_panels'] as $panel)
                <div class="panel-card" data-panel-card="{{ $panel['panel_id'] }}">
                    <!-- First Row: Panel Name only -->
                    <div class="panel-header">
                        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                            {{ $panel['panel_name'] }}
                        </div>
                    </div>
                    
                    <!-- Second Row: Condition, Comments, Additional Comments all on same line -->
                    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap;">
                        <!-- Condition -->
                        <div class="panel-condition" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Condition:</span>
                            @if($panel['condition'])
                            <span class="condition-{{ $panel['condition'] }}">
                                {{ ucfirst($panel['condition']) }}
                            </span>
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </div>
                        
                        <!-- Dropdown Comments -->
                        @if($panel['comment_type'])
                        <div class="panel-dropdown-comment" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
                            <span>{{ $panel['comment_type'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Additional Comments -->
                        @if($panel['additional_comment'])
                        <div class="panel-additional-comment" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Additional Comments:</span>
                            <span>{{ $panel['additional_comment'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Third Row: Images -->
                    @if(!empty($panel['images']))
                    <div class="panel-images">
                        <div class="images-row">
                            @foreach($panel['images'] as $image)
                            <div class="image-thumbnail">
                                <a href="{{ $image['url'] }}" data-lightbox="panel-{{ $panel['panel_id'] }}" 
                                   data-title="{{ $panel['panel_name'] }}">
                                    <img src="{{ $image['thumbnail'] }}" alt="{{ $panel['panel_name'] }} image">
                                </a>
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
            <!-- DEBUG: Interior data check -->
            {{-- DEBUG: {{ isset($inspectionData['interior']['assessments']) ? 'Interior data EXISTS with ' . count($inspectionData['interior']['assessments']) . ' items' : 'Interior data MISSING' }} --}}
            @if(!empty($inspectionData['interior']['assessments']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-house-door"></i>
                    Interior Assessment
                </h2>
                
                <!-- Individual Interior Component Cards (EXACT SAME AS BODY PANEL) -->
                @foreach($inspectionData['interior']['assessments'] as $assessment)
                <div class="panel-card" data-panel-card="{{ str_replace(' ', '_', strtolower($assessment['component_name'] ?? $assessment['component_id'])) }}">
                    <!-- First Row: Panel Name only -->
                    <div class="panel-header">
                        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                            {{ $assessment['component_name'] ?? 'Interior Component' }}
                        </div>
                    </div>
                    
                    <!-- Second Row: Condition, Colour, Comments all on same line (MATCHING BODY PANEL FORMAT) -->
                    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap;">
                        <!-- Condition -->
                        <div class="panel-condition" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Condition:</span>
                            @if($assessment['condition'])
                            <span class="condition-{{ strtolower($assessment['condition']) }}">
                                {{ ucfirst($assessment['condition']) }}
                            </span>
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </div>
                        
                        <!-- Colour (Interior specific field) -->
                        @if(!empty($assessment['colour']))
                        <div class="panel-dropdown-comment" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Colour:</span>
                            <span>{{ $assessment['colour'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Comments -->
                        @if(!empty($assessment['comment']))
                        <div class="panel-additional-comment" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
                            <span>{{ $assessment['comment'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Third Row: Images (EXACT SAME AS BODY PANEL) -->
                    @if(!empty($assessment['images']))
                    <div class="panel-images">
                        <div class="images-row">
                            @foreach($assessment['images'] as $image)
                            <div class="image-thumbnail">
                                <a href="{{ $image['url'] }}" data-lightbox="interior-{{ str_replace(' ', '_', strtolower($assessment['component_name'] ?? $assessment['component_id'])) }}" 
                                   data-title="{{ $assessment['component_name'] ?? 'Interior Component' }}">
                                    <img src="{{ $image['thumbnail'] }}" alt="{{ $assessment['component_name'] ?? 'Interior Component' }} image">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
                
                @if(empty($inspectionData['interior']['assessments']))
                <div class="alert alert-info">
                    No interior assessments recorded for this inspection.
                </div>
                @endif
                
                <!-- Interior Visual Section -->
                <section id="interior-diagram" aria-label="Vehicle Interior Components" style="margin-bottom: 2rem;">
                    <div class="interior-diagram-container">
                        <!-- Base interior image -->
                        <div class="interior-base-wrapper">
                            <img src="{{ asset('images/interior/interiorMain.png') }}" alt="Interior Base" class="layer-base" id="interiorBase">
                            
                            <!-- Interior panel overlays with CSS mask technique -->
                            @php
                                // Define all interior components with their EXACT positioning and images from interior-assessment.blade.php
                                $allInteriorComponents = [
                                    'dash' => ['name' => 'Dashboard', 'style' => 'left: 6.07%; top: 4.25%; width: 88.36%; height: 17.68%; z-index: 2;', 'image' => 'Dash.png'],
                                    'steering-wheel' => ['name' => 'Steering Wheel', 'style' => 'left: 59.20%; top: 17.68%; width: 23.88%; height: 8.56%; z-index: 3;', 'image' => 'steering-wheel.png'],
                                    'buttons' => ['name' => 'Buttons', 'style' => 'left: 47.36%; top: 18.86%; width: 6.47%; height: 4.59%; z-index: 2;', 'image' => 'buttons-centre.png'],
                                    'driver-seat' => ['name' => 'Driver Seat', 'style' => 'left: 55.52%; top: 18.86%; width: 34.43%; height: 31.25%; z-index: 2;', 'image' => 'driver-seat.png'],
                                    'passenger-seat' => ['name' => 'Passenger Seat', 'style' => 'left: 11.44%; top: 20.74%; width: 33.03%; height: 29.23%; z-index: 2;', 'image' => 'passenger-seat.png'],
                                    'rear-seat' => ['name' => 'Rear Seat', 'style' => 'left: 13.03%; top: 49.55%; width: 73.33%; height: 27.84%; z-index: 2;', 'image' => 'Rear-Seat.png'],
                                    'fr-door-panel' => ['name' => 'FR Door Panel', 'style' => 'left: 87.86%; top: 14.13%; width: 9.65%; height: 32.78%; z-index: 2;', 'image' => 'fr-dOORPANEL.png'],
                                    'fl-door-panel' => ['name' => 'FL Door Panel', 'style' => 'left: 3.08%; top: 14.13%; width: 10.05%; height: 33.47%; z-index: 2;', 'image' => 'FL Doorpanel.png'],
                                    'rr-door-panel' => ['name' => 'RR Door Panel', 'style' => 'left: 84.98%; top: 47.11%; width: 11.84%; height: 30.83%; z-index: 2;', 'image' => 'RR-Door-Panel.png'],
                                    'lr-door-panel' => ['name' => 'LR Door Panel', 'style' => 'left: 4.38%; top: 47.18%; width: 13.03%; height: 30.83%; z-index: 2;', 'image' => 'LR-DoorPanel.png'],
                                    'boot' => ['name' => 'Boot', 'style' => 'left: 10.25%; top: 91.15%; width: 80.70%; height: 8.70%; z-index: 2;', 'image' => 'Boot.png'],
                                    'centre-console' => ['name' => 'Centre Console', 'style' => 'left: 39.20%; top: 17.82%; width: 22.59%; height: 33.68%; z-index: 2;', 'image' => 'Centre-Consol.png'],
                                    'gearlever' => ['name' => 'Gear Lever', 'style' => 'left: 47.56%; top: 27.00%; width: 5.37%; height: 4.52%; z-index: 4;', 'image' => 'Gear-Lever.png'],
                                    'air-vents' => ['name' => 'Air Vents', 'style' => 'left: 7.06%; top: 12.67%; width: 86.37%; height: 10.44%; z-index: 2;', 'image' => 'Airvents.png'],
                                    'backboard' => ['name' => 'Backboard', 'style' => 'left: 10.65%; top: 76.53%; width: 80.80%; height: 19.14%; z-index: 2;', 'image' => 'backboard.png']
                                ];
                                
                                // Create a lookup array for interior components with conditions
                                $interiorConditions = [];
                                if(!empty($inspectionData['interior']['assessments'])) {
                                    foreach($inspectionData['interior']['assessments'] as $assessment) {
                                        // Map interior component IDs to their EXACT component IDs from the form
                                        $componentId = $assessment['component_id'] ?? '';
                                        
                                        // Map interior_XX IDs to EXACT overlay component IDs matching form panelIds
                                        $interiorIdMap = [
                                            'interior_77' => 'dash',
                                            'interior_78' => 'steering-wheel',
                                            'interior_79' => 'buttons',
                                            'interior_80' => 'driver-seat',
                                            'interior_81' => 'passenger-seat',
                                            'interior_82' => 'backboard', // Rooflining -> backboard (closest match)
                                            'interior_83' => 'fr-door-panel',
                                            'interior_84' => 'fl-door-panel',
                                            'interior_85' => 'rear-seat',
                                            'interior_86' => 'rear-seat', // Additional Seats -> rear-seat
                                            'interior_87' => 'backboard',
                                            'interior_88' => 'rr-door-panel',
                                            'interior_89' => 'lr-door-panel',
                                            'interior_90' => 'boot',
                                            'interior_91' => 'centre-console',
                                            'interior_92' => 'gearlever',
                                            'interior_93' => 'gearlever', // Handbrake -> gearlever (same area)
                                            'interior_94' => 'air-vents',
                                            'interior_95' => 'boot', // Mats -> boot (floor area)
                                            'interior_96' => 'dash' // General -> dashboard
                                        ];
                                        
                                        $exactComponentId = $interiorIdMap[$componentId] ?? '';
                                        
                                        if ($exactComponentId && !empty($assessment['condition'])) {
                                            // Use the worst condition if multiple components map to same exact component
                                            if (!isset($interiorConditions[$exactComponentId])) {
                                                $interiorConditions[$exactComponentId] = $assessment['condition'];
                                            } else {
                                                // Priority: bad > average > good (show worst condition)
                                                $currentCondition = strtolower($interiorConditions[$exactComponentId]);
                                                $newCondition = strtolower($assessment['condition']);
                                                
                                                if ($newCondition === 'bad' || 
                                                    ($newCondition === 'average' && $currentCondition === 'good')) {
                                                    $interiorConditions[$exactComponentId] = $assessment['condition'];
                                                }
                                            }
                                        }
                                    }
                                }
                            @endphp
                            
                            @foreach($allInteriorComponents as $componentId => $componentData)
                                @php
                                    // Check if this component has a condition
                                    $hasCondition = isset($interiorConditions[$componentId]);
                                    $condition = $hasCondition ? $interiorConditions[$componentId] : null;
                                    
                                    $imageName = $componentData['image'];
                                    $componentName = $componentData['name'];
                                    $componentStyle = $componentData['style'];
                                @endphp
                                @if($hasCondition)
                                <div class="interior-overlay interior-{{ $componentId }}" 
                                     data-panel="{{ $componentId }}"
                                     data-condition="{{ strtolower($condition) }}"
                                     onclick="scrollToInteriorComponent('{{ $componentId }}')"
                                     title="{{ $componentName }} - {{ ucfirst($condition) }}"
                                     style="position: absolute; {{ $componentStyle }} 
                                            -webkit-mask-image: url('/images/interior/{{ $imageName }}'); 
                                            mask-image: url('/images/interior/{{ $imageName }}'); 
                                            -webkit-mask-repeat: no-repeat; 
                                            mask-repeat: no-repeat; 
                                            -webkit-mask-position: center; 
                                            mask-position: center; 
                                            -webkit-mask-size: contain; 
                                            mask-size: contain;">
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Legend below interior image -->
                    <div class="condition-legend" style="display: flex; justify-content: center; align-items: center; gap: 30px; margin: 20px auto; padding: 10px;">
                        <div class="legend-title" style="font-weight: 600;">Condition Status:</div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span class="legend-color good"></span>
                            <span class="legend-label">Good</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span class="legend-color average"></span>
                            <span class="legend-label">Average</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span class="legend-color bad"></span>
                            <span class="legend-label">Poor</span>
                        </div>
                    </div>
                </section>
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

            <!-- Service Booklet Section -->
            @if(!empty($inspectionData['service_booklet']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-journal"></i>
                    Service Booklet Documentation
                </h2>
                
                @if(!empty($inspectionData['service_booklet']['images']))
                <div class="service-images-section" style="margin-bottom: 2rem;">
                    <h3 style="color: #495057; margin-bottom: 1rem;">Service Booklet Images</h3>
                    <div class="service-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                        @foreach($inspectionData['service_booklet']['images'] as $index => $image)
                        <div class="service-image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                            <a href="{{ $image['url'] }}" data-lightbox="service-booklet" data-title="Service Booklet Page {{ $index + 1 }}">
                                <img src="{{ $image['url'] }}" 
                                     alt="Service Booklet Page {{ $index + 1 }}" 
                                     style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                            </a>
                            <div style="padding: 10px; text-align: center; font-size: 0.9rem; color: #6c757d;">
                                Page {{ $index + 1 }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(!empty($inspectionData['service_booklet']['comments']) || !empty($inspectionData['service_booklet']['recommendations']))
                <div class="service-text-section">
                    @if(!empty($inspectionData['service_booklet']['comments']))
                    <div class="service-comments" style="margin-bottom: 1.5rem;">
                        <h3 style="color: #495057; margin-bottom: 0.5rem;">Service History Comments</h3>
                        <div style="background: #f8f9fa; border-left: 4px solid #4f959b; padding: 15px; border-radius: 4px;">
                            <p style="margin: 0; line-height: 1.6; color: #495057;">{{ $inspectionData['service_booklet']['comments'] }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if(!empty($inspectionData['service_booklet']['recommendations']))
                    <div class="service-recommendations" style="margin-bottom: 1.5rem;">
                        <h3 style="color: #495057; margin-bottom: 0.5rem;">Service Recommendations</h3>
                        <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 4px;">
                            <p style="margin: 0; line-height: 1.6; color: #495057;">{{ $inspectionData['service_booklet']['recommendations'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                @if(empty($inspectionData['service_booklet']['images']) && empty($inspectionData['service_booklet']['comments']) && empty($inspectionData['service_booklet']['recommendations']))
                <div style="text-align: center; padding: 2rem; color: #6c757d;">
                    <i class="bi bi-journal" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem;"></i>
                    <p>No service booklet documentation was recorded during this inspection.</p>
                </div>
                @endif
            </div>
            @endif

            <!-- Tyres & Rims Assessment -->
            @if(!empty($inspectionData['tyres_rims']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-circle"></i>
                    Tyres & Rims Assessment
                </h2>
                
                @foreach($inspectionData['tyres_rims'] as $tyre)
                <div class="panel-card" data-tyre-card="{{ $tyre['component_name'] ?? '' }}">
                    <!-- First Row: Tyre Name only -->
                    <div class="panel-header">
                        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                            @php
                                $tyreName = str_replace('_', ' ', $tyre['component_name'] ?? '');
                                $tyreName = ucwords($tyreName);
                            @endphp
                            {{ $tyreName }}
                        </div>
                    </div>
                    
                    <!-- Second Row: Tyre Details all on same line -->
                    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap; gap: 15px;">
                        <!-- Size -->
                        @if(!empty($tyre['size']))
                        <div class="tyre-size" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Size:</span>
                            <span>{{ $tyre['size'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Manufacture -->
                        @if(!empty($tyre['manufacture']))
                        <div class="tyre-manufacture" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Manufacture:</span>
                            <span>{{ $tyre['manufacture'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Model -->
                        @if(!empty($tyre['model']))
                        <div class="tyre-model" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Model:</span>
                            <span>{{ $tyre['model'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Tread Depth -->
                        @if(!empty($tyre['tread_depth']))
                        <div class="tyre-tread" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Tread Depth:</span>
                            <span>{{ $tyre['tread_depth'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Damages -->
                        @if(!empty($tyre['damages']))
                        <div class="tyre-damages" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Damages:</span>
                            <span class="{{ $tyre['damages'] === 'None' ? 'text-success' : 'text-warning' }}">{{ $tyre['damages'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Third Row: Images -->
                    @if(!empty($tyre['images']))
                    <div class="panel-images" style="padding: 15px 20px; border-top: 1px solid #e0e0e0;">
                        <div class="tyre-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                            @foreach($tyre['images'] as $image)
                            <div class="tyre-image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                                <a href="{{ $image['url'] }}" data-lightbox="tyre-{{ $tyre['component_name'] }}" data-title="{{ $tyreName }}">
                                    <img src="{{ $image['url'] }}" alt="{{ $tyreName }}" style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                                </a>
                                <div style="padding: 10px; text-align: center; font-size: 0.9rem; color: #6c757d;">
                                    {{ ucwords(str_replace(['_', '-'], ' ', $tyre['component_name'])) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
                
                <!-- Tyre Safety Disclaimer -->
                <div class="alert alert-info mt-4" style="background-color: #e8f4f8; border-color: #4f959b; border-radius: 8px; padding: 20px;">
                    <h4 style="color: #4f959b; margin-bottom: 15px;">
                        <i class="bi bi-info-circle"></i> Tyre Safety Information
                    </h4>
                    <p style="margin-bottom: 10px; line-height: 1.6;">
                        It is recommended that tyres are replaced when the tread depth reaches 2mm. If uneven tyre wear is noted, this may indicate incorrect geometry, which can result in excessive and rapid tyre wear. A full steering and geometry check is therefore recommended.
                    </p>
                    <p style="margin-bottom: 10px; line-height: 1.6;">
                        If this vehicle is fitted with "Run Flat" tyres and no spare wheel. The tyre's effectiveness in a puncture situation cannot be commented on.
                    </p>
                    <p style="margin-bottom: 0; line-height: 1.6;">
                        It is advised to have tyres of the correct size and of similar make, tread pattern and tread depth across axles. This will benefit steering and handling, the operation of the transmission, 4 wheel drive, traction control, ABS and puncture detection systems. This can also prevent premature transmission wear or failure.
                    </p>
                </div>
            </div>
            @endif

            <!-- Mechanical Report Assessment -->
            @if(!empty($inspectionData['mechanical_report']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-gear"></i>
                    Mechanical Report
                </h2>
                
                @foreach($inspectionData['mechanical_report'] as $component)
                <div class="panel-card" data-mechanical-card="{{ $component['component_name'] ?? '' }}">
                    <!-- First Row: Component Name -->
                    <div class="panel-header">
                        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                            @php
                                $componentName = str_replace('_', ' ', $component['component_name'] ?? '');
                                $componentName = ucwords($componentName);
                            @endphp
                            {{ $componentName }}
                        </div>
                    </div>
                    
                    <!-- Second Row: Condition and Comments -->
                    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap; gap: 15px;">
                        <!-- Condition -->
                        @if(!empty($component['condition']))
                        <div class="mechanical-condition" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Condition:</span>
                            <span class="condition-{{ $component['condition'] }}">{{ $component['condition'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Comments -->
                        @if(!empty($component['comments']))
                        <div class="mechanical-comments" style="display: flex; align-items: center; flex-grow: 1;">
                            <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
                            <span style="font-style: italic;">{{ $component['comments'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Third Row: Images -->
                    @if(!empty($component['images']))
                    <div class="panel-images" style="padding: 15px 20px; border-top: 1px solid #e0e0e0;">
                        <div class="images-label" style="font-weight: 500; margin-bottom: 10px;">Images:</div>
                        <div class="mechanical-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                            @foreach($component['images'] as $image)
                            <div class="mechanical-image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                                <a href="{{ $image['url'] }}" data-lightbox="mechanical-{{ $component['component_name'] }}" data-title="{{ $componentName }}">
                                    <img src="{{ $image['url'] }}" alt="{{ $componentName }}" style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                                </a>
                                <div style="padding: 10px; text-align: center; font-size: 0.9rem; color: #6c757d;">
                                    {{ ucwords(str_replace(['_', '-'], ' ', $component['component_name'])) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
                
                <!-- Mechanical Disclaimer -->
                <div class="alert alert-warning mt-4" style="background-color: #fff3cd; border-color: #ffeaa7; border-radius: 8px; padding: 20px;">
                    <h4 style="color: #856404; margin-bottom: 15px;">
                        <i class="bi bi-exclamation-triangle"></i> Mechanical Assessment Information
                    </h4>
                    <p style="margin-bottom: 10px; line-height: 1.6;">
                        This mechanical assessment represents the condition of accessible components during the road test and visual inspection. Some internal mechanical components may not be fully assessable without dismantling.
                    </p>
                    <p style="margin-bottom: 10px; line-height: 1.6;">
                        Any components marked as "Average" or "Bad" should be inspected by a qualified technician before purchase or use. Mechanical issues can affect safety, performance, and reliability.
                    </p>
                    <p style="margin-bottom: 0; line-height: 1.6;">
                        This report does not constitute a full mechanical diagnosis. For comprehensive mechanical assessment, a detailed workshop inspection is recommended.
                    </p>
                </div>
            </div>
            @endif

            <!-- Braking System Assessment -->
            @if(!empty($inspectionData['braking_system']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-disc"></i>
                    Braking System Assessment
                </h2>
                
                @foreach($inspectionData['braking_system'] as $brake)
                <div class="panel-card" data-brake-card="{{ $brake['position'] ?? '' }}">
                    <!-- First Row: Brake Position -->
                    <div class="panel-header">
                        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                            @php
                                $positionName = str_replace('_', ' ', $brake['position'] ?? '');
                                $positionName = ucwords($positionName);
                            @endphp
                            {{ $positionName }}
                        </div>
                    </div>
                    
                    <!-- Second Row: Brake Details -->
                    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap; gap: 15px;">
                        <!-- Pad Life -->
                        @if(!empty($brake['pad_life']))
                        <div class="brake-pad-life" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Pad Life:</span>
                            <span class="badge bg-info">{{ $brake['pad_life'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Pad Condition -->
                        @if(!empty($brake['pad_condition']))
                        <div class="brake-pad-condition" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Pad Condition:</span>
                            <span class="condition-{{ $brake['pad_condition'] }}">{{ $brake['pad_condition'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Disc Life -->
                        @if(!empty($brake['disc_life']))
                        <div class="brake-disc-life" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Disc Life:</span>
                            <span class="badge bg-info">{{ $brake['disc_life'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Disc Condition -->
                        @if(!empty($brake['disc_condition']))
                        <div class="brake-disc-condition" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Disc Condition:</span>
                            <span class="condition-{{ $brake['disc_condition'] }}">{{ $brake['disc_condition'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Comments -->
                        @if(!empty($brake['comments']))
                        <div class="brake-comments" style="display: flex; align-items: center; flex-grow: 1;">
                            <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
                            <span style="font-style: italic;">{{ $brake['comments'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Third Row: Images -->
                    @if(!empty($brake['images']))
                    <div class="panel-images" style="padding: 15px 20px; border-top: 1px solid #e0e0e0;">
                        <div class="images-label" style="font-weight: 500; margin-bottom: 10px;">Images:</div>
                        <div class="brake-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                            @foreach($brake['images'] as $image)
                            <div class="brake-image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                                <a href="{{ $image['url'] }}" data-lightbox="brake-{{ $brake['position'] }}" data-title="{{ $positionName }}">
                                    <img src="{{ $image['url'] }}" alt="{{ $positionName }}" style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                                </a>
                                <div style="padding: 10px; text-align: center; font-size: 0.9rem; color: #6c757d;">
                                    {{ ucwords(str_replace(['_', '-'], ' ', $brake['position'])) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Engine Compartment Assessment -->
            @if(!empty($inspectionData['engine_compartment']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-cpu"></i>
                    Engine Compartment Assessment
                </h2>
                
                @if(!empty($inspectionData['engine_compartment']['components']) || isset($inspectionData['engine_compartment']['overall_condition']))
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Overall Condition</div>
                        <div class="info-value">
                            <span class="condition-{{ strtolower($inspectionData['engine_compartment']['overall_condition'] ?? 'good') }}">
                                {{ ucfirst($inspectionData['engine_compartment']['overall_condition'] ?? 'Good') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($inspectionData['engine_compartment']['components']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Component Assessments</h3>
                @foreach($inspectionData['engine_compartment']['components'] as $component)
                <div class="panel-card" data-engine-card="{{ $component['component_type'] ?? '' }}">
                    <!-- First Row: Component Name -->
                    <div class="panel-header">
                        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                            @php
                                $componentName = str_replace('_', ' ', $component['component_type'] ?? '');
                                $componentName = ucwords($componentName);
                            @endphp
                            {{ $componentName }}
                        </div>
                    </div>
                    
                    <!-- Second Row: Condition and Comments -->
                    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap; gap: 15px;">
                        @if(!empty($component['condition']))
                        <div class="mechanical-condition" style="display: flex; align-items: center;">
                            <span style="font-weight: 500; margin-right: 10px;">Condition:</span>
                            <span class="condition-{{ $component['condition'] }}">{{ $component['condition'] }}</span>
                        </div>
                        @endif
                        
                        @if(!empty($component['comments']))
                        <div class="mechanical-comments" style="display: flex; align-items: center; flex-grow: 1;">
                            <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
                            <span style="font-style: italic;">{{ $component['comments'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Third Row: Images -->
                    @if(!empty($component['images']))
                    <div class="panel-images" style="padding: 15px 20px; border-top: 1px solid #e0e0e0;">
                        <div class="images-label" style="font-weight: 500; margin-bottom: 10px;">Images:</div>
                        <div class="engine-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                            @foreach($component['images'] as $image)
                            <div class="engine-image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                                <a href="{{ $image['url'] }}" data-lightbox="engine-{{ $component['component_type'] }}" data-title="{{ ucwords(str_replace('_', ' ', $component['component_type'])) }}">
                                    <img src="{{ $image['url'] }}" alt="{{ ucwords(str_replace('_', ' ', $component['component_type'])) }}" style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                                </a>
                                <div style="padding: 10px; text-align: center; font-size: 0.9rem; color: #6c757d;">
                                    {{ ucwords(str_replace(['_', '-'], ' ', $component['component_type'])) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
                @else
                <div class="info-card" style="text-align: center; color: #666; font-style: italic;">
                    No engine compartment component assessments completed for this inspection.
                </div>
                @endif

                @if(!empty($inspectionData['engine_compartment']['findings']))
                <h3 style="color: #4f959b; margin: 2rem 0 1rem;">Inspection Findings</h3>
                <div class="info-card">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($inspectionData['engine_compartment']['findings'] as $finding)
                        <li>
                            <strong>{{ ucwords(str_replace('_', ' ', $finding['finding_type'])) }}</strong>
                            @if(!empty($finding['notes']))
                            <br><span style="color: #666; font-style: italic;">{{ $finding['notes'] }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            @endif

            <!-- Physical Hoist Inspection -->
            @if(!empty($inspectionData['physical_hoist']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-wrench-adjustable"></i>
                    Physical Hoist Inspection
                </h2>

                @if(!empty($inspectionData['physical_hoist']['sections']))
                    @foreach($inspectionData['physical_hoist']['sections'] as $sectionName => $components)
                        @if(!empty($components))
                        <h3 style="color: #4f959b; margin: 2rem 0 1rem; text-transform: capitalize;">{{ ucfirst($sectionName) }} Components</h3>
                        
                        @foreach($components as $component)
                        <div class="panel-card" data-physical-hoist-card="{{ $component['component_name'] ?? '' }}">
                            <!-- First Row: Component Name -->
                            <div class="panel-header">
                                <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
                                    @php
                                        $componentName = str_replace('_', ' ', $component['component_name'] ?? '');
                                        $componentName = ucwords($componentName);
                                    @endphp
                                    {{ $componentName }}
                                </div>
                            </div>
                            
                            <!-- Second Row: Conditions and Comments -->
                            <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap; gap: 15px;">
                                
                                @if(!empty($component['primary_condition']))
                                <div class="primary-condition" style="display: flex; align-items: center;">
                                    <span style="font-weight: 500; margin-right: 10px;">Primary:</span>
                                    <span class="condition-{{ strtolower($component['primary_condition']) }}">{{ $component['primary_condition'] }}</span>
                                </div>
                                @endif
                                
                                @if(!empty($component['secondary_condition']))
                                <div class="secondary-condition" style="display: flex; align-items: center;">
                                    <span style="font-weight: 500; margin-right: 10px;">Secondary:</span>
                                    <span class="condition-{{ strtolower($component['secondary_condition']) }}">{{ $component['secondary_condition'] }}</span>
                                </div>
                                @endif
                                
                                @if(!empty($component['comments']))
                                <div class="component-comments" style="display: flex; align-items: center; flex-grow: 1;">
                                    <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
                                    <span style="font-style: italic;">{{ $component['comments'] }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Third Row: Images -->
                            @if(!empty($component['images']))
                            <div class="panel-images" style="padding: 15px 20px; border-top: 1px solid #e0e0e0;">
                                <div class="images-label" style="font-weight: 500; margin-bottom: 10px;">Images:</div>
                                <div class="component-images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                                    @foreach($component['images'] as $image)
                                    <div class="component-image-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                                        <a href="{{ $image['url'] }}" data-lightbox="physical-hoist-{{ $component['component_name'] }}" data-title="{{ $componentName }}">
                                            <img src="{{ $image['url'] }}" alt="{{ $componentName }}" style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                                        </a>
                                        <div style="padding: 10px; text-align: center; font-size: 0.9rem; color: #6c757d;">
                                            {{ ucwords(str_replace(['_', '-'], ' ', $component['component_name'])) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    @endforeach
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

// Function to scroll to interior component when clicking overlay
function scrollToInteriorComponent(componentId) {
    // Clean component ID to match different naming conventions
    const cleanComponentId = componentId.replace('-', '_');
    const altComponentId = componentId.replace('_', '-');
    
    // First try to find the component card by data attribute
    const componentCard = document.querySelector(`[data-interior-card="${componentId}"]`) || 
                         document.querySelector(`[data-interior-card="${cleanComponentId}"]`) ||
                         document.querySelector(`[data-interior-card="${altComponentId}"]`);
    
    if (componentCard) {
        // Highlight the component card temporarily
        componentCard.style.transition = 'all 0.3s ease';
        componentCard.style.backgroundColor = '#fff3cd';
        componentCard.style.border = '2px solid #ffc107';
        
        // Scroll to the component card
        componentCard.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        
        // Remove highlight after 2 seconds
        setTimeout(() => {
            componentCard.style.backgroundColor = '';
            componentCard.style.border = '';
        }, 2000);
        return;
    }
    
    // Fallback: Look for component in the table rows if card not found
    const allRows = document.querySelectorAll('table tbody tr');
    for (let row of allRows) {
        const componentName = row.querySelector('td:first-child strong');
        if (componentName) {
            const componentText = componentName.textContent.toLowerCase();
            const searchText = componentId.replace('-', ' ').toLowerCase();
            
            if (componentText.includes(searchText) || searchText.includes(componentText)) {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.style.backgroundColor = '#fff3cd';
                row.style.transition = 'background-color 0.3s ease';
                setTimeout(() => {
                    row.style.backgroundColor = '';
                }, 2000);
                return;
            }
        }
    }
    
    // Final fallback: scroll to the interior section
    const interiorSection = document.querySelector('#interior-diagram');
    if (interiorSection) {
        interiorSection.closest('.section').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
    }
}
</script>
@endsection