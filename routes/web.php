<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/pupuk', function () {
    return view('dashboard');
});

Route::get('/vm', function () {
    return view('vehicle-management');
});

Route::get('/field-inspection', function () {
    return view('field-inspection');
});
