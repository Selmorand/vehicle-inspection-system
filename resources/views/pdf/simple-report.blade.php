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
            margin: 20px 0 15px 0;
            /* Force section headers to start new pages when insufficient space */
            page-break-before: auto;
            break-before: auto;
            /* Prevent any breaks within or immediately after headers */
            page-break-after: avoid;
            break-after: avoid;
            page-break-inside: avoid;
            break-inside: avoid;
            /* Require substantial following content or move entire section to next page */
            orphans: 8;
            widows: 8;
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
        
        /* Compact two-column layout for vehicle information */
        .compact-info {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        
        .compact-row {
            display: table-row;
        }
        
        .compact-cell {
            display: table-cell;
            padding: 3px 8px 3px 0;
            vertical-align: top;
            width: 50%;
            font-size: 10px;
            line-height: 1.3;
        }
        
        .compact-label {
            font-weight: bold;
            display: inline;
        }
        
        .compact-value {
            display: inline;
            margin-left: 5px;
        }
        
        /* Additional page break prevention */
        .panel-body {
            page-break-inside: avoid;
            break-inside: avoid;
            orphans: 3;
            widows: 3;
        }
        
        /* Ensure sections have enough space - prevent orphaned headings */
        .section-title + * {
            page-break-before: avoid;
            break-before: avoid;
        }
        
        /* Aggressive orphan prevention - force sections to new pages when needed */
        .section-title {
            /* If less than 150px available after header, start new page */
            page-break-after: avoid !important;
            break-after: avoid !important;
            /* mPDF specific: require minimum space or move to new page */
            min-height: 100px;
        }
        
        /* Ensure substantial content follows section headers */
        .section-title + .panel-card,
        .section-title + div {
            page-break-before: avoid !important;
            break-before: avoid !important;
            /* Require this content to have adequate space too */
            min-height: 80px;
        }
        
        
        
        /* Better spacing for compact sections */
        .compact-info {
            page-break-inside: avoid;
            break-inside: avoid;
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
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .panel-header {
            background-color: #f8f9fa;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
            page-break-after: avoid;
            break-after: avoid;
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
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .image-container {
            display: inline-block;
            margin: 5px;
            text-align: center;
            page-break-inside: avoid;
            break-inside: avoid;
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
    <div class="compact-info">
        <div class="compact-row">
            <div class="compact-cell">
                <span class="compact-label">Make/Model/Year:</span>
                <span class="compact-value">{{ ($inspectionData['vehicle']['make'] ?? 'N/A') . ' ' . ($inspectionData['vehicle']['model'] ?? '') . ' ' . ($inspectionData['vehicle']['year'] ?? '') }}</span>
            </div>
            <div class="compact-cell">
                <span class="compact-label">VIN:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['vin'] ?? 'Not specified' }}</span>
            </div>
        </div>
        <div class="compact-row">
            <div class="compact-cell">
                <span class="compact-label">License Plate:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['license_plate'] ?? 'Not specified' }}</span>
            </div>
            <div class="compact-cell">
                <span class="compact-label">Mileage:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['mileage'] ?? 'Not specified' }} km</span>
            </div>
        </div>
        <div class="compact-row">
            <div class="compact-cell">
                <span class="compact-label">Vehicle Type:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['vehicle_type'] ?? 'Not specified' }}</span>
            </div>
            <div class="compact-cell">
                <span class="compact-label">Engine Number:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['engine_number'] ?? 'Not specified' }}</span>
            </div>
        </div>
        <div class="compact-row">
            <div class="compact-cell">
                <span class="compact-label">Colour:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['colour'] ?? 'Not specified' }}</span>
            </div>
            <div class="compact-cell">
                <span class="compact-label">Fuel Type:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['fuel_type'] ?? 'Not specified' }}</span>
            </div>
        </div>
        <div class="compact-row">
            <div class="compact-cell">
                <span class="compact-label">Transmission:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['transmission'] ?? 'Not specified' }}</span>
            </div>
            <div class="compact-cell">
                <span class="compact-label">Doors:</span>
                <span class="compact-value">{{ $inspectionData['vehicle']['doors'] ?? 'Not specified' }}</span>
            </div>
        </div>
        <div class="compact-row">
            <div class="compact-cell">
                <span class="compact-label">Inspector:</span>
                <span class="compact-value">{{ $inspectionData['inspection']['inspector'] ?? 'Not specified' }}</span>
            </div>
            <div class="compact-cell">
                <span class="compact-label">Inspection Date:</span>
                <span class="compact-value">{{ $inspectionData['inspection']['date'] ?? 'Not specified' }}</span>
            </div>
        </div>
    </div>

    <!-- Visual Inspection Images -->
    @if(!empty($inspectionData['images']['visual']) && count($inspectionData['images']['visual']) > 0)
    <div style="page-break-before: auto;"></div>
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
    <div style="page-break-before: auto;"></div>
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
    <!-- Force page break before major sections that are likely to be long -->
    @php
        $bodyPanelCount = is_array($validBodyPanels) ? count($validBodyPanels) : 0;
    @endphp
    @if($bodyPanelCount > 3)
    <div style="page-break-before: always;"></div>
    @endif
    <div class="section-title">Body Panel Assessment</div>
    
    <!-- Vehicle Diagram -->
    <div style="text-align: center; margin: 20px 0; page-break-inside: avoid;">
        @php
            $vehicleDiagramPath = public_path('images/panels/FullVehicle.png');
            $vehicleDiagramExists = file_exists($vehicleDiagramPath);
        @endphp
        @if($vehicleDiagramExists)
        <img src="{{ $vehicleDiagramPath }}" alt="Vehicle Body Panels" style="max-width: 600px; width: 100%; height: auto; border: 1px solid #ddd;">
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
    @php
        $interiorCount = is_array($validInteriorComponents) ? count($validInteriorComponents) : 0;
    @endphp
    @if($interiorCount > 3)
    <div style="page-break-before: always;"></div>
    @endif
    <div class="section-title">Interior Assessment</div>
    
    <!-- Interior Diagram -->
    <div style="text-align: center; margin: 20px 0; page-break-inside: avoid;">
        @php
            $interiorDiagramPath = public_path('images/interior/interiorMain.png');
            $interiorDiagramExists = file_exists($interiorDiagramPath);
        @endphp
        @if($interiorDiagramExists)
        <img src="{{ $interiorDiagramPath }}" alt="Vehicle Interior" style="max-width: 600px; width: 100%; height: auto; border: 1px solid #ddd;">
        @endif
        
        <!-- Interior Condition Legend -->
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
    @php
        $mechanicalCount = is_array($validMechanicalComponents) ? count($validMechanicalComponents) : 0;
    @endphp
    @if($mechanicalCount > 2)
    <div style="page-break-before: always;"></div>
    @endif
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

    <!-- Braking System Assessment -->
    @php
        $validBrakePositions = [];
        if (!empty($inspectionData['braking_system']) && is_array($inspectionData['braking_system'])) {
            foreach ($inspectionData['braking_system'] as $brake) {
                // Check each field individually - be more permissive with data checking
                $hasPadLife = isset($brake['pad_life']) && $brake['pad_life'] !== '' && $brake['pad_life'] !== null;
                $hasPadCondition = isset($brake['pad_condition']) && $brake['pad_condition'] !== '' && $brake['pad_condition'] !== null && $brake['pad_condition'] !== 'not_assessed';
                $hasDiscLife = isset($brake['disc_life']) && $brake['disc_life'] !== '' && $brake['disc_life'] !== null;
                $hasDiscCondition = isset($brake['disc_condition']) && $brake['disc_condition'] !== '' && $brake['disc_condition'] !== null && $brake['disc_condition'] !== 'not_assessed';
                $hasComments = isset($brake['comments']) && $brake['comments'] !== '' && $brake['comments'] !== null;
                $hasImages = !empty($brake['images']) && is_array($brake['images']) && count($brake['images']) > 0;
                
                if ($hasPadLife || $hasPadCondition || $hasDiscLife || $hasDiscCondition || $hasComments || $hasImages) {
                    $validBrakePositions[] = $brake;
                }
            }
        }
    @endphp
    
    @if(!empty($validBrakePositions))
    @php
        $brakeCount = is_array($validBrakePositions) ? count($validBrakePositions) : 0;
    @endphp
    @if($brakeCount > 2)
    <div style="page-break-before: always;"></div>
    @endif
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

    <!-- Road Test Information -->
    @if(!empty($inspectionData['mechanical_report']['road_test']))
    <div style="page-break-before: auto;"></div>
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
    <div style="page-break-before: auto;"></div>
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
    @php
        $tyreCount = is_array($validTyres) ? count($validTyres) : 0;
    @endphp
    @if($tyreCount > 2)
    <div style="page-break-before: always;"></div>
    @endif
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

    <!-- Engine Compartment Assessment -->
    @if(!empty($inspectionData['engine_compartment']))
    <div style="page-break-before: auto;"></div>
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
    @php
        $hoistCount = is_array($validHoistSections) ? count($validHoistSections) : 0;
    @endphp
    @if($hoistCount > 1)
    <div style="page-break-before: always;"></div>
    @endif
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
    <div style="page-break-before: auto;"></div>
    <div class="section-title">Inspector Notes</div>
    <div class="panel-body">
        {{ $inspectionData['inspection']['notes'] }}
    </div>
    @endif

    <!-- Summary -->
    <div style="page-break-before: auto;"></div>
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