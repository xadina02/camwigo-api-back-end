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
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\SettingController;

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
        Route::post('vehicles-routes/{vehicle}', [VehicleRouteDestinationController::class, 'attributeRouteToVehicle']);
        Route::resource('vehicles', VehicleController::class);
        Route::get('vehicles/for/{route_id}', [VehicleController::class, 'getRouteVehicles']);
        Route::resource('route-schedules', RouteScheduleController::class);
        Route::get('route-schedules/for/{route_id}', [RouteScheduleController::class, 'getRouteSchedules']);
        Route::resource('vehicle-categories', VehicleCategoryController::class);
        Route::resource('route-destinations', RouteDestinationController::class);
        Route::resource('journey-routes', RouteController::class);
        Route::resource('tickets', TicketController::class);
        Route::post('agency-settings', [SettingController::class, 'registerAgencyDetails']);
        Route::post('agency-settings/update', [SettingController::class, 'updateAgencyDetails']);
        Route::resource('reservations', ReservationController::class);
    });

    Route::controller(AuthenticationController::class)->prefix('auth')->group(function () {
        Route::post('/register', 'register');
        Route::put('/update/profile', 'update')->middleware('auth:sanctum');
        Route::get('/logout', 'logout')->middleware('auth:sanctum');
        Route::post('/account/delete', 'destroy')->middleware('auth:sanctum');
    });
});