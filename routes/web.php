<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectionController;

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
    Route::post('/api/inspection/upload-image', 'uploadImage')->name('api.inspection.upload-image');
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