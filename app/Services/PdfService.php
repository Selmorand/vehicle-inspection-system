<?php

namespace App\Services;

use Mpdf\Mpdf;
use App\Services\ImageService;
use Spatie\Browsershot\Browsershot;

class PdfService
{
    public function generatePdf($html, $filename = 'report.pdf', $outputMode = 'I')
    {
        // Pre-process HTML to convert asset URLs to file paths for images
        $html = $this->processImagesForPdf($html);
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 10,
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'tempDir' => storage_path('app/temp'),
            'allow_output_buffering' => true,
            'shrink_tables_to_fit' => 1,
            'use_kwt' => true, // Keep with table
            'packTableData' => true,
            'img_dpi' => 96,
            'showImageErrors' => false,
            'curlAllowUnsafeSslRequests' => true,
            'allow_charset_conversion' => true
        ]);
        
        // Set memory and time limits for large documents
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        
        // Enable image debugging in development
        if (config('app.debug')) {
            $mpdf->showImageErrors = true;
        }
        
        $mpdf->WriteHTML($html);
        
        return $mpdf->Output($filename, $outputMode); // I = display inline, F = save to file, S = return as string
    }
    
    /**
     * Generate and save PDF to disk
     * Returns the file path if successful, null otherwise
     */
    public function generateAndSavePdf($html, $filename = 'report.pdf', $directory = 'reports')
    {
        try {
            // Ensure the directory exists
            $fullDirectory = storage_path('app/public/' . $directory);
            if (!file_exists($fullDirectory)) {
                mkdir($fullDirectory, 0755, true);
            }
            
            // Generate unique filename if needed
            $timestamp = date('Y-m-d_H-i-s');
            $uniqueFilename = pathinfo($filename, PATHINFO_FILENAME) . '_' . $timestamp . '.pdf';
            $fullPath = $fullDirectory . '/' . $uniqueFilename;
            
            // Generate PDF and save to file
            $this->generatePdf($html, $fullPath, 'F');
            
            // Return relative path for storage
            return $directory . '/' . $uniqueFilename;
            
        } catch (\Exception $e) {
            \Log::error('Failed to save PDF: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Process images in HTML to convert URLs to file paths and create thumbnails
     */
    public function processImagesForPdf($html)
    {
        $imageService = new ImageService();
        
        // Convert storage URLs to thumbnail file paths
        $pattern = '/src="([^"]*storage[^"]+)"/i';
        
        $html = preg_replace_callback($pattern, function($matches) use ($imageService) {
            $url = $matches[1];
            
            // Extract the path after /storage/
            if (preg_match('/\/storage\/(.+)$/i', $url, $pathMatches)) {
                $relativePath = $pathMatches[1];
                $filePath = storage_path('app/public/' . $relativePath);
                
                // Check if file exists
                if (file_exists($filePath)) {
                    // Get or create thumbnail
                    $thumbnailPath = $imageService->getThumbnailForPdf($filePath, 150, 150);
                    
                    if ($thumbnailPath) {
                        return 'src="' . $thumbnailPath . '"';
                    }
                    
                    // Fallback to original if thumbnail creation fails
                    return 'src="' . $filePath . '"';
                }
            }
            
            // If not a storage URL or file doesn't exist, return original
            return $matches[0];
        }, $html);
        
        return $html;
    }
    
    /**
     * Capture a screenshot of a vehicle diagram from inspection data
     */
    public function captureVehicleDiagram($inspectionData, $diagramType = 'body-panel')
    {
        try {
            // Check if Browsershot dependencies are available
            if (!class_exists('Spatie\Browsershot\Browsershot')) {
                \Log::warning("Browsershot not available, skipping screenshot generation");
                return null;
            }
            
            $screenshotPath = storage_path("app/temp/diagram_" . uniqid() . "_{$diagramType}.png");
            
            // Ensure temp directory exists
            if (!file_exists(dirname($screenshotPath))) {
                mkdir(dirname($screenshotPath), 0755, true);
            }
            
            // Create standalone HTML for the diagram
            $htmlContent = $this->generateDiagramHtml($inspectionData, $diagramType);
            $tempHtmlPath = storage_path("app/temp/diagram_" . uniqid() . ".html");
            file_put_contents($tempHtmlPath, $htmlContent);
            
            // Set paths for Windows environment
            $chromePath = 'C:\\Users\\GeorgeWhiteside\\.cache\\puppeteer\\chrome\\win64-139.0.7258.138\\chrome-win64\\chrome.exe';
            
            // Create screenshot from the HTML file
            $browsershot = Browsershot::html($htmlContent)
                ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage'])
                ->windowSize(800, 600)
                ->waitUntilNetworkIdle(false)
                ->timeout(30);
            
            // Set Chrome path
            if (file_exists($chromePath)) {
                $browsershot->setChromePath($chromePath);
            }
            
            // On Windows, we don't need to set Node/NPM paths if they're in PATH
            
            $browsershot->save($screenshotPath);
            
            // Clean up temp HTML file
            if (file_exists($tempHtmlPath)) {
                unlink($tempHtmlPath);
            }
            
            return $screenshotPath;
        } catch (\Exception $e) {
            // Log error with more details
            \Log::error("Vehicle diagram screenshot failed for {$diagramType}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return null;
        }
    }
    
    /**
     * Generate standalone HTML for vehicle diagram
     */
    private function generateDiagramHtml($inspectionData, $diagramType)
    {
        $baseUrl = url('/');
        
        if ($diagramType === 'body-panel') {
            return $this->generateBodyPanelDiagramHtml($inspectionData, $baseUrl);
        } else {
            return $this->generateInteriorDiagramHtml($inspectionData, $baseUrl);
        }
    }
    
    /**
     * Generate HTML for body panel diagram with overlays
     */
    private function generateBodyPanelDiagramHtml($inspectionData, $baseUrl)
    {
        // Get body panels data
        $bodyPanels = $inspectionData['body_panels'] ?? [];
        
        // Use file path instead of URL for the base image
        $vehicleImagePath = public_path('images/panels/FullVehicle.png');
        $vehicleImageData = '';
        
        // Convert image to base64 data URL
        if (file_exists($vehicleImagePath)) {
            $imageContent = file_get_contents($vehicleImagePath);
            $vehicleImageData = 'data:image/png;base64,' . base64_encode($imageContent);
        }
        
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { margin: 0; padding: 20px; background: white; font-family: Arial, sans-serif; }
        .vehicle-diagram-container { position: relative; display: inline-block; max-width: 600px; width: 100%; }
        .layer-base { width: 100%; height: auto; display: block; }
        .panel-overlay { 
            position: absolute; 
            pointer-events: none;
        }
        .panel-overlay.condition-good { 
            background-color: rgba(40, 167, 69, 0.8);
        }
        .panel-overlay.condition-average { 
            background-color: rgba(255, 193, 7, 0.8);
        }
        .panel-overlay.condition-poor { 
            background-color: rgba(220, 53, 69, 0.8);
        }
    </style>
</head>
<body>
    <div class="vehicle-diagram-container">
        <img src="' . $vehicleImageData . '" alt="Vehicle Base" class="layer-base">
        ' . $this->generateBodyPanelOverlays($bodyPanels, $baseUrl) . '
    </div>
</body>
</html>';
    }
    
    /**
     * Generate body panel overlays HTML
     */
    private function generateBodyPanelOverlays($bodyPanels, $baseUrl)
    {
        $allPanels = [
            ['id' => 'fr-fender', 'style' => 'left: 61.89%; top: 6.21%; width: 31.84%; height: 16.26%;', 'image' => 'fr-fender.png'],
            ['id' => 'fr-door', 'style' => 'left: 44.08%; top: 2.22%; width: 22.89%; height: 15.67%;', 'image' => 'fr-door.png'],
            ['id' => 'rf-rim', 'style' => 'left: 70.95%; top: 13.38%; width: 10.45%; height: 7.32%;', 'image' => 'rf-rim.png'],
            ['id' => 'rr-door', 'style' => 'left: 26.47%; top: 2.07%; width: 20.80%; height: 16.56%;', 'image' => 'rr-door.png'],
            ['id' => 'rr-rim', 'style' => 'left: 19.30%; top: 13.38%; width: 10.45%; height: 7.32%;', 'image' => 'rr-rim.png'],
            ['id' => 'rr-quarter-panel', 'style' => 'left: 5.57%; top: 7.54%; width: 26.97%; height: 10.42%;', 'image' => 'rr-quarter-panel.png'],
            ['id' => 'bonnet', 'style' => 'left: 68.06%; top: 24.32%; width: 26.97%; height: 24.83%;', 'image' => 'bonnet.png'],
            ['id' => 'windscreen', 'style' => 'left: 57.31%; top: 25.87%; width: 14.63%; height: 20.62%;', 'image' => 'windscreen.png'],
            ['id' => 'roof', 'style' => 'left: 29.75%; top: 28.09%; width: 28.16%; height: 16.34%;', 'image' => 'roof.png'],
            ['id' => 'rear-window', 'style' => 'left: 15.82%; top: 27.20%; width: 15.62%; height: 18.48%;', 'image' => 'rear-window.png'],
            ['id' => 'boot', 'style' => 'left: 7.26%; top: 26.83%; width: 14.03%; height: 19.73%;', 'image' => 'boot.png'],
            ['id' => 'lf-fender', 'style' => 'left: 5.87%; top: 56.91%; width: 31.84%; height: 16.26%;', 'image' => 'lf-fender.png'],
            ['id' => 'lf-door', 'style' => 'left: 32.64%; top: 52.85%; width: 22.99%; height: 15.67%;', 'image' => 'lf-door.png'],
            ['id' => 'lf-rim', 'style' => 'left: 18.11%; top: 64.01%; width: 10.45%; height: 7.32%;', 'image' => 'lf-rim.png'],
            ['id' => 'lr-door', 'style' => 'left: 52.34%; top: 52.62%; width: 20.60%; height: 16.56%;', 'image' => 'lr-door.png'],
            ['id' => 'lr-rim', 'style' => 'left: 69.75%; top: 64.01%; width: 10.45%; height: 7.32%;', 'image' => 'lr-rim.png'],
            ['id' => 'lr-quarter-panel', 'style' => 'left: 67.06%; top: 58.24%; width: 26.97%; height: 10.35%;', 'image' => 'lr-quarter-panel.png'],
            ['id' => 'front-bumper', 'style' => 'left: 4.18%; top: 87.21%; width: 37.21%; height: 6.28%;', 'image' => 'front-bumper.png'],
            ['id' => 'lf-headlight', 'style' => 'left: 29.35%; top: 85.37%; width: 9.15%; height: 2.51%;', 'image' => 'lf-headlight.png'],
            ['id' => 'fr-headlight', 'style' => 'left: 6.97%; top: 85.37%; width: 9.05%; height: 2.51%;', 'image' => 'fr-headlight.png'],
            ['id' => 'fr-mirror', 'style' => 'left: 3.98%; top: 80.93%; width: 4.78%; height: 2.36%;', 'image' => 'fr-mirror.png'],
            ['id' => 'lf-mirror', 'style' => 'left: 36.62%; top: 80.93%; width: 4.78%; height: 2.36%;', 'image' => 'lf-mirror.png'],
            ['id' => 'lr-taillight', 'style' => 'left: 61.89%; top: 82.89%; width: 9.15%; height: 3.84%;', 'image' => 'lr-taillight.png'],
            ['id' => 'rr-taillight', 'style' => 'left: 81.59%; top: 82.89%; width: 9.15%; height: 3.84%;', 'image' => 'rr-taillight.png'],
            ['id' => 'rear-bumper', 'style' => 'left: 59.20%; top: 87.36%; width: 33.83%; height: 5.03%;', 'image' => 'rear-bumper.png'],
            ['id' => 'left-skirting', 'style' => 'left: 10%; top: 70%; width: 15%; height: 8%;', 'image' => 'left-skirting.png'],
            ['id' => 'right-skirting', 'style' => 'left: 75%; top: 20%; width: 15%; height: 8%;', 'image' => 'right-skirting.png']
        ];
        
        // Create lookup for panel conditions
        $panelLookup = [];
        foreach ($bodyPanels as $panel) {
            $panelId = str_replace('_', '-', $panel['panel_id']);
            if (!empty($panel['condition']) && $panel['condition'] !== 'not_assessed') {
                $panelLookup[$panelId] = $panel['condition'];
            }
        }
        
        $overlays = '';
        foreach ($allPanels as $panel) {
            if (isset($panelLookup[$panel['id']])) {
                $condition = strtolower($panelLookup[$panel['id']]);
                // Map 'bad' to 'poor' for consistency with CSS
                if ($condition === 'bad') {
                    $condition = 'poor';
                }
                
                // Get the panel image and convert to base64
                $panelImagePath = public_path('images/panels/' . $panel['image']);
                $panelImageData = '';
                
                if (file_exists($panelImagePath)) {
                    $imageContent = file_get_contents($panelImagePath);
                    $panelImageData = 'data:image/png;base64,' . base64_encode($imageContent);
                    // Use div with mask instead of img for proper coloring
                    $overlays .= '<div class="panel-overlay condition-' . $condition . '" style="' . $panel['style'] . ' 
                        -webkit-mask-image: url(\'' . $panelImageData . '\'); 
                        mask-image: url(\'' . $panelImageData . '\');
                        -webkit-mask-size: contain;
                        mask-size: contain;
                        -webkit-mask-repeat: no-repeat;
                        mask-repeat: no-repeat;
                        -webkit-mask-position: center;
                        mask-position: center;"></div>' . "\n";
                }
            }
        }
        
        return $overlays;
    }
    
    /**
     * Generate HTML for interior diagram with overlays
     */
    private function generateInteriorDiagramHtml($inspectionData, $baseUrl)
    {
        $interiorComponents = $inspectionData['interior']['assessments'] ?? [];
        
        // Use file path instead of URL for the base image
        $interiorImagePath = public_path('images/interior/interiorMain.png');
        $interiorImageData = '';
        
        // Convert image to base64 data URL
        if (file_exists($interiorImagePath)) {
            $imageContent = file_get_contents($interiorImagePath);
            $interiorImageData = 'data:image/png;base64,' . base64_encode($imageContent);
        }
        
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { margin: 0; padding: 20px; background: white; font-family: Arial, sans-serif; }
        .interior-diagram-container { position: relative; display: inline-block; max-width: 600px; width: 100%; }
        .layer-base { width: 100%; height: auto; display: block; }
        .interior-overlay { 
            position: absolute; 
            pointer-events: none;
        }
        .interior-overlay.condition-good { 
            background-color: rgba(40, 167, 69, 0.8);
        }
        .interior-overlay.condition-average { 
            background-color: rgba(255, 193, 7, 0.8);
        }
        .interior-overlay.condition-poor { 
            background-color: rgba(220, 53, 69, 0.8);
        }
    </style>
</head>
<body>
    <div class="interior-diagram-container">
        <img src="' . $interiorImageData . '" alt="Interior Base" class="layer-base">
        ' . $this->generateInteriorOverlays($interiorComponents, $baseUrl) . '
    </div>
</body>
</html>';
    }
    
    /**
     * Generate interior overlays HTML
     */
    private function generateInteriorOverlays($interiorComponents, $baseUrl)
    {
        // Interior component definitions with image files
        $allInteriorComponents = [
            'dash' => ['style' => 'left: 6.07%; top: 4.25%; width: 88.36%; height: 17.68%;', 'image' => 'Dash.png'],
            'steering-wheel' => ['style' => 'left: 59.20%; top: 17.68%; width: 23.88%; height: 8.56%;', 'image' => 'steering-wheel.png'],
            'buttons' => ['style' => 'left: 47.36%; top: 18.86%; width: 6.47%; height: 4.59%;', 'image' => 'buttons-centre.png'],
            'driver-seat' => ['style' => 'left: 55.52%; top: 18.86%; width: 34.43%; height: 31.25%;', 'image' => 'driver-seat.png'],
            'passenger-seat' => ['style' => 'left: 11.44%; top: 20.74%; width: 33.03%; height: 29.23%;', 'image' => 'passenger-seat.png'],
            'rear-seat' => ['style' => 'left: 13.03%; top: 49.55%; width: 73.33%; height: 27.84%;', 'image' => 'Rear-Seat.png'],
            'fr-door-panel' => ['style' => 'left: 87.86%; top: 14.13%; width: 9.65%; height: 32.78%;', 'image' => 'fr-dOORPANEL.png'],
            'fl-door-panel' => ['style' => 'left: 3.08%; top: 14.13%; width: 10.05%; height: 33.47%;', 'image' => 'FL Doorpanel.png'],
            'rr-door-panel' => ['style' => 'left: 84.98%; top: 47.11%; width: 11.84%; height: 30.83%;', 'image' => 'RR-Door-Panel.png'],
            'lr-door-panel' => ['style' => 'left: 4.38%; top: 47.18%; width: 13.03%; height: 30.83%;', 'image' => 'LR-DoorPanel.png'],
            'boot' => ['style' => 'left: 10.25%; top: 91.15%; width: 80.70%; height: 8.70%;', 'image' => 'Boot.png'],
            'centre-console' => ['style' => 'left: 39.20%; top: 17.82%; width: 22.59%; height: 33.68%;', 'image' => 'Centre-Consol.png'],
            'gearlever' => ['style' => 'left: 47.56%; top: 27.00%; width: 5.37%; height: 4.52%;', 'image' => 'Gear-Lever.png'],
            'air-vents' => ['style' => 'left: 7.06%; top: 12.67%; width: 86.37%; height: 10.44%;', 'image' => 'Airvents.png'],
            'backboard' => ['style' => 'left: 10.65%; top: 76.53%; width: 80.80%; height: 19.14%;', 'image' => 'backboard.png']
        ];
        
        // Map interior assessments to visual components (same mapping as web report)
        $interiorIdMap = [
            'interior_77' => 'dash', 'interior_78' => 'steering-wheel', 'interior_79' => 'buttons',
            'interior_80' => 'driver-seat', 'interior_81' => 'passenger-seat', 'interior_82' => 'backboard',
            'interior_83' => 'fr-door-panel', 'interior_84' => 'fl-door-panel', 'interior_85' => 'rear-seat',
            'interior_86' => 'rear-seat', 'interior_87' => 'backboard', 'interior_88' => 'rr-door-panel',
            'interior_89' => 'lr-door-panel', 'interior_90' => 'boot', 'interior_91' => 'centre-console',
            'interior_92' => 'gearlever', 'interior_93' => 'gearlever', 'interior_94' => 'air-vents',
            'interior_95' => 'boot', 'interior_96' => 'dash'
        ];
        
        $visualLookup = [];
        foreach ($interiorComponents as $component) {
            $componentId = $component['component_id'] ?? '';
            $condition = $component['condition'] ?? '';
            
            $visualComponentId = $interiorIdMap[$componentId] ?? '';
            if ($visualComponentId && $condition && $condition !== 'not_assessed') {
                if (!isset($visualLookup[$visualComponentId])) {
                    $visualLookup[$visualComponentId] = $condition;
                } else {
                    // Use worst condition
                    $currentCondition = strtolower($visualLookup[$visualComponentId]);
                    $newCondition = strtolower($condition);
                    
                    if ($newCondition === 'bad' || ($newCondition === 'average' && $currentCondition === 'good')) {
                        $visualLookup[$visualComponentId] = $condition;
                    }
                }
            }
        }
        
        $overlays = '';
        foreach ($allInteriorComponents as $componentId => $componentData) {
            if (isset($visualLookup[$componentId])) {
                $condition = strtolower($visualLookup[$componentId]);
                // Map 'bad' to 'poor' for consistency with CSS
                if ($condition === 'bad') {
                    $condition = 'poor';
                }
                
                // Get the component image and convert to base64
                $componentImagePath = public_path('images/interior/' . $componentData['image']);
                $componentImageData = '';
                
                if (file_exists($componentImagePath)) {
                    $imageContent = file_get_contents($componentImagePath);
                    $componentImageData = 'data:image/png;base64,' . base64_encode($imageContent);
                    // Use div with mask instead of img for proper coloring
                    $overlays .= '<div class="interior-overlay condition-' . $condition . '" style="' . $componentData['style'] . ' 
                        -webkit-mask-image: url(\'' . $componentImageData . '\'); 
                        mask-image: url(\'' . $componentImageData . '\');
                        -webkit-mask-size: contain;
                        mask-size: contain;
                        -webkit-mask-repeat: no-repeat;
                        mask-repeat: no-repeat;
                        -webkit-mask-position: center;
                        mask-position: center;"></div>' . "\n";
                }
            }
        }
        
        return $overlays;
    }
    
    /**
     * Process HTML and replace vehicle diagram sections with screenshots
     */
    public function processVehicleDiagrams($html, $inspectionData)
    {
        // Configuration flag - set to false to disable screenshot generation
        $enableScreenshots = true; // ENABLED - Chrome and dependencies are now installed
        
        if (!$enableScreenshots) {
            \Log::info("Vehicle diagram screenshots are disabled");
            return $html;
        }
        
        // Check if this HTML contains vehicle diagram sections
        if (strpos($html, 'Vehicle Body Panels') !== false) {
            $bodyPanelScreenshot = $this->captureVehicleDiagram($inspectionData, 'body-panel');
            
            if ($bodyPanelScreenshot && file_exists($bodyPanelScreenshot)) {
                // Replace the vehicle diagram section with screenshot
                $pattern = '/<!-- Vehicle Diagram -->.*?<img[^>]*FullVehicle\.png[^>]*>/s';
                $replacement = '<!-- Vehicle Diagram Screenshot --><div style="text-align: center; margin: 20px 0; page-break-inside: avoid;"><img src="' . $bodyPanelScreenshot . '" alt="Vehicle Body Panels" style="max-width: 600px; width: 100%; height: auto; border: 1px solid #ddd;"></div>';
                $html = preg_replace($pattern, $replacement, $html);
            }
        }
        
        if (strpos($html, 'interiorMain.png') !== false) {
            $interiorScreenshot = $this->captureVehicleDiagram($inspectionData, 'interior');
            
            if ($interiorScreenshot && file_exists($interiorScreenshot)) {
                // Replace the interior diagram section with screenshot
                $pattern = '/<!-- Interior Diagram -->.*?<img[^>]*interiorMain\.png[^>]*>/s';
                $replacement = '<!-- Interior Diagram Screenshot --><div style="text-align: center; margin: 20px 0; page-break-inside: avoid;"><img src="' . $interiorScreenshot . '" alt="Vehicle Interior" style="max-width: 600px; width: 100%; height: auto; border: 1px solid #ddd;"></div>';
                $html = preg_replace($pattern, $replacement, $html);
            }
        }
        
        return $html;
    }
}