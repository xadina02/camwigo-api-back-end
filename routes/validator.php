<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Validator\RouteController;
use App\Http\Controllers\Validator\RouteScheduleController;
use App\Http\Controllers\Validator\RouteDestinationController;
use App\Http\Controllers\Validator\AuthController;
use App\Http\Controllers\Validator\VehicleController;
use App\Http\Controllers\Validator\ValidationController;

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

Route::prefix('validator')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(RouteController::class)->group(function () {
            Route::get('routes/all', 'getAllRoutes');
            Route::get('routes/search', 'searchRoutes');
        });

        Route::controller(RouteDestinationController::class)->group(function () {
            Route::get('route-destinations/{route_id}/all', 'getRouteDestinationList');
            Route::get('route-destinations/{route_id}/search', 'searchRouteDestinations');
        });

        Route::get('route-schedules/{route_destination_id}', [RouteScheduleController::class, 'getRouteSchedules']);

        Route::controller(VehicleController::class)->group(function () {
            Route::get('schedule-vehicles/{route_schedule_id}', 'getAllScheduleVehicles');
        });

        Route::controller(ValidationController::class)->group(function () {
            Route::post('validate', 'validateTicket');
        });
    });

    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('/login', 'login');
        Route::get('/logout', 'logout')->middleware('auth:sanctum');
    });
});
