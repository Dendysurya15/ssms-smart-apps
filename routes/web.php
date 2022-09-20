<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PupukController;
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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index_login'])->name('login');
Route::get('/register', [App\Http\Controllers\HomeController::class, 'index_registration'])->name('register');
// Auth::routes();

Route::post('/auth_login', [App\Http\Controllers\HomeController::class, 'auth_login'])->name('auth_login');
Route::post('/auth_registration', [App\Http\Controllers\HomeController::class, 'auth_registration'])->name('auth_registration');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', [HomeController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard_taksasi', [DashboardController::class, 'ds_taksasi'])->name('dash_est');
    Route::get('dashboard_taksasi_afdeling', [DashboardController::class, 'ds_taksasi_afdeling'])->name('dash_afd');
    Route::post('getDataTakEst15Days', [DashboardController::class, 'getTakEst15Days'])->name('getDataTakEst15Days');
    Route::post('getNameEstate', [DashboardController::class, 'getNameEstate'])->name('getNameEstate');
    Route::post('getDataAfdeling', [DashboardController::class, 'getDataAfd'])->name('getDataAfdeling');
    Route::post('getLoadRegional', [DashboardController::class, 'getDataRegional'])->name('getLoadRegional');
    Route::get('dashboard_pemupukan', [DashboardController::class, 'ds_pemupukan'])->name('dash_pemupukan');
    Route::resource('pupuk', PupukController::class);
});

Route::get('/dashboard_vehicle_management', function () {
    return view('vehicle-management');
});
Route::get('/dashboard_field_inspection', function () {
    return view('field-inspection');
});
