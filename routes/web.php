<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    // Get last 6 inspections (draft and completed) ordered by most recent
    $recentInspections = App\Models\Inspection::with(['client', 'vehicle'])
        ->whereIn('status', ['draft', 'completed'])
        ->orderBy('inspection_date', 'desc')
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();
    
    return view('dashboard', compact('recentInspections'));
});

// Test page for visual report
Route::get('/test-visual-report', function () {
    return view('visual-inspection-test');
});

// Inspection routes
Route::controller(InspectionController::class)->group(function () {
    // View routes
    Route::get('/inspection/visual', 'visualInspection')->name('inspection.visual');
    Route::get('/inspection/body-panel', 'bodyPanelAssessment')->name('inspection.body-panel');
    Route::get('/inspection/interior', 'interiorAssessment')->name('inspection.interior');
    Route::get('/inspection/service-booklet', 'serviceBooklet')->name('inspection.service-booklet');
    Route::get('/inspection/tyres-rims', 'tyresRimsAssessment')->name('inspection.tyres-rims');
    Route::get('/inspection/mechanical-report', 'mechanicalReport')->name('inspection.mechanical-report');
    Route::get('/inspection/engine-compartment', 'engineCompartmentAssessment')->name('inspection.engine-compartment');
    Route::get('/inspection/physical-hoist', 'physicalHoistInspection')->name('inspection.physical-hoist');
    
    // API routes for saving data
    Route::post('/api/inspection/visual', 'saveVisualInspection')->name('api.inspection.visual');
    Route::post('/api/inspection/body-panel', 'saveBodyPanelAssessment')->name('api.inspection.body-panel');
    Route::post('/api/inspection/interior', 'saveInteriorAssessment')->name('api.inspection.interior');
    Route::post('/api/inspection/service-booklet', 'saveServiceBooklet')->name('api.inspection.service-booklet');
    Route::post('/api/inspection/tyres-rims', 'saveTyresRimsAssessment')->name('api.inspection.tyres-rims');
    Route::post('/api/inspection/mechanical-report', 'saveMechanicalReport')->name('api.inspection.mechanical-report');
    Route::post('/api/inspection/engine-compartment', 'saveEngineCompartmentAssessment')->name('api.inspection.engine-compartment');
    Route::post('/api/inspection/physical-hoist', 'savePhysicalHoistInspection')->name('api.inspection.physical-hoist');
    Route::post('/api/inspection/upload-image', 'uploadImage')->name('api.inspection.upload-image');
    Route::post('/api/inspection/complete', 'completeInspection')->name('api.inspection.complete');
    Route::match(['GET', 'POST'], '/test/visual-report', 'testVisualReport')->name('test.visual-report');
    Route::match(['GET', 'POST'], '/test-reports/body-panel', 'testBodyPanelReport')->name('test.body-panel-report');
    Route::match(['GET', 'POST'], '/debug/body-panel-data', 'debugBodyPanelData')->name('debug.body-panel-data');
    Route::match(['GET', 'POST'], '/quick-debug/body-panel', 'quickDebugBodyPanel')->name('quick-debug.body-panel');
    Route::post('/preview/body-panel', 'previewBodyPanel')->name('preview.body-panel');
    Route::post('/preview/interior', 'previewInterior')->name('preview.interior');
    Route::post('/preview/service-booklet', 'previewServiceBooklet')->name('preview.service-booklet');
    Route::post('/preview/tyres-rims', 'previewTyresRims')->name('preview.tyres-rims');
    Route::post('/preview/mechanical-report', 'previewMechanicalReport')->name('preview.mechanical-report');
    Route::post('/preview/engine-compartment', 'previewEngineCompartment')->name('preview.engine-compartment');
    Route::post('/preview/physical-hoist', 'previewPhysicalHoist')->name('preview.physical-hoist');
});

// Image handling routes
Route::controller(ImageController::class)->group(function () {
    Route::post('/api/image/upload', 'upload')->name('api.image.upload');
    Route::get('/api/image/compress', 'compress')->name('api.image.compress');
});

