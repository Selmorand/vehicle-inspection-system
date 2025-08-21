<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Under Construction - Alpha Inspections</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #4f959b 0%, #28a745 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .maintenance-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            padding: 60px 40px;
            text-align: center;
        }
        .logo {
            width: 150px;
            height: 150px;
            margin: 0 auto 30px;
            background: #4f959b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            font-weight: bold;
        }
        h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .subtitle {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .progress-bar {
            background: #f0f0f0;
            border-radius: 50px;
            height: 10px;
            overflow: hidden;
            margin: 40px 0;
        }
        .progress-fill {
            background: linear-gradient(90deg, #4f959b, #28a745);
            height: 100%;
            width: 75%;
            border-radius: 50px;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .message {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }
        .message h3 {
            color: #4f959b;
            margin-bottom: 10px;
        }
        .message p {
            color: #666;
            line-height: 1.5;
        }
        .contact {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
            color: #999;
            font-size: 14px;
        }
        .contact a {
            color: #4f959b;
            text-decoration: none;
        }
        .contact a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="logo">AI</div>
        
        <h1>Site Under Construction</h1>
        
        <p class="subtitle">
            We're currently building something amazing!<br>
            Our new vehicle inspection system will be available soon.
        </p>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <div class="message">
            <h3>What's Coming?</h3>
            <p>
                A comprehensive digital vehicle inspection platform designed for 
                professional inspectors, featuring real-time reporting, photo documentation, 
                and instant PDF generation.
            </p>
        </div>
        
        <div class="contact">
            <p>Need immediate assistance?</p>
            <p>Contact us at <a href="mailto:info@alphainspections.co.za">info@alphainspections.co.za</a></p>
        </div>
    </div>
</body>
</html>