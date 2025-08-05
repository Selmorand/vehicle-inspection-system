<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Inspection Report</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4f959b;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4f959b;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            color: #4f959b;
            font-size: 16px;
            font-weight: bold;
            border-bottom: 2px solid #4f959b;
            padding-bottom: 5px;
            margin-bottom: 15px;
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
            padding: 5px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .info-label {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
        }
        
        .assessment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .assessment-table th,
        .assessment-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .assessment-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #4f959b;
        }
        
        .condition-good {
            background-color: #d4edda;
            color: #155724;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .condition-average {
            background-color: #fff3cd;
            color: #856404;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .condition-bad {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .summary-box {
            background-color: #f8f9fa;
            border: 2px solid #4f959b;
            padding: 15px;
            border-radius: 5px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 5px;
        }
        
        .image-section {
            margin-bottom: 20px;
        }
        
        .image-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .image-row {
            display: table-row;
        }
        
        .image-cell {
            display: table-cell;
            padding: 10px;
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
        
        .inspection-image {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .image-caption {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>ALPHA VEHICLE INSPECTION</h1>
        <p>Professional Vehicle Assessment Report</p>
        <p>Generated: {{ $inspectionData['generated_at'] ?? date('Y-m-d H:i:s') }}</p>
    </div>

    <!-- Client & Vehicle Information -->
    <div class="section">
        <h2 class="section-title">Vehicle & Client Information</h2>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Client Name</div>
                <div class="info-cell">{{ $inspectionData['client']['name'] ?? 'Not specified' }}</div>
                <div class="info-cell info-label">Contact Number</div>
                <div class="info-cell">{{ $inspectionData['client']['contact'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Email</div>
                <div class="info-cell">{{ $inspectionData['client']['email'] ?? 'Not specified' }}</div>
                <div class="info-cell info-label">Inspection Date</div>
                <div class="info-cell">{{ $inspectionData['inspection']['date'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Vehicle Make</div>
                <div class="info-cell">{{ $inspectionData['vehicle']['make'] ?? 'Not specified' }}</div>
                <div class="info-cell info-label">Vehicle Model</div>
                <div class="info-cell">{{ $inspectionData['vehicle']['model'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Year</div>
                <div class="info-cell">{{ $inspectionData['vehicle']['year'] ?? 'Not specified' }}</div>
                <div class="info-cell info-label">Mileage</div>
                <div class="info-cell">{{ $inspectionData['vehicle']['mileage'] ?? 'Not specified' }} km</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">VIN Number</div>
                <div class="info-cell">{{ $inspectionData['vehicle']['vin'] ?? 'Not specified' }}</div>
                <div class="info-cell info-label">License Plate</div>
                <div class="info-cell">{{ $inspectionData['vehicle']['license_plate'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Inspector</div>
                <div class="info-cell" colspan="3">{{ $inspectionData['inspection']['inspector'] ?? 'Not specified' }}</div>
            </div>
        </div>
    </div>

    <!-- Visual Inspection Images -->
    @if(!empty($inspectionData['images']['visual']))
    <div class="section page-break">
        <h2 class="section-title">Visual Inspection Images</h2>
        <div class="image-section">
            <div class="image-grid">
                @foreach(array_chunk($inspectionData['images']['visual'], 2) as $imageRow)
                <div class="image-row">
                    @foreach($imageRow as $image)
                    <div class="image-cell">
                        <img src="data:{{ $image['mime_type'] ?? 'image/jpeg' }};base64,{{ $image['base64'] }}" 
                             class="inspection-image" alt="{{ $image['area_name'] ?? 'Visual inspection image' }}">
                        <div class="image-caption">{{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Visual inspection')) }}</div>
                    </div>
                    @endforeach
                    @if(count($imageRow) == 1)
                    <div class="image-cell"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Body Panel Assessment -->
    @if(!empty($inspectionData['body_panels']['assessments']))
    <div class="section">
        <h2 class="section-title">Body Panel Assessment</h2>
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
                    <td>{{ ucwords(str_replace('-', ' ', $panel)) }}</td>
                    <td>
                        <span class="condition-{{ $assessment['condition'] ?? 'good' }}">
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
    @endif

    <!-- Specific Area Images -->
    @if(!empty($inspectionData['images']['specific_areas']))
    <div class="section">
        <h2 class="section-title">Specific Area Images</h2>
        <div class="image-section">
            <div class="image-grid">
                @foreach(array_chunk($inspectionData['images']['specific_areas'], 2) as $imageRow)
                <div class="image-row">
                    @foreach($imageRow as $image)
                    <div class="image-cell">
                        <img src="data:{{ $image['mime_type'] ?? 'image/jpeg' }};base64,{{ $image['base64'] }}" 
                             class="inspection-image" alt="{{ $image['area_name'] ?? 'Specific area image' }}">
                        <div class="image-caption">{{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Specific area')) }}</div>
                    </div>
                    @endforeach
                    @if(count($imageRow) == 1)
                    <div class="image-cell"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Interior Assessment -->
    @if(!empty($inspectionData['interior']['assessments']))
    <div class="section">
        <h2 class="section-title">Interior Assessment</h2>
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
                    <td>{{ ucwords(str_replace('-', ' ', $component)) }}</td>
                    <td>{{ ucfirst($assessment['colour'] ?? '-') }}</td>
                    <td>
                        <span class="condition-{{ $assessment['condition'] ?? 'good' }}">
                            {{ ucfirst($assessment['condition'] ?? 'Good') }}
                        </span>
                    </td>
                    <td>{{ $assessment['comment'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Interior Images -->
    @if(!empty($inspectionData['images']['interior']))
    <div class="section">
        <h2 class="section-title">Interior Images</h2>
        <div class="image-section">
            <div class="image-grid">
                @foreach(array_chunk($inspectionData['images']['interior'], 2) as $imageRow)
                <div class="image-row">
                    @foreach($imageRow as $image)
                    <div class="image-cell">
                        <img src="data:{{ $image['mime_type'] ?? 'image/jpeg' }};base64,{{ $image['base64'] }}" 
                             class="inspection-image" alt="{{ $image['area_name'] ?? 'Interior image' }}">
                        <div class="image-caption">{{ ucwords(str_replace('_', ' ', $image['area_name'] ?? 'Interior')) }}</div>
                    </div>
                    @endforeach
                    @if(count($imageRow) == 1)
                    <div class="image-cell"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Tyres & Rims Assessment -->
    @if(!empty($inspectionData['tyres']))
    <div class="section page-break">
        <h2 class="section-title">Tyres & Rims Assessment</h2>
        
        <h3>Tyres</h3>
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
                        <td>{{ $label }}</td>
                        <td>{{ $inspectionData['tyres'][$pos]['brand'] ?? '-' }}</td>
                        <td>{{ $inspectionData['tyres'][$pos]['size'] ?? '-' }}</td>
                        <td>{{ $inspectionData['tyres'][$pos]['tread_depth'] ?? '-' }}mm</td>
                        <td>
                            <span class="condition-{{ $inspectionData['tyres'][$pos]['condition'] ?? 'good' }}">
                                {{ ucfirst($inspectionData['tyres'][$pos]['condition'] ?? 'Good') }}
                            </span>
                        </td>
                        <td>{{ $inspectionData['tyres'][$pos]['notes'] ?? '-' }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        @if(!empty($inspectionData['tyres']['spare']))
        <h3>Spare Tyre</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Type</div>
                <div class="info-cell">{{ $inspectionData['tyres']['spare']['type'] ?? '-' }}</div>
                <div class="info-cell info-label">Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ $inspectionData['tyres']['spare']['condition'] ?? 'good' }}">
                        {{ ucfirst($inspectionData['tyres']['spare']['condition'] ?? 'Good') }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Notes</div>
                <div class="info-cell" colspan="3">{{ $inspectionData['tyres']['spare']['notes'] ?? '-' }}</div>
            </div>
        </div>
        @endif

        @if(!empty($inspectionData['rims']))
        <h3>Rims</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Type</div>
                <div class="info-cell">{{ $inspectionData['rims']['type'] ?? '-' }}</div>
                <div class="info-cell info-label">Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ $inspectionData['rims']['condition'] ?? 'good' }}">
                        {{ ucfirst($inspectionData['rims']['condition'] ?? 'Good') }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Notes</div>
                <div class="info-cell" colspan="3">{{ $inspectionData['rims']['notes'] ?? '-' }}</div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Mechanical Report -->
    @if(!empty($inspectionData['mechanical']))
    <div class="section">
        <h2 class="section-title">Mechanical Report</h2>
        
        <h3>Engine Performance</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Engine Startup</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['engine_startup'] ?? '-' }}</div>
                <div class="info-cell info-label">Idling Quality</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['idling_quality'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Acceleration</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['acceleration'] ?? '-' }}</div>
                <div class="info-cell info-label">Engine Noises</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['engine_noises'] ?? '-' }}</div>
            </div>
        </div>

        <h3>Fluid Levels</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Oil Level</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['oil_level'] ?? '-' }}</div>
                <div class="info-cell info-label">Coolant Level</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['coolant_level'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Brake Fluid</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['brake_fluid'] ?? '-' }}</div>
                <div class="info-cell info-label">Power Steering</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['power_steering_fluid'] ?? '-' }}</div>
            </div>
        </div>

        <h3>Brakes</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Performance</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['brake_performance'] ?? '-' }}</div>
                <div class="info-cell info-label">Pad Thickness (Front)</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['brake_pad_thickness_front'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Pad Thickness (Rear)</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['brake_pad_thickness_rear'] ?? '-' }}</div>
                <div class="info-cell info-label">Transmission</div>
                <div class="info-cell">{{ $inspectionData['mechanical']['transmission_type'] ?? '-' }}</div>
            </div>
        </div>

        @if(!empty($inspectionData['mechanical']['notes']))
        <h3>Additional Notes</h3>
        <p>{{ $inspectionData['mechanical']['notes'] }}</p>
        @endif
    </div>
    @endif

    <!-- Engine Compartment Assessment -->
    @if(!empty($inspectionData['engine_compartment']))
    <div class="section page-break">
        <h2 class="section-title">Engine Compartment Assessment</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Overall Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['engine_compartment']['overall_condition'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['engine_compartment']['overall_condition'] ?? 'Good') }}
                    </span>
                </div>
                <div class="info-cell info-label">Oil Leaks</div>
                <div class="info-cell">{{ ucfirst($inspectionData['engine_compartment']['oil_leaks'] ?? 'None') }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Coolant Leaks</div>
                <div class="info-cell">{{ ucfirst($inspectionData['engine_compartment']['coolant_leaks'] ?? 'None') }}</div>
                <div class="info-cell info-label">Belt Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['engine_compartment']['belt_condition'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['engine_compartment']['belt_condition'] ?? 'Good') }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Battery Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['engine_compartment']['battery_condition'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['engine_compartment']['battery_condition'] ?? 'Good') }}
                    </span>
                </div>
                <div class="info-cell info-label">Battery Age</div>
                <div class="info-cell">{{ $inspectionData['engine_compartment']['battery_age'] ?? '-' }}</div>
            </div>
        </div>
        
        @if(!empty($inspectionData['engine_compartment']['notes']))
        <h3>Engine Compartment Notes</h3>
        <p>{{ $inspectionData['engine_compartment']['notes'] }}</p>
        @endif
    </div>
    @endif

    <!-- Physical Hoist Inspection -->
    @if(!empty($inspectionData['physical_hoist']))
    <div class="section">
        <h2 class="section-title">Physical Hoist Inspection (Undercarriage)</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Undercarriage Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['physical_hoist']['undercarriage_condition'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['physical_hoist']['undercarriage_condition'] ?? 'Good') }}
                    </span>
                </div>
                <div class="info-cell info-label">Rust Present</div>
                <div class="info-cell">{{ ucfirst($inspectionData['physical_hoist']['rust_present'] ?? 'No') }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Exhaust Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['physical_hoist']['exhaust_condition'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['physical_hoist']['exhaust_condition'] ?? 'Good') }}
                    </span>
                </div>
                <div class="info-cell info-label">Suspension Condition</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['physical_hoist']['suspension_condition'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['physical_hoist']['suspension_condition'] ?? 'Good') }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Brake Lines</div>
                <div class="info-cell">
                    <span class="condition-{{ strtolower($inspectionData['physical_hoist']['brake_lines'] ?? 'good') }}">
                        {{ ucfirst($inspectionData['physical_hoist']['brake_lines'] ?? 'Good') }}
                    </span>
                </div>
                <div class="info-cell info-label"></div>
                <div class="info-cell"></div>
            </div>
        </div>
        
        @if(!empty($inspectionData['physical_hoist']['notes']))
        <h3>Hoist Inspection Notes</h3>
        <p>{{ $inspectionData['physical_hoist']['notes'] }}</p>
        @endif
    </div>
    @endif

    <!-- Service History -->
    @if(!empty($inspectionData['service']))
    <div class="section page-break">
        <h2 class="section-title">Service History</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Service History Available</div>
                <div class="info-cell">{{ ucfirst($inspectionData['service']['has_history'] ?? 'No') }}</div>
                <div class="info-cell info-label">Last Service Date</div>
                <div class="info-cell">{{ $inspectionData['service']['last_service_date'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Last Service Mileage</div>
                <div class="info-cell">{{ $inspectionData['service']['last_service_mileage'] ?? '-' }} km</div>
                <div class="info-cell info-label">Service Provider</div>
                <div class="info-cell">{{ $inspectionData['service']['service_provider'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Next Service Due</div>
                <div class="info-cell" colspan="3">{{ $inspectionData['service']['next_service_due'] ?? '-' }}</div>
            </div>
        </div>
        
        @if(!empty($inspectionData['service']['notes']))
        <h3>Service Notes</h3>
        <p>{{ $inspectionData['service']['notes'] }}</p>
        @endif
    </div>
    @endif

    <!-- Summary & Recommendations -->
    <div class="section">
        <h2 class="section-title">Inspection Summary</h2>
        <div class="summary-box">
            <h3>Overall Assessment</h3>
            <p>This vehicle inspection has been completed according to professional standards. All accessible components have been assessed for condition, safety, and functionality.</p>
            
            @if(!empty($inspectionData['inspection']['notes']))
            <h3>Inspector Notes</h3>
            <p>{{ $inspectionData['inspection']['notes'] }}</p>
            @endif
            
            <h3>Report Validity</h3>
            <p>This report is confidential and intended solely for the use of the client named above. The inspection was conducted on {{ $inspectionData['inspection']['date'] ?? 'the specified date' }} and reflects the vehicle's condition at that time.</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} ALPHA Vehicle Inspection. All rights reserved.</p>
        <p>This report was generated on {{ $inspectionData['generated_at'] ?? date('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>