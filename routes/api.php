<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RouteScheduleController;
use App\Http\Controllers\RouteDestinationController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleController;
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

Route::prefix('{version}/{lang}')->group(function () {
    Route::prefix('users')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('route-schedules', [RouteScheduleController::class, 'getRouteSchedules']);
            Route::get('route-schedules/for/{route_id}', [RouteScheduleController::class, 'getRouteScheduleLink']);
            Route::resource('vehicles', VehicleController::class);
            Route::get('vehicles/for/{route_id}', [VehicleController::class, 'getRouteVehicles']);
            // Route::resource('vehicle-categories', VehicleCategoryController::class);
            Route::get('route-destinations', [RouteDestinationController::class, 'getRouteDestination']);
            Route::resource('reservations', ReservationController::class);
            Route::get('journey-routes', [RouteController::class, 'getRouteDetails']);
            Route::resource('tickets', TicketController::class);
            Route::get('tickets/all', [TicketController::class, 'getMyTickets']);
            Route::post('make-payment/{reservation}', [PaymentController::class, 'handlePayment'])->name('payment.post');
        });

        Route::controller(AuthenticationController::class)->prefix('auth')->group(function () {
            Route::post('/register', 'register');
            Route::put('/update/profile', 'update')->middleware('auth:sanctum');
            Route::get('/logout', 'logout')->middleware('auth:sanctum');
            Route::post('/account/delete', 'destroy')->middleware('auth:sanctum');
        });
    });

    require __DIR__ . '/admin.php';
});