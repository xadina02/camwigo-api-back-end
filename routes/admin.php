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
use App\Http\Controllers\PaymentController;
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
    // Route::middleware('auth:sanctum', 'admin')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            Route::post('agency-settings', 'registerAgencyDetails'); // For CamWiGo Super Admins
            Route::put('agency-settings/update', 'updateAgencyDetails');
        });
        Route::resource('vehicle-categories', VehicleCategoryController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('journey-routes', RouteController::class);
        Route::resource('route-destinations', RouteDestinationController::class);
        Route::resource('route-schedules', RouteScheduleController::class);
        Route::resource('vehicles-route-destinations', VehicleRouteDestinationController::class);
        Route::controller(VehicleRouteDestinationController::class)->group(function () {
            Route::get('travel-journeys', 'showAllJourneySchedules')->name('travelJourneys');
            Route::post('vehicles-route-destinations/attribute/{id}', 'attributeRouteToVehicle')->name('attributeRouteToVehicle');
            Route::delete('vehicles-route-destinations/remove/{id}', 'removeRouteFromVehicle');
        });
        Route::resource('reservations', ReservationController::class);
        Route::resource('tickets', TicketController::class);
        Route::controller(UserController::class)->prefix('manage-users')->group(function () {
            Route::get('/all', 'index');
            Route::get('/user/{id}', 'show');
            Route::post('/register', 'register');
            Route::put('/update/profile/{id}', 'update');
            Route::post('/account/delete/{id}', 'destroy');
        });
        Route::controller(PaymentController::class)->group(function () {
            Route::get('make-payment', 'handleGet');
            Route::post('make-payment/{reservation}', 'handlePayment')->name('payment.post');
        });
    // });

    Route::controller(AuthController::class)->prefix('auth')->middleware('web')->group(function () {
        Route::post('/login', 'login');
        Route::get('/logout', 'logout')->middleware('auth:sanctum', 'admin');
    });
    
});