// Diagnostic route for staging debugging
Route::get('/debug-reports', function () {
    try {
        // Test database connection
        $dbStatus = DB::connection()->getPdo() ? 'Connected' : 'Failed';
        
        // Test if InspectionReport model can be loaded
        $modelStatus = class_exists('App\Models\InspectionReport') ? 'Loaded' : 'Missing';
        
        // Test if reports table exists and count records
        try {
            $reportCount = App\Models\InspectionReport::count();
            $tableStatus = 'Exists (' . $reportCount . ' records)';
        } catch (Exception $e) {
            $tableStatus = 'Error: ' . $e->getMessage();
        }
        
        // Test Lightbox2 CDN
        $lightboxCdn = 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css';
        
        return response()->json([
            'database' => $dbStatus,
            'model' => $modelStatus,
            'reports_table' => $tableStatus,
            'lightbox_cdn' => $lightboxCdn,
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'timestamp' => now()
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ], 500);
    }
});

// Test routes (keep for development)
Route::get('/test', function () {
    return view('test-panel');
});
Route::get('/positioning-tool', function () {
    return view('panel-positioning-tool');
});
Route::get('/interior-test', function () {
    return view('interior-panel-test');
});
// Report management routes - Web view only (PDF functionality removed)
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{id}', [App\Http\Controllers\ReportController::class, 'showWeb'])->name('reports.show');
Route::delete('/reports/{id}', [App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.destroy');
Route::delete('/reports', [App\Http\Controllers\ReportController::class, 'destroyAll'])->name('reports.destroy-all');

// Email report functionality
Route::post('/api/reports/email/{id}', [App\Http\Controllers\ReportController::class, 'emailReport'])->name('api.reports.email');

// Simple email test route
Route::get('/test-simple-email', function() {
    try {
        // Test sending a very basic email
        \Mail::raw('This is a simple test email with no templates or attachments.', function ($message) {
            $message->to('george@beeza.co.za')
                    ->subject('Simple Test Email')
                    ->from('report@alphainspections.co.za', 'Alpha Inspections');
        });
        
        return response()->json(['success' => true, 'message' => 'Simple email sent']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Test mailable class with simple PDF
Route::get('/test-mailable', function() {
    try {
        // Create minimal test data
        $inspectionData = [
            'client' => ['name' => 'Test Client'],
            'vehicle' => [
                'make' => 'Test Make',
                'model' => 'Test Model', 
                'year' => '2020',
                'vin' => 'TEST123',
                'license_plate' => 'TEST123',
                'mileage' => '50000'
            ],
            'inspection' => [
                'inspector' => 'Test Inspector',
                'date' => '2025-08-26'
            ]
        ];
        
        // Create a simple test PDF file
        $testPdfContent = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] >>\nendobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000058 00000 n\n0000000115 00000 n\ntrailer\n<< /Size 4 /Root 1 0 R >>\nstartxref\n178\n%%EOF";
        $testPdfPath = storage_path('app/public/reports/test.pdf');
        
        // Ensure directory exists
        if (!file_exists(dirname($testPdfPath))) {
            mkdir(dirname($testPdfPath), 0755, true);
        }
        
        file_put_contents($testPdfPath, $testPdfContent);
        
        // Test the mailable class
        \Mail::to('george@beeza.co.za')->send(new App\Mail\InspectionReportMail(
            $inspectionData,
            'reports/test.pdf', // relative path
            'test-report.pdf',
            'Test Mailable Subject',
            'This is a test message'
        ));
        
        return response()->json(['success' => true, 'message' => 'Mailable test sent']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Test just the email template without PDF
Route::get('/test-email-template', function() {
    try {
        // Create minimal test data
        $inspectionData = [
            'client' => ['name' => 'Test Client'],
            'vehicle' => [
                'make' => 'Test Make',
                'model' => 'Test Model', 
                'year' => '2020',
                'vin' => 'TEST123',
                'license_plate' => 'TEST123',
                'mileage' => '50000'
            ],
            'inspection' => [
                'inspector' => 'Test Inspector',
                'date' => '2025-08-26'
            ]
        ];
        
        // Test sending template email without attachment
        \Mail::send('emails.inspection-report', [
            'inspectionData' => $inspectionData,
            'customMessage' => 'This is a test message'
        ], function ($message) {
            $message->to('george@beeza.co.za')
                    ->subject('Test Template Email')
                    ->from('report@alphainspections.co.za', 'Alpha Inspections');
        });
        
        return response()->json(['success' => true, 'message' => 'Template email sent']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Test route to diagnose PDF issues
Route::get('/test-pdf', function() {
    try {
        return response()->json(['status' => 'PDF route accessible', 'timestamp' => now()]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Minimal PDF test
Route::get('/test-pdf-simple', function() {
    try {
        // Test if PdfService can be instantiated
        $pdfService = new App\Services\PdfService();
        
        // Test minimal HTML
        $html = '<html><body><h1>Test PDF</h1><p>This is a test.</p></body></html>';
        
        return $pdfService->generatePdf($html, 'test.pdf');
        
    } catch (\Exception $e) {
        \Log::error('Simple PDF Test Error: ' . $e->getMessage());
        return response()->json(['error' => 'Simple PDF test failed: ' . $e->getMessage()], 500);
    }
});

// Ultra-minimal mPDF test 
Route::get('/test-mpdf', function() {
    try {
        // Check if mPDF class exists first
        if (!class_exists('Mpdf\\Mpdf')) {
            return response()->json(['error' => 'mPDF class not found - composer install needed'], 500);
        }
        
        // Test if mPDF can be instantiated at all
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML('<h1>Hello World</h1>');
        return $mpdf->Output('test.pdf', 'I');
    } catch (\Throwable $e) {
        \Log::error('mPDF Test Error: ' . $e->getMessage());
        return response()->json(['error' => 'mPDF failed: ' . $e->getMessage()], 500);
    }
});

// Test PHP extensions and mPDF requirements
Route::get('/test-php-requirements', function() {
    try {
        $requirements = [
            'mbstring' => extension_loaded('mbstring'),
            'gd' => extension_loaded('gd'),
            'dom' => extension_loaded('dom'),
            'xml' => extension_loaded('xml'),
            'iconv' => extension_loaded('iconv'),
            'zlib' => extension_loaded('zlib'),
            'curl' => extension_loaded('curl'),
            'openssl' => extension_loaded('openssl')
        ];
        
        return response()->json([
            'php_version' => PHP_VERSION,
            'extensions' => $requirements,
            'missing_extensions' => array_keys(array_filter($requirements, function($loaded) { return !$loaded; })),
            'composer_autoload_exists' => file_exists(base_path('vendor/autoload.php')),
            'mpdf_vendor_exists' => class_exists('Mpdf\\Mpdf', false) // Check if already loaded
        ]);
        
    } catch (\Throwable $e) {
        return response()->json(['error' => 'Requirements test failed: ' . $e->getMessage()], 500);
    }
});

// Test temp directory permissions
Route::get('/test-temp', function() {
    try {
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        $testFile = $tempDir . '/test.txt';
        file_put_contents($testFile, 'test');
        $canRead = file_exists($testFile);
        
        if ($canRead) {
            unlink($testFile);
        }
        
        return response()->json([
            'temp_dir' => $tempDir,
            'temp_exists' => file_exists($tempDir),
            'temp_writable' => is_writable($tempDir),
            'test_file_created' => $canRead
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Temp test failed: ' . $e->getMessage()], 500);
    }
});

// Simple test to verify PDF saving works
Route::get('/test-pdf-save', function() {
    try {
        // Create a simple test HTML
        $html = '<h1>Test PDF</h1><p>This is a test PDF to verify saving functionality works.</p>';
        $html .= '<p>Generated at: ' . now()->format('Y-m-d H:i:s') . '</p>';
        
        // Use PdfService to save PDF
        $pdfService = new App\Services\PdfService();
        $savedPath = $pdfService->generateAndSavePdf($html, 'test_pdf.pdf');
        
        if ($savedPath) {
            return response()->json([
                'success' => true,
                'message' => 'Test PDF saved successfully',
                'path' => $savedPath,
                'full_path' => storage_path('app/public/' . $savedPath),
                'url' => asset('storage/' . $savedPath)
            ]);
        } else {
            return response()->json(['error' => 'Failed to save PDF'], 500);
        }
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
    }
});

// Test route to save PDF to disk
Route::get('/test-save-pdf/{id}', function($id) {
    try {
        // Find the inspection
        $inspection = App\Models\Inspection::with(['client', 'vehicle', 'images', 'bodyPanelAssessments', 'interiorAssessments'])->find($id);
        
        if (!$inspection) {
            return response()->json(['error' => 'Inspection not found'], 404);
        }
        
        // Get the ReportController to format data
        $reportController = new App\Http\Controllers\ReportController();
        
        // Build inspection data using the same format as PDF generation
        $inspectionData = [
            'client' => [
                'name' => $inspection->client->name ?? 'Not specified',
                'contact' => $inspection->client->phone ?? null,
                'email' => $inspection->client->email ?? null
            ],
            'vehicle' => [
                'make' => $inspection->vehicle->manufacturer ?? 'Not specified',
                'model' => $inspection->vehicle->model ?? 'Not specified',
                'year' => $inspection->vehicle->year ?? 'Not specified',
                'vin' => $inspection->vehicle->vin ?? 'Not specified',
                'license_plate' => $inspection->vehicle->registration_number ?? 'Not specified',
                'mileage' => $inspection->vehicle->mileage ?? 'Not specified',
                'vehicle_type' => $inspection->vehicle->vehicle_type ?? 'Not specified',
                'colour' => $inspection->vehicle->colour ?? 'Not specified',
                'fuel_type' => $inspection->vehicle->fuel_type ?? 'Not specified',
                'transmission' => $inspection->vehicle->transmission ?? 'Not specified',
                'doors' => $inspection->vehicle->doors ?? 'Not specified',
                'engine_number' => $inspection->vehicle->engine_number ?? 'Not specified'
            ],
            'inspection' => [
                'inspector' => $inspection->inspector_name ?? 'Not specified',
                'date' => $inspection->inspection_date ?? $inspection->created_at->format('Y-m-d H:i'),
                'diagnostic_report' => $inspection->diagnostic_report ?? null,
                'diagnostic_file' => $reportController->getDiagnosticFileData($inspection)
            ],
            'images' => $reportController->organizeImagesForReport($inspection->images),
            'body_panels' => $reportController->formatBodyPanelsForReport($inspection),
            'interior' => [
                'assessments' => $reportController->formatInteriorAssessmentsForReport($inspection)
            ],
            'service_booklet' => $reportController->formatServiceBookletForReport($inspection),
            'tyres_rims' => $reportController->formatTyresRimsForReport($inspection),
            'mechanical_report' => $reportController->formatMechanicalReportForReport($inspection),
            'braking_system' => $reportController->formatBrakingSystemForReport($inspection),
            'engine_compartment' => $reportController->formatEngineCompartmentForReport($inspection),
            'physical_hoist' => $reportController->formatPhysicalHoistForReport($inspection)
        ];
        
        // Create report object
        $report = (object)[
            'id' => $inspection->id,
            'report_number' => 'INS-' . str_pad($inspection->id, 6, '0', STR_PAD_LEFT),
            'client_name' => $inspection->client->name ?? 'Not specified',
            'vehicle_make' => $inspection->vehicle->manufacturer ?? 'Unknown Make',
            'vehicle_model' => $inspection->vehicle->model ?? 'Unknown Model',
            'inspection_date' => $inspection->inspection_date ?? $inspection->created_at->toDateString(),
        ];
        
        // Generate HTML for PDF
        $baseUrl = config('app.url', 'http://localhost/vehicle-inspection');
        $html = view('pdf.simple-report', [
            'report' => $report,
            'inspectionData' => $inspectionData,
            'baseUrl' => $baseUrl
        ])->render();
        
        // Use PdfService to save PDF
        $pdfService = new App\Services\PdfService();
        $savedPath = $pdfService->generateAndSavePdf($html, 'report_' . $report->report_number . '.pdf');
        
        if ($savedPath) {
            return response()->json([
                'success' => true,
                'message' => 'PDF saved successfully',
                'path' => $savedPath,
                'full_path' => storage_path('app/public/' . $savedPath),
                'url' => asset('storage/' . $savedPath)
            ]);
        } else {
            return response()->json(['error' => 'Failed to save PDF'], 500);
        }
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
    }
});

// Test email sending with PDF attachment
Route::get('/test-email-pdf/{id}', function($id) {
    try {
        // Find the inspection
        $inspection = App\Models\Inspection::with(['client', 'vehicle', 'images', 'bodyPanelAssessments', 'interiorAssessments'])->find($id);
        
        if (!$inspection) {
            return response()->json(['error' => 'Inspection not found'], 404);
        }
        
        // Get the ReportController to format data
        $reportController = new App\Http\Controllers\ReportController();
        
        // Build inspection data
        $inspectionData = [
            'client' => [
                'name' => $inspection->client->name ?? 'Not specified',
                'contact' => $inspection->client->phone ?? null,
                'email' => $inspection->client->email ?? null
            ],
            'vehicle' => [
                'make' => $inspection->vehicle->manufacturer ?? 'Not specified',
                'model' => $inspection->vehicle->model ?? 'Not specified',
                'year' => $inspection->vehicle->year ?? 'Not specified',
                'vin' => $inspection->vehicle->vin ?? 'Not specified',
                'license_plate' => $inspection->vehicle->registration_number ?? 'Not specified',
                'mileage' => $inspection->vehicle->mileage ?? 'Not specified'
            ],
            'inspection' => [
                'inspector' => $inspection->inspector_name ?? 'Not specified',
                'date' => $inspection->inspection_date ?? $inspection->created_at->format('Y-m-d H:i')
            ]
        ];
        
        // Create report object
        $report = (object)[
            'id' => $inspection->id,
            'report_number' => 'INS-' . str_pad($inspection->id, 6, '0', STR_PAD_LEFT)
        ];
        
        // First, generate and save the PDF
        $baseUrl = config('app.url', 'http://localhost/vehicle-inspection');
        $html = view('pdf.simple-report', [
            'report' => $report,
            'inspectionData' => [
                'client' => $inspectionData['client'],
                'vehicle' => $inspectionData['vehicle'],
                'inspection' => [
                    'inspector' => $inspectionData['inspection']['inspector'],
                    'date' => $inspectionData['inspection']['date'],
                    'diagnostic_report' => $inspection->diagnostic_report ?? null,
                    'diagnostic_file' => $reportController->getDiagnosticFileData($inspection)
                ],
                'images' => $reportController->organizeImagesForReport($inspection->images),
                'body_panels' => $reportController->formatBodyPanelsForReport($inspection),
                'interior' => [
                    'assessments' => $reportController->formatInteriorAssessmentsForReport($inspection)
                ],
                'service_booklet' => $reportController->formatServiceBookletForReport($inspection),
                'tyres_rims' => $reportController->formatTyresRimsForReport($inspection),
                'mechanical_report' => $reportController->formatMechanicalReportForReport($inspection),
                'braking_system' => $reportController->formatBrakingSystemForReport($inspection),
                'engine_compartment' => $reportController->formatEngineCompartmentForReport($inspection),
                'physical_hoist' => $reportController->formatPhysicalHoistForReport($inspection)
            ],
            'baseUrl' => $baseUrl
        ])->render();
        
        // Save PDF to disk
        $pdfService = new App\Services\PdfService();
        $savedPath = $pdfService->generateAndSavePdf($html, 'report_' . $report->report_number . '.pdf');
        
        if (!$savedPath) {
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
        
        // Send email with the saved PDF
        $recipient = request('email', 'test@example.com'); // Default test email
        
        \Mail::to($recipient)->send(new App\Mail\InspectionReportMail(
            $inspectionData,
            $savedPath,
            'report_' . $report->report_number . '.pdf',
            'Vehicle Inspection Report - ' . $report->report_number,
            'Please find attached the vehicle inspection report for your review.'
        ));
        
        // Check if PDF file exists
        $fullPdfPath = storage_path('app/public/' . $savedPath);
        $pdfExists = file_exists($fullPdfPath);
        $pdfSize = $pdfExists ? filesize($fullPdfPath) : 0;
        
        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully (check logs if using log driver)',
            'recipient' => $recipient,
            'pdf_path' => $savedPath,
            'pdf_exists' => $pdfExists,
            'pdf_size' => round($pdfSize / 1024, 2) . ' KB',
            'pdf_url' => asset('storage/' . $savedPath),
            'mail_driver' => config('mail.default'),
            'note' => 'With log driver, email is saved to storage/logs/laravel.log as base64 encoded content'
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
    }
});

// Simple PDF generation route
Route::get('/reports/{id}/pdf', function($id) {
    try {
        // Try to find the inspection report first
        $inspectionReport = App\Models\InspectionReport::find($id);
        
        if ($inspectionReport) {
            // Use existing method from ReportController to get processed data
            $reportController = new App\Http\Controllers\ReportController();
            $inspectionData = $reportController->processInspectionDataForWeb($inspectionReport);
            $report = $inspectionReport;
        } else {
            // If not found, try to find an Inspection instead  
            $inspection = App\Models\Inspection::with(['client', 'vehicle', 'images', 'bodyPanelAssessments', 'interiorAssessments'])->find($id);
            
            if (!$inspection) {
                return response()->json(['error' => 'Report not found'], 404);
            }
            
            // Get the ReportController instance to use its formatting methods
            $reportController = new App\Http\Controllers\ReportController();
            
            // Build inspection data using the same format as showWeb method
            $inspectionData = [
                'client' => [
                    'name' => $inspection->client->name ?? 'Not specified',
                    'contact' => $inspection->client->phone ?? null,
                    'email' => $inspection->client->email ?? null
                ],
                'vehicle' => [
                    'make' => $inspection->vehicle->manufacturer ?? 'Not specified',
                    'model' => $inspection->vehicle->model ?? 'Not specified',
                    'year' => $inspection->vehicle->year ?? 'Not specified',
                    'vin' => $inspection->vehicle->vin ?? 'Not specified',
                    'license_plate' => $inspection->vehicle->registration_number ?? 'Not specified',
                    'mileage' => $inspection->vehicle->mileage ?? 'Not specified',
                    'vehicle_type' => $inspection->vehicle->vehicle_type ?? 'Not specified',
                    'colour' => $inspection->vehicle->colour ?? 'Not specified',
                    'fuel_type' => $inspection->vehicle->fuel_type ?? 'Not specified',
                    'transmission' => $inspection->vehicle->transmission ?? 'Not specified',
                    'doors' => $inspection->vehicle->doors ?? 'Not specified',
                    'engine_number' => $inspection->vehicle->engine_number ?? 'Not specified'
                ],
                'inspection' => [
                    'inspector' => $inspection->inspector_name ?? 'Not specified',
                    'date' => $inspection->inspection_date ?? $inspection->created_at->format('Y-m-d H:i'),
                    'diagnostic_report' => $inspection->diagnostic_report ?? null,
                    'diagnostic_file' => $reportController->getDiagnosticFileData($inspection)
                ],
                'images' => $reportController->organizeImagesForReport($inspection->images),
                'body_panels' => $reportController->formatBodyPanelsForReport($inspection),
                'interior' => [
                    'assessments' => $reportController->formatInteriorAssessmentsForReport($inspection)
                ],
                'service_booklet' => $reportController->formatServiceBookletForReport($inspection),
                'tyres_rims' => $reportController->formatTyresRimsForReport($inspection),
                'mechanical_report' => $reportController->formatMechanicalReportForReport($inspection),
                'braking_system' => $reportController->formatBrakingSystemForReport($inspection),
                'engine_compartment' => $reportController->formatEngineCompartmentForReport($inspection),
                'physical_hoist' => $reportController->formatPhysicalHoistForReport($inspection)
            ];
            
            // Create report object same as ReportController
            $report = (object)[
                'id' => $inspection->id,
                'report_number' => 'INS-' . str_pad($inspection->id, 6, '0', STR_PAD_LEFT),
                'client_name' => $inspection->client->name ?? 'Not specified',
                'client_email' => $inspection->client->email ?? null,
                'client_phone' => $inspection->client->phone ?? null,
                'vehicle_make' => $inspection->vehicle->manufacturer ?? 'Unknown Make',
                'vehicle_model' => $inspection->vehicle->model ?? 'Unknown Model',
                'vehicle_year' => $inspection->vehicle->year ?? date('Y'),
                'vin_number' => $inspection->vehicle->vin ?? null,
                'license_plate' => $inspection->vehicle->registration_number ?? null,
                'mileage' => $inspection->vehicle->mileage ?? null,
                'inspection_date' => $inspection->inspection_date ?? $inspection->created_at->toDateString(),
                'inspector_name' => $inspection->inspector_name ?? 'Unknown Inspector',
                'status' => $inspection->status ?? 'draft',
                'created_at' => $inspection->created_at,
                'updated_at' => $inspection->updated_at
            ];
        }
        
        // Generate PDF using the simple template
        $pdfService = new App\Services\PdfService();
        
        // Add base URL for links
        $baseUrl = config('app.url', 'http://localhost/vehicle-inspection');
        
        try {
            // Try to render the Blade template
            $html = view('pdf.simple-report', [
                'report' => $report,
                'inspectionData' => $inspectionData,
                'baseUrl' => $baseUrl
            ])->render();
        } catch (\Exception $e) {
            \Log::error('PDF Template Rendering Error: ' . $e->getMessage());
            return response()->json(['error' => 'PDF template error: ' . $e->getMessage()], 500);
        }
        
        try {
            // Process vehicle diagrams to capture screenshots
            $html = $pdfService->processVehicleDiagrams($html, $inspectionData);
        } catch (\Exception $e) {
            \Log::error('PDF Diagram Processing Error: ' . $e->getMessage());
            // Continue without diagram processing if it fails
        }
        
        try {
            return $pdfService->generatePdf($html, 'report_' . $report->report_number . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json(['error' => 'PDF generation error: ' . $e->getMessage()], 500);
        }
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'PDF generation failed: ' . $e->getMessage()], 500);
    }
})->name('reports.pdf');