<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RouteScheduleController;
use App\Http\Controllers\RouteDestinationController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleRouteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthenticationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->group(function () {
    Route::resource('journey-routes', RouteController::class);
    Route::resource('route-schedules', RouteScheduleController::class);
    Route::get('route-schedules/for/{route_id}', [RouteScheduleController::class, 'getRouteSchedules']);
    Route::resource('route-destinations', RouteDestinationController::class);
    Route::resource('vehicle-categories', VehicleCategoryController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::get('vehicles/for/{route_id}', [VehicleController::class, 'getRouteVehicles']);
    Route::post('vehicles-routes/{vehicle}', [VehicleRouteController::class, 'attributeRouteToVehicle']);
    Route::resource('reservations', ReservationController::class);
    Route::resource('tickets', TicketController::class);
    Route::post('make-payment/{reservation}', [PaymentController::class, 'handlePayment'])->name('payment.post');
    Route::post('agency-settings', [SettingController::class, 'registerAgencyDetails']);
    Route::post('agency-settings/update', [SettingController::class, 'updateAgencyDetails']);
// });