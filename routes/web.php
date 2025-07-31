<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/inspection/visual', function () {
    return view('visual-inspection');
});
Route::get('/inspection/body-panel', function () {
    return view('body-panel-assessment');
});
Route::get('/inspection/specific-areas', function () {
    return view('specific-area-images');
});
Route::get('/test', function () {
    return view('test-panel');
});
Route::get('/positioning-tool', function () {
    return view('panel-positioning-tool');
});