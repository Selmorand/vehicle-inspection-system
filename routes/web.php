<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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