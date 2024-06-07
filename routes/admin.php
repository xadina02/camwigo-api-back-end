<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\RouteScheduleController;
use App\Http\Controllers\Admin\RouteDestinationController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\VehicleRouteDestinationController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('agency-settings', [SettingController::class, 'registerAgencyDetails']); // For CamWiGo Super Admins
        Route::put('agency-settings/update', [SettingController::class, 'updateAgencyDetails']);
        Route::resource('vehicle-categories', VehicleCategoryController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('journey-routes', RouteController::class);
        Route::resource('route-destinations', RouteDestinationController::class);
        Route::resource('route-schedules', RouteScheduleController::class);
        Route::post('vehicles-route-destinations/{id}', [VehicleRouteDestinationController::class, 'attributeRouteToVehicle']);
        Route::delete('vehicles-route-destinations/remove/{id}', [VehicleRouteDestinationController::class, 'removeRouteFromVehicle']);
        Route::resource('reservations', ReservationController::class);
        Route::resource('tickets', TicketController::class);
        Route::controller(UserController::class)->prefix('manage-users')->group(function () {
            Route::get('/all', 'index');
            Route::get('/user/{id}', 'show');
            Route::post('/register', 'register');
            Route::put('/update/profile/{id}', 'update');
            Route::post('/account/delete/{id}', 'destroy');
        });
    });
    
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::get('/login', 'getLoginPage')->name('admin.login');
        Route::post('/login', 'login');
        Route::get('/logout', 'logout')->middleware('auth:sanctum');
    });
    
});