<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RouteScheduleController;
use App\Http\Controllers\RouteDestinationController;
use App\Http\Controllers\VehicleRouteDestinationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
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

Route::prefix('{version}/{lang}')->middleware('identify_parameters')->group(function () {
    Route::prefix('users')->group(function () {
        // Route::middleware('auth:sanctum')->group(function () {
        Route::controller(RouteController::class)->group(function () {
            Route::get('routes/all', 'getAllRoutes');
            Route::get('routes/search', 'searchRoutes');
        });

        Route::controller(RouteDestinationController::class)->group(function () {
            Route::get('route-destinations/{route_id}/all', 'getRouteDestinationList');
            Route::get('route-destinations/{route_id}/search', 'searchRouteDestinations');
        });

        Route::get('route-schedules/{route_destination_id}', [RouteScheduleController::class, 'getRouteSchedules']);

        Route::controller(VehicleRouteDestinationController::class)->group(function () {
            Route::get('journey-dates/{route_schedule_id}', 'getAllScheduleJourneyDates');
            Route::get('vehicle-journey/{route_schedule_id}/{journey_date}', 'getAllDateScheduleJourneys');
            Route::get('vehicle-journey/{id}', 'getScheduleJourneyDetails');
            Route::get('top-travels', 'getRecentTravelJourneys');
        });

        Route::controller(ReservationController::class)->group(function () {
            Route::post('reservation/{vehicle_route_destination_id}', 'store')->middleware('auth:sanctum');
            Route::delete('reservation/{id}', 'destroy');
        });

        Route::controller(PaymentController::class)->group(function () {
            Route::post('make-payment/{reservation}', 'handlePayment')->middleware('auth:sanctum');
        });

        Route::controller(TicketController::class)->group(function () {
            // Route to get all tickets
            Route::get('tickets/all', 'index')->middleware('auth:sanctum');
            Route::get('tickets/{id}', 'show')->middleware('auth:sanctum');
        });
        // });

        Route::controller(AuthenticationController::class)->prefix('auth')->group(function () {
            Route::post('/register', 'register')->name('login');
            Route::put('/update/profile', 'update')->middleware('auth:sanctum');
            Route::get('/logout', 'logout')->middleware('auth:sanctum');
            Route::post('/account/delete', 'destroy')->middleware('auth:sanctum');
        });
    });
});
