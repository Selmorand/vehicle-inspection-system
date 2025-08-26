<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Inspection Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
            color: #333;
        }
        
        .header {
            text-align: center;
            background: #4f959b;
            color: white;
            padding: 20px;
            margin: -15px -15px 20px -15px;
            border-radius: 0;
        }
        
        .header h1 {
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        
        .header .meta {
            font-size: 10px;
            opacity: 0.9;
        }
        
        .section-title {
            background-color: #4f959b;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 14px;
            margin: 20px 0 10px 0;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 5px 10px 5px 0;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            width: 30%;
        }
        
        .info-value {
            color: #333;
        }
        
        .panel-card {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            background: white;
        }
        
        .panel-header {
            background-color: #f8f9fa;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .panel-body {
            padding: 10px;
            font-size: 11px;
        }
        
        .condition-good { color: #28a745; font-weight: bold; }
        .condition-average { color: #ffc107; font-weight: bold; }
        .condition-bad { color: #dc3545; font-weight: bold; }
        
        .image-count {
            color: #666;
            font-style: italic;
            font-size: 10px;
        }
        
        .image-grid {
            margin: 10px 0;
        }
        
        .image-container {
            display: inline-block;
            margin: 5px;
            text-align: center;
            page-break-inside: avoid;
        }
        
        .image-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
            padding: 0;
        }
        
        .image-caption {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }
        
        .view-link {
            font-size: 9px;
            color: #4f959b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>ALPHA VEHICLE INSPECTIONS</h1>
        <div class="subtitle">Professional Vehicle Assessment Report</div>
        <div class="meta">
            Report #: {{ $report->report_number ?? 'N/A' }} | 
            Generated: {{ date('F j, Y \a\t g:i A') }}
        </div>
    </div>

    <!-- Basic Information -->
    <div class="section-title">Vehicle Information</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell info-label">Make/Model/Year:</div>
            <div class="info-cell info-value">{{ ($inspectionData['vehicle']['make'] ?? 'N/A') . ' ' . ($inspectionData['vehicle']['model'] ?? '') . ' ' . ($inspectionData['vehicle']['year'] ?? '') }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">VIN:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['vin'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">License Plate:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['license_plate'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Mileage:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['mileage'] ?? 'Not specified' }} km</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Vehicle Type:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['vehicle_type'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Colour:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['colour'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Fuel Type:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['fuel_type'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Transmission:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['transmission'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Doors:</div>
            <div class="info-cell info-value">{{ $inspectionData['vehicle']['doors'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Inspector:</div>
            <div class="info-cell info-value">{{ $inspectionData['inspection']['inspector'] ?? 'Not specified' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Inspection Date:</div>
            <div class="info-cell info-value">{{ $inspectionData['inspection']['date'] ?? 'Not specified' }}</div>
        </div>
    </div>

    <!-- Visual Inspection Images -->
    @if(!empty($inspectionData['images']['visual']) && count($inspectionData['images']['visual']) > 0)
    <div class="section-title">Visual Inspection</div>
    <div class="panel-body">
        <strong>Visual inspection completed with {{ count($inspectionData['images']['visual']) }} images captured</strong>
        <div class="image-grid">
            @foreach(array_slice($inspectionData['images']['visual'], 0, 6) as $image)
            @if(!empty($image['data_url']))
            <div class="image-container">
                <a href="{{ $image['data_url'] }}" target="_blank">
                    <img src="{{ $image['data_url'] }}" alt="{{ $image['area_name'] ?? 'Visual Inspection' }}" />
                </a>
                <div class="image-caption">{{ $image['area_name'] ?? 'Image' }}</div>
                <a href="{{ $image['data_url'] }}" target="_blank" class="view-link">View Full Image →</a>
            </div>
            @endif
            @endforeach
        </div>
        @if(count($inspectionData['images']['visual']) > 6)
        <div class="image-count">+ {{ count($inspectionData['images']['visual']) - 6 }} more images available in web report</div>
        @endif
    </div>
    @endif

    <!-- Diagnostic Report -->
    @if(!empty($inspectionData['inspection']['diagnostic_report']) || !empty($inspectionData['inspection']['diagnostic_file']['name']))
    <div class="section-title">Diagnostic Report</div>
    <div class="panel-body">
        @if(!empty($inspectionData['inspection']['diagnostic_report']))
        <strong>Diagnostic Findings:</strong><br>
        {{ $inspectionData['inspection']['diagnostic_report'] }}
        <br><br>
        @endif
        
        @if(!empty($inspectionData['inspection']['diagnostic_file']['name']))
        <strong>Diagnostic File Attached:</strong><br>
        <a href="{{ $inspectionData['inspection']['diagnostic_file']['data'] ?? '#' }}" target="_blank" style="color: #4f959b; text-decoration: underline;">
            📄 {{ $inspectionData['inspection']['diagnostic_file']['name'] }}
        </a>
        @if(!empty($inspectionData['inspection']['diagnostic_file']['size']))
        <span class="image-count">({{ number_format($inspectionData['inspection']['diagnostic_file']['size'] / 1024, 1) }} KB)</span>
        @endif
        @endif
    </div>
    @endif

    <!-- Body Panel Assessment -->
    @php
        $validBodyPanels = [];
        if (!empty($inspectionData['body_panels']) && is_array($inspectionData['body_panels'])) {
            foreach ($inspectionData['body_panels'] as $panel) {
                $hasCondition = !empty($panel['condition']) && $panel['condition'] !== 'not_assessed';
                $hasComment = !empty($panel['comment_type']);
                $hasNotes = !empty($panel['additional_comment']);
                $hasImages = !empty($panel['images']) && is_array($panel['images']) && count($panel['images']) > 0;
                
                if ($hasCondition || $hasComment || $hasNotes || $hasImages) {
                    $validBodyPanels[] = $panel;
                }
            }
        }
    @endphp
    
    @if(!empty($validBodyPanels))
    <div class="section-title">Body Panel Assessment</div>
    
    <!-- Vehicle Diagram -->
    <div style="text-align: center; margin: 20px 0; page-break-inside: avoid;">
        <img src="{{ public_path('images/panels/FullVehicle.png') }}" alt="Vehicle Body Panels" style="max-width: 600px; width: 100%; height: auto; border: 1px solid #ddd;">
        
        <!-- Condition Legend -->
        @php
            $panelConditions = [];
            foreach ($validBodyPanels as $panel) {
                if (!empty($panel['condition']) && $panel['condition'] !== 'not_assessed') {
                    $panelConditions[strtolower($panel['condition'])][] = $panel['panel_name'];
                }
            }
        @endphp
        
        @if(!empty($panelConditions))
        <div style="margin: 15px 0; text-align: left; display: inline-block;">
            <strong style="font-size: 11px;">Panel Conditions:</strong>
            <div style="margin-top: 5px;">
                @if(!empty($panelConditions['good']))
                <div style="margin: 3px 0;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px; vertical-align: middle;"></span>
                    <strong style="color: #28a745; font-size: 10px;">Good:</strong>
                    <span style="font-size: 9px;">{{ implode(', ', array_map(function($name) { return ucwords(str_replace(['_', '-'], ' ', $name)); }, $panelConditions['good'])) }}</span>
                </div>
                @endif
                
                @if(!empty($panelConditions['average']))
                <div style="margin: 3px 0;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffc107; margin-right: 5px; vertical-align: middle;"></span>
                    <strong style="color: #ffc107; font-size: 10px;">Average:</strong>
                    <span style="font-size: 9px;">{{ implode(', ', array_map(function($name) { return ucwords(str_replace(['_', '-'], ' ', $name)); }, $panelConditions['average'])) }}</span>
                </div>
                @endif
                
                @if(!empty($panelConditions['bad']))
                <div style="margin: 3px 0;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; margin-right: 5px; vertical-align: middle;"></span>
                    <strong style="color: #dc3545; font-size: 10px;">Poor:</strong>
                    <span style="font-size: 9px;">{{ implode(', ', array_map(function($name) { return ucwords(str_replace(['_', '-'], ' ', $name)); }, $panelConditions['bad'])) }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    @foreach($validBodyPanels as $panel)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords(str_replace(['_', '-'], ' ', $panel['panel_name'] ?? 'Unknown Panel')) }}
        </div>
        <div class="panel-body">
            @if(!empty($panel['condition']) && $panel['condition'] !== 'not_assessed')
            <strong>Condition:</strong> 
            <span class="condition-{{ strtolower($panel['condition']) }}">
                {{ ucfirst($panel['condition']) }}
            </span>
            @endif
            
            @if(!empty($panel['comment_type']))
            <br><strong>Comment:</strong> {{ $panel['comment_type'] }}
            @endif
            
            @if(!empty($panel['additional_comment']))
            <br><strong>Notes:</strong> {{ $panel['additional_comment'] }}
            @endif
            
            @if(!empty($panel['images']) && is_array($panel['images']) && count($panel['images']) > 0)
            <div class="image-grid">
                @foreach(array_slice($panel['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $panel['panel_name'] ?? 'Panel' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace(['_', '-'], ' ', $panel['panel_name'] ?? 'Panel')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($panel['images']) > 2)
            <span class="image-count">+ {{ count($panel['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
        </div>
    </div>
    @endforeach
    @endif

    <!-- Interior Assessment -->
    @php
        $validInteriorComponents = [];
        if (!empty($inspectionData['interior']['assessments']) && is_array($inspectionData['interior']['assessments'])) {
            foreach ($inspectionData['interior']['assessments'] as $component) {
                $hasCondition = !empty($component['condition']) && $component['condition'] !== 'not_assessed';
                $hasColor = !empty($component['colour']);
                $hasComment = !empty($component['comment']);
                $hasImages = !empty($component['images']) && is_array($component['images']) && count($component['images']) > 0;
                
                if ($hasCondition || $hasColor || $hasComment || $hasImages) {
                    $validInteriorComponents[] = $component;
                }
            }
        }
    @endphp
    
    @if(!empty($validInteriorComponents))
    <div class="section-title">Interior Assessment</div>
    
    <!-- Interior Diagram -->
    <div style="text-align: center; margin: 20px 0; page-break-inside: avoid;">
        <img src="{{ public_path('images/interior/interiorMain.png') }}" alt="Vehicle Interior" style="max-width: 600px; width: 100%; height: auto; border: 1px solid #ddd;">
        
        <!-- Interior Condition Legend -->
        @php
            $interiorConditions = [];
            foreach ($validInteriorComponents as $component) {
                if (!empty($component['condition']) && $component['condition'] !== 'not_assessed') {
                    $interiorConditions[strtolower($component['condition'])][] = $component['component_name'];
                }
            }
        @endphp
        
        @if(!empty($interiorConditions))
        <div style="margin: 15px 0; text-align: left; display: inline-block;">
            <strong style="font-size: 11px;">Interior Component Conditions:</strong>
            <div style="margin-top: 5px;">
                @if(!empty($interiorConditions['good']))
                <div style="margin: 3px 0;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px; vertical-align: middle;"></span>
                    <strong style="color: #28a745; font-size: 10px;">Good:</strong>
                    <span style="font-size: 9px;">{{ implode(', ', array_map(function($name) { return ucwords(str_replace(['_', '-'], ' ', $name)); }, $interiorConditions['good'])) }}</span>
                </div>
                @endif
                
                @if(!empty($interiorConditions['average']))
                <div style="margin: 3px 0;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffc107; margin-right: 5px; vertical-align: middle;"></span>
                    <strong style="color: #ffc107; font-size: 10px;">Average:</strong>
                    <span style="font-size: 9px;">{{ implode(', ', array_map(function($name) { return ucwords(str_replace(['_', '-'], ' ', $name)); }, $interiorConditions['average'])) }}</span>
                </div>
                @endif
                
                @if(!empty($interiorConditions['bad']))
                <div style="margin: 3px 0;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #dc3545; margin-right: 5px; vertical-align: middle;"></span>
                    <strong style="color: #dc3545; font-size: 10px;">Poor:</strong>
                    <span style="font-size: 9px;">{{ implode(', ', array_map(function($name) { return ucwords(str_replace(['_', '-'], ' ', $name)); }, $interiorConditions['bad'])) }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    @foreach($validInteriorComponents as $component)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords(str_replace('_', ' ', $component['component_name'] ?? 'Component')) }}
        </div>
        <div class="panel-body">
            @if(!empty($component['condition']) && $component['condition'] !== 'not_assessed')
            <strong>Condition:</strong> 
            <span class="condition-{{ strtolower($component['condition']) }}">
                {{ ucfirst($component['condition']) }}
            </span>
            @endif
            
            @if(!empty($component['colour']))
            <br><strong>Color:</strong> {{ $component['colour'] }}
            @endif
            
            @if(!empty($component['comment']))
            <br><strong>Comment:</strong> {{ $component['comment'] }}
            @endif
            
            @if(!empty($component['images']) && is_array($component['images']) && count($component['images']) > 0)
            <div class="image-grid">
                @foreach(array_slice($component['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $component['component_name'] ?? 'Component' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace('_', ' ', $component['component_name'] ?? 'Component')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($component['images']) > 2)
            <span class="image-count">+ {{ count($component['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
        </div>
    </div>
    @endforeach
    @endif

    <!-- Mechanical Assessment -->
    @php
        $validMechanicalComponents = [];
        if (!empty($inspectionData['mechanical_report']['components']) && is_array($inspectionData['mechanical_report']['components'])) {
            foreach ($inspectionData['mechanical_report']['components'] as $component) {
                $hasCondition = !empty($component['condition']) && $component['condition'] !== 'not_assessed';
                $hasComments = !empty($component['comments']);
                $hasImages = !empty($component['images']) && is_array($component['images']) && count($component['images']) > 0;
                
                if ($hasCondition || $hasComments || $hasImages) {
                    $validMechanicalComponents[] = $component;
                }
            }
        }
    @endphp
    
    @if(!empty($validMechanicalComponents))
    <div class="section-title">Mechanical Assessment</div>
    @foreach($validMechanicalComponents as $component)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords(str_replace('_', ' ', $component['component_name'] ?? 'Component')) }}
        </div>
        <div class="panel-body">
            @if(!empty($component['condition']) && $component['condition'] !== 'not_assessed')
            <strong>Condition:</strong> 
            <span class="condition-{{ strtolower($component['condition']) }}">
                {{ ucfirst($component['condition']) }}
            </span>
            @endif
            
            @if(!empty($component['comments']))
            <br><strong>Comments:</strong> {{ $component['comments'] }}
            @endif
            
            @if(!empty($component['images']) && is_array($component['images']) && count($component['images']) > 0)
            <div class="image-grid">
                @foreach(array_slice($component['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $component['component_name'] ?? 'Component' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace('_', ' ', $component['component_name'] ?? 'Component')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($component['images']) > 2)
            <span class="image-count">+ {{ count($component['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
        </div>
    </div>
    @endforeach
    @endif

    <!-- Road Test Information -->
    @if(!empty($inspectionData['mechanical_report']['road_test']))
    <div class="section-title">Road Test Information</div>
    <div class="panel-card">
        <div class="panel-body">
            @php $roadTest = $inspectionData['mechanical_report']['road_test']; @endphp
            @if(!empty($roadTest['distance']))
            <strong>Test Distance:</strong> {{ $roadTest['distance'] }}<br>
            @endif
            @if(!empty($roadTest['speed']))
            <strong>Test Speed:</strong> {{ $roadTest['speed'] }}<br>
            @endif
        </div>
    </div>
    @endif


    <!-- Service Booklet -->
    @if(!empty($inspectionData['service_booklet']))
    <div class="section-title">Service Booklet Documentation</div>
    <div class="panel-body">
        @if(!empty($inspectionData['service_booklet']['comments']))
        <strong>Service Comments:</strong><br>
        {{ $inspectionData['service_booklet']['comments'] }}<br><br>
        @endif
        
        @if(!empty($inspectionData['service_booklet']['recommendations']))
        <strong>Service Recommendations:</strong><br>
        {{ $inspectionData['service_booklet']['recommendations'] }}<br><br>
        @endif
        
        @if(!empty($inspectionData['service_booklet']['images']))
        <strong>Service book images captured:</strong> {{ count($inspectionData['service_booklet']['images']) }} images
        <div class="image-grid">
            @foreach(array_slice($inspectionData['service_booklet']['images'], 0, 4) as $image)
            @if(!empty($image['url']))
            <div class="image-container">
                <a href="{{ $image['url'] }}" target="_blank">
                    <img src="{{ $image['url'] }}" alt="Service Booklet Page" />
                </a>
                <div class="image-caption">{{ $image['caption'] ?? 'Service Page' }}</div>
                <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
            </div>
            @endif
            @endforeach
        </div>
        @if(count($inspectionData['service_booklet']['images']) > 4)
        <span class="image-count">+ {{ count($inspectionData['service_booklet']['images']) - 4 }} more page(s) in web report</span>
        @endif
        @else
        <strong>Service history documentation reviewed</strong>
        @endif
    </div>
    @endif

    <!-- Tyres & Rims Assessment -->
    @php
        $validTyres = [];
        if (!empty($inspectionData['tyres_rims']) && is_array($inspectionData['tyres_rims'])) {
            foreach ($inspectionData['tyres_rims'] as $tyre) {
                $hasData = !empty($tyre['manufacture']) || !empty($tyre['model']) || !empty($tyre['size']) || 
                          !empty($tyre['tread_depth']) || !empty($tyre['damages']);
                $hasImages = !empty($tyre['images']) && is_array($tyre['images']) && count($tyre['images']) > 0;
                
                if ($hasData || $hasImages) {
                    $validTyres[] = $tyre;
                }
            }
        }
    @endphp
    
    @if(!empty($validTyres))
    <div class="section-title">Tyres & Rims Assessment</div>
    @foreach($validTyres as $tyre)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords(str_replace('_', ' ', $tyre['component_name'] ?? 'Tyre Position')) }}
        </div>
        <div class="panel-body">
            @if(!empty($tyre['manufacture']))
            <strong>Manufacture:</strong> {{ $tyre['manufacture'] }}<br>
            @endif
            @if(!empty($tyre['model']))
            <strong>Model:</strong> {{ $tyre['model'] }}<br>
            @endif
            @if(!empty($tyre['size']))
            <strong>Size:</strong> {{ $tyre['size'] }}<br>
            @endif
            @if(!empty($tyre['tread_depth']))
            <strong>Tread Depth:</strong> {{ $tyre['tread_depth'] }} mm<br>
            @endif
            @if(!empty($tyre['damages']))
            <strong>Damages:</strong> {{ $tyre['damages'] }}<br>
            @endif
            
            @if(!empty($tyre['images']) && is_array($tyre['images']) && count($tyre['images']) > 0)
            <div class="image-grid">
                @foreach(array_slice($tyre['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $tyre['component_name'] ?? 'Tyre' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace('_', ' ', $tyre['component_name'] ?? 'Tyre')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($tyre['images']) > 2)
            <span class="image-count">+ {{ count($tyre['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
        </div>
    </div>
    @endforeach
    @endif

    <!-- Braking System Assessment -->
    @php
        $validBrakePositions = [];
        if (!empty($inspectionData['braking_system']) && is_array($inspectionData['braking_system'])) {
            foreach ($inspectionData['braking_system'] as $brake) {
                $hasData = !empty($brake['pad_life']) || !empty($brake['pad_condition']) || 
                          !empty($brake['disc_life']) || !empty($brake['disc_condition']) || !empty($brake['comments']);
                $hasImages = !empty($brake['images']) && is_array($brake['images']) && count($brake['images']) > 0;
                
                if ($hasData || $hasImages) {
                    $validBrakePositions[] = $brake;
                }
            }
        }
    @endphp
    
    @if(!empty($validBrakePositions))
    <div class="section-title">Braking System Assessment</div>
    @foreach($validBrakePositions as $brake)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords(str_replace('_', ' ', $brake['position'] ?? 'Position')) }}
        </div>
        <div class="panel-body">
            @if(!empty($brake['pad_life']))
            <strong>Pad Life:</strong> {{ $brake['pad_life'] }}<br>
            @endif
            @if(!empty($brake['pad_condition']))
            <strong>Pad Condition:</strong> 
            <span class="condition-{{ strtolower($brake['pad_condition']) }}">
                {{ ucfirst($brake['pad_condition']) }}
            </span><br>
            @endif
            @if(!empty($brake['disc_life']))
            <strong>Disc Life:</strong> {{ $brake['disc_life'] }}<br>
            @endif
            @if(!empty($brake['disc_condition']))
            <strong>Disc Condition:</strong> 
            <span class="condition-{{ strtolower($brake['disc_condition']) }}">
                {{ ucfirst($brake['disc_condition']) }}
            </span><br>
            @endif
            @if(!empty($brake['comments']))
            <strong>Comments:</strong> {{ $brake['comments'] }}
            @endif
            
            @if(!empty($brake['images']) && is_array($brake['images']) && count($brake['images']) > 0)
            <div class="image-grid">
                @foreach(array_slice($brake['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $brake['position'] ?? 'Brake' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace('_', ' ', $brake['position'] ?? 'Brake')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($brake['images']) > 2)
            <span class="image-count">+ {{ count($brake['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
        </div>
    </div>
    @endforeach
    @endif

    <!-- Engine Compartment Assessment -->
    @if(!empty($inspectionData['engine_compartment']))
    <div class="section-title">Engine Compartment Assessment</div>
    
    @if(!empty($inspectionData['engine_compartment']['overall_condition']))
    <div class="panel-card">
        <div class="panel-header">Overall Engine Compartment Condition</div>
        <div class="panel-body">
            <strong>Overall Assessment:</strong> 
            <span class="condition-{{ strtolower($inspectionData['engine_compartment']['overall_condition']) }}">
                {{ ucfirst($inspectionData['engine_compartment']['overall_condition']) }}
            </span>
        </div>
    </div>
    @endif
    
    @if(!empty($inspectionData['engine_compartment']['findings']) && is_array($inspectionData['engine_compartment']['findings']))
    <div class="panel-card">
        <div class="panel-header">General Engine Compartment Inspection</div>
        <div class="panel-body">
            @foreach($inspectionData['engine_compartment']['findings'] as $finding)
            @if($finding['finding_type'] !== 'engine_number_input')
            <strong>{{ ucwords(str_replace('_', ' ', $finding['finding_type'])) }}:</strong> {{ $finding['finding_value'] ?? 'N/A' }}<br>
            @endif
            @endforeach
        </div>
    </div>
    @endif
    
    @if(!empty($inspectionData['engine_compartment']['components']) && is_array($inspectionData['engine_compartment']['components']))
    @php
        $validEngineComponents = [];
        foreach ($inspectionData['engine_compartment']['components'] as $component) {
            $hasCondition = !empty($component['condition']) && $component['condition'] !== 'not_assessed';
            $hasComments = !empty($component['comments']);
            $hasImages = !empty($component['images']) && is_array($component['images']) && count($component['images']) > 0;
            
            if ($hasCondition || $hasComments || $hasImages) {
                $validEngineComponents[] = $component;
            }
        }
    @endphp
    
    @foreach($validEngineComponents as $component)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords(str_replace('_', ' ', $component['component_type'] ?? 'Component')) }}
        </div>
        <div class="panel-body">
            @if(!empty($component['condition']) && $component['condition'] !== 'not_assessed')
            <strong>Condition:</strong> 
            <span class="condition-{{ strtolower($component['condition']) }}">
                {{ ucfirst($component['condition']) }}
            </span>
            @endif
            
            @if(!empty($component['comments']))
            <br><strong>Comments:</strong> {{ $component['comments'] }}
            @endif
            
            @if(!empty($component['images']) && is_array($component['images']) && count($component['images']) > 0)
            <div class="image-grid">
                @foreach(array_slice($component['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $component['component_type'] ?? 'Component' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace('_', ' ', $component['component_type'] ?? 'Component')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($component['images']) > 2)
            <span class="image-count">+ {{ count($component['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
        </div>
    </div>
    @endforeach
    @endif
    @endif

    <!-- Physical Hoist Inspection -->
    @php
        $validHoistSections = [];
        if (!empty($inspectionData['physical_hoist']['sections']) && is_array($inspectionData['physical_hoist']['sections'])) {
            foreach ($inspectionData['physical_hoist']['sections'] as $sectionName => $components) {
                if (!empty($components) && is_array($components)) {
                    $validComponents = [];
                    foreach ($components as $component) {
                        $hasCondition = !empty($component['primary_condition']) && $component['primary_condition'] !== 'not_assessed';
                        $hasComments = !empty($component['comments']);
                        $hasImages = !empty($component['images']) && is_array($component['images']) && count($component['images']) > 0;
                        
                        if ($hasCondition || $hasComments || $hasImages) {
                            $validComponents[] = $component;
                        }
                    }
                    
                    if (!empty($validComponents)) {
                        $validHoistSections[$sectionName] = $validComponents;
                    }
                }
            }
        }
    @endphp
    
    @if(!empty($validHoistSections))
    <div class="section-title">Physical Hoist Inspection</div>
    @foreach($validHoistSections as $sectionName => $components)
    <div class="panel-card">
        <div class="panel-header">
            {{ ucwords($sectionName) }} Components
        </div>
        <div class="panel-body">
            @foreach($components as $component)
            <strong>{{ ucwords(str_replace('_', ' ', $component['component_name'] ?? 'Component')) }}:</strong> 
            @if(!empty($component['primary_condition']) && $component['primary_condition'] !== 'not_assessed')
            <span class="condition-{{ strtolower($component['primary_condition']) }}">
                {{ ucfirst($component['primary_condition']) }}
            </span>
            @endif
            @if(!empty($component['comments']))
            - {{ $component['comments'] }}
            @endif
            
            @if(!empty($component['images']) && is_array($component['images']) && count($component['images']) > 0)
            <div class="image-grid" style="margin-top: 10px;">
                @foreach(array_slice($component['images'], 0, 2) as $image)
                @if(!empty($image['url']))
                <div class="image-container">
                    <a href="{{ $image['url'] }}" target="_blank">
                        <img src="{{ $image['url'] }}" alt="{{ $component['component_name'] ?? 'Component' }}" />
                    </a>
                    <div class="image-caption">{{ ucwords(str_replace('_', ' ', $component['component_name'] ?? 'Component')) }}</div>
                    <a href="{{ $image['url'] }}" target="_blank" class="view-link">View Full Image →</a>
                </div>
                @endif
                @endforeach
            </div>
            @if(count($component['images']) > 2)
            <span class="image-count">+ {{ count($component['images']) - 2 }} more image(s) in web report</span>
            @endif
            @endif
            <br>
            @endforeach
        </div>
    </div>
    @endforeach
    @endif

    <!-- Inspector Notes -->
    @if(!empty($inspectionData['inspection']['notes']))
    <div class="section-title">Inspector Notes</div>
    <div class="panel-body">
        {{ $inspectionData['inspection']['notes'] }}
    </div>
    @endif

    <!-- Summary -->
    <div class="section-title">Inspection Summary</div>
    <div class="panel-body">
        <strong>Assessment Complete:</strong> This vehicle inspection report includes all completed assessments and findings.
        <br><br>
        <strong>Generated:</strong> {{ date('F j, Y \a\t g:i A') }} by Alpha Vehicle Inspections.
        <br><br>
        <div style="background-color: #f8f9fa; padding: 10px; border-left: 3px solid #4f959b; margin-top: 10px;">
            <strong>📸 View Full Report with All Images Online:</strong><br>
            <a href="{{ $baseUrl ?? url('') }}/reports/{{ $report->id }}" target="_blank" style="color: #4f959b; font-size: 11px;">
                {{ $baseUrl ?? url('') }}/reports/{{ $report->id }}
            </a>
            <br>
            <span style="font-size: 9px; color: #666;">
                The online version includes all high-resolution images, interactive features, and complete inspection details.
            </span>
        </div>
    </div>
</body>
</html>