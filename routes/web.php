<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Inspection routes
Route::controller(InspectionController::class)->group(function () {
    // View routes
    Route::get('/inspection/visual', 'visualInspection')->name('inspection.visual');
    Route::get('/inspection/body-panel', 'bodyPanelAssessment')->name('inspection.body-panel');
    Route::get('/inspection/specific-areas', 'specificAreaImages')->name('inspection.specific-areas');
    Route::get('/inspection/interior', 'interiorAssessment')->name('inspection.interior');
    Route::get('/inspection/interior-images', 'interiorSpecificImages')->name('inspection.interior-images');
    Route::get('/inspection/service-booklet', 'serviceBooklet')->name('inspection.service-booklet');
    Route::get('/inspection/tyres-rims', 'tyresRimsAssessment')->name('inspection.tyres-rims');
    Route::get('/inspection/mechanical-report', 'mechanicalReport')->name('inspection.mechanical-report');
    Route::get('/inspection/engine-compartment', 'engineCompartmentAssessment')->name('inspection.engine-compartment');
    Route::get('/inspection/physical-hoist', 'physicalHoistInspection')->name('inspection.physical-hoist');
    
    // API routes for saving data
    Route::post('/api/inspection/visual', 'saveVisualInspection')->name('api.inspection.visual');
    Route::post('/api/inspection/body-panel', 'saveBodyPanelAssessment')->name('api.inspection.body-panel');
    Route::post('/api/inspection/specific-areas', 'saveSpecificAreaImages')->name('api.inspection.specific-areas');
    Route::post('/api/inspection/interior', 'saveInteriorAssessment')->name('api.inspection.interior');
    Route::post('/api/inspection/interior-images', 'saveInteriorSpecificImages')->name('api.inspection.interior-images');
    Route::post('/api/inspection/service-booklet', 'saveServiceBooklet')->name('api.inspection.service-booklet');
    Route::post('/api/inspection/tyres-rims', 'saveTyresRimsAssessment')->name('api.inspection.tyres-rims');
    Route::post('/api/inspection/mechanical-report', 'saveMechanicalReport')->name('api.inspection.mechanical-report');
    Route::post('/api/inspection/engine-compartment', 'saveEngineCompartmentAssessment')->name('api.inspection.engine-compartment');
    Route::post('/api/inspection/physical-hoist', 'savePhysicalHoistInspection')->name('api.inspection.physical-hoist');
    Route::post('/api/inspection/upload-image', 'uploadImage')->name('api.inspection.upload-image');
});

// Image handling routes
Route::controller(ImageController::class)->group(function () {
    Route::post('/api/image/upload', 'upload')->name('api.image.upload');
    Route::get('/api/image/compress', 'compress')->name('api.image.compress');
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
Route::get('/test-pdf', function () {
    try {
        // Test basic PDF generation
        $pdf = Barryvdh\DomPDF\Facade\Pdf::loadHTML('<h1>Test PDF Generation</h1><p>This is a test PDF generated at ' . now() . '</p>');
        
        // Test storage directory creation
        $filename = 'test_pdf_' . date('Y-m-d_H-i-s') . '.pdf';
        $path = 'test-reports/' . $filename;
        
        // Generate PDF content
        $pdfContent = $pdf->output();
        
        // Try to store the PDF
        Storage::disk('public')->put($path, $pdfContent);
        
        return response()->json([
            'success' => true,
            'message' => 'PDF test successful',
            'filename' => $filename,
            'path' => $path,
            'file_size' => strlen($pdfContent),
            'storage_path' => storage_path('app/public/' . $path)
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
    }
});

// Report routes
Route::get('/inspection/report', [App\Http\Controllers\ReportController::class, 'show'])->name('inspection.report');
Route::post('/inspection/report/pdf', [App\Http\Controllers\ReportController::class, 'generatePDF'])->name('inspection.report.pdf');
Route::post('/inspection/report/email', [App\Http\Controllers\ReportController::class, 'emailReport'])->name('inspection.report.email');

// Report management routes
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{id}/download', [App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');
Route::get('/reports/{id}/view', [App\Http\Controllers\ReportController::class, 'view'])->name('reports.view');
Route::delete('/reports/{id}', [App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.destroy');