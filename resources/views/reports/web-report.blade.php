@extends('layouts.app')

@section('title', 'Inspection Report - ' . ($report->report_number ?? 'Report'))

@section('additional-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
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
                <a href="{{ route('reports.pdf', $report->id) }}" class="btn btn-danger">
                    <i class="bi bi-file-pdf"></i> Download PDF
                </a>
                <button onclick="window.print()" class="btn btn-light">
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
                    <i class="bi bi-person-vcard"></i>
                    Vehicle & Client Information
                </h2>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Client Name</div>
                        <div class="info-value">{{ $inspectionData['client']['name'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Contact Number</div>
                        <div class="info-value">{{ $inspectionData['client']['contact'] ?? 'Not specified' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $inspectionData['client']['email'] ?? 'Not specified' }}</div>
                    </div>
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

            <!-- Body Panel Assessment -->
            @if(!empty($inspectionData['body_panels']['assessments']))
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-car-front"></i>
                    Body Panel Assessment
                </h2>
                
                <div class="table-responsive">
                    <table class="assessment-table">
                        <thead>
                            <tr>
                                <th>Panel</th>
                                <th>Condition</th>
                                <th>Comments</th>
                                <th>Additional Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspectionData['body_panels']['assessments'] as $panel => $assessment)
                            <tr>
                                <td><strong>{{ ucwords(str_replace('-', ' ', $panel)) }}</strong></td>
                                <td>
                                    <span class="condition-badge condition-{{ $assessment['condition'] ?? 'good' }}">
                                        {{ ucfirst($assessment['condition'] ?? 'Good') }}
                                    </span>
                                </td>
                                <td>{{ $assessment['comment'] ?? '-' }}</td>
                                <td>{{ $assessment['additionalComment'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configure lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Image %1 of %2',
        'fadeDuration': 300,
        'imageFadeDuration': 300
    });
    
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
</script>
@endsection