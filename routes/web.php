<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/test-pdf', function () {
    return Pdf::loadHTML('<h1>Test</h1>')->stream('test.pdf');
});

Route::get('/', function () {
    return view('welcome');
});
