<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Inspection Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background-color: #4f959b;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .vehicle-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #4f959b;
        }
        
        .vehicle-info h3 {
            margin-top: 0;
            color: #4f959b;
        }
        
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .attachment-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #4f959b;
            margin: 20px 0;
        }
        
        .attachment-info h3 {
            color: #4f959b;
            margin-top: 0;
        }
        
        ul {
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ALPHA Vehicle Inspection</h1>
        <p>Professional Vehicle Assessment Report</p>
    </div>

    <div class="content">
        @if($customMessage)
            <h2>Personal Message</h2>
            <p>{{ $customMessage }}</p>
        @else
            <h2>Dear {{ $inspectionData['client']['name'] ?? 'Valued Client' }},</h2>
            <p>Thank you for choosing ALPHA Vehicle Inspection services. We have completed the comprehensive inspection of your vehicle and are pleased to provide you with the detailed report.</p>
        @endif

        <div class="vehicle-info">
            <h3>Vehicle Details</h3>
            <ul>
                <li><strong>Make & Model:</strong> {{ $inspectionData['vehicle']['make'] ?? 'Not specified' }} {{ $inspectionData['vehicle']['model'] ?? '' }}</li>
                <li><strong>Year:</strong> {{ $inspectionData['vehicle']['year'] ?? 'Not specified' }}</li>
                <li><strong>VIN:</strong> {{ $inspectionData['vehicle']['vin'] ?? 'Not specified' }}</li>
                <li><strong>Mileage:</strong> {{ $inspectionData['vehicle']['mileage'] ?? 'Not specified' }} km</li>
                <li><strong>License Plate:</strong> {{ $inspectionData['vehicle']['license_plate'] ?? 'Not specified' }}</li>
            </ul>
        </div>

        <div class="vehicle-info">
            <h3>Inspection Details</h3>
            <ul>
                <li><strong>Inspection Date:</strong> {{ $inspectionData['inspection']['date'] ?? 'Not specified' }}</li>
                <li><strong>Inspector:</strong> {{ $inspectionData['inspection']['inspector'] ?? 'Not specified' }}</li>
                <li><strong>Report Generated:</strong> {{ $inspectionData['generated_at'] ?? date('Y-m-d H:i:s') }}</li>
            </ul>
        </div>

        <div class="attachment-info">
            <h3>📎 Attached Report</h3>
            <p>Your complete vehicle inspection report is attached to this email as a PDF document. The report includes:</p>
            <ul>
                <li>Complete vehicle and client information</li>
                <li>Body panel assessment with condition ratings</li>
                <li>Interior component evaluation</li>
                <li>Tyres and rims detailed analysis</li>
                <li>Comprehensive mechanical report</li>
                <li>Service history documentation</li>
                <li>Professional recommendations</li>
            </ul>
        </div>

        <h3>What's Next?</h3>
        <p>Please review the attached report carefully. If you have any questions about the findings or need clarification on any aspect of the inspection, please don't hesitate to contact us.</p>

        @if(!empty($inspectionData['inspection']['notes']))
        <div class="vehicle-info">
            <h3>Inspector's Additional Notes</h3>
            <p>{{ $inspectionData['inspection']['notes'] }}</p>
        </div>
        @endif

        <p>Thank you for trusting ALPHA Vehicle Inspection with your vehicle assessment needs. We appreciate your business and look forward to serving you again in the future.</p>

        <p><strong>Best regards,</strong><br>
        The ALPHA Vehicle Inspection Team</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} ALPHA Vehicle Inspection. All rights reserved.</p>
        <p>This email was sent regarding the inspection completed on {{ $inspectionData['inspection']['date'] ?? date('Y-m-d') }}</p>
        <p>If you did not request this inspection report, please contact us immediately.</p>
    </div>
</body>
</html>