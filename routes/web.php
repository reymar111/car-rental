<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarColorController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CarOwnerController;
use App\Http\Controllers\CarRentalController;
use App\Http\Controllers\CarRentalRatingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\RentalPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RouteCitiesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return Inertia::render('Landing');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function() {

    Route::prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    })->middleware('is_admin');


    Route::get('/settings', function () {
        return Inertia::render('Settings');
    })->name('settings');

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions')->middleware('is_admin');
        Route::post('/release/{rental}', [TransactionController::class, 'release'])->name('transactions.release')->middleware('is_admin');
        Route::post('/return/{rental}', [TransactionController::class, 'return'])->name('transactions.return')->middleware('is_admin');
        Route::post('/confirm/{rental}', [TransactionController::class, 'confirm'])->name('transactions.confirm')->middleware('is_admin');
    });

    Route::prefix('owner')->group(function() {
        Route::get('/', [CarOwnerController::class, 'index'])->name('owner.index');
        Route::post('/store', [CarOwnerController::class, 'store'])->name('owner.store');
        Route::patch('/update/{owner}', [CarOwnerController::class, 'update'])->name('owner.update');
        Route::delete('/delete/{owner}', [CarOwnerController::class, 'destroy'])->name('owner.delete');
    });

    Route::prefix('car')->group(function() {
        Route::get('/', [CarsController::class, 'index'])->name('car.index');
        Route::post('/store', [CarsController::class, 'store'])->name('car.store');
        Route::patch('/update/{car}', [CarsController::class, 'update'])->name('car.update');
        Route::delete('/delete/{car}', [CarsController::class, 'destroy'])->name('car.delete');
    });

    Route::prefix('brand')->group(function() {
        Route::get('/', [CarBrandController::class, 'index'])->name('brand.index');
        Route::post('/store', [CarBrandController::class, 'store'])->name('brand.store');
        Route::patch('/update/{brand}', [CarBrandController::class, 'update'])->name('brand.update');
        Route::delete('/delete/{brand}', [CarBrandController::class, 'destroy'])->name('brand.delete');
    });

    Route::prefix('model')->group(function() {
        Route::get('/', [CarModelController::class, 'index'])->name('model.index');
        Route::post('/store', [CarModelController::class, 'store'])->name('model.store');
        Route::patch('/update/{model}', [CarModelController::class, 'update'])->name('model.update');
        Route::delete('/delete/{model}', [CarModelController::class, 'destroy'])->name('model.delete');
    });

    Route::prefix('color')->group(function() {
        Route::get('/', [CarColorController::class, 'index'])->name('color.index');
        Route::post('/store', [CarColorController::class, 'store'])->name('color.store');
        Route::patch('/update/{color}', [CarColorController::class, 'update'])->name('color.update');
        Route::delete('/delete/{color}', [CarColorController::class, 'destroy'])->name('color.delete');
    });

    Route::prefix('type')->group(function() {
        Route::get('/', [CarTypeController::class, 'index'])->name('type.index');
        Route::post('/store', [CarTypeController::class, 'store'])->name('type.store');
        Route::patch('/update/{type}', [CarTypeController::class, 'update'])->name('type.update');
        Route::delete('/delete/{type}', [CarTypeController::class, 'destroy'])->name('type.delete');
    });

    Route::prefix('payment_mode')->group(function() {
        Route::get('/', [PaymentModeController::class, 'index'])->name('payment_mode.index');
        Route::post('/store', [PaymentModeController::class, 'store'])->name('payment_mode.store');
        Route::patch('/update/{p_mode}', [PaymentModeController::class, 'update'])->name('payment_mode.update');
        Route::delete('/delete/{p_mode}', [PaymentModeController::class, 'destroy'])->name('payment_mode.delete');
    });

    Route::prefix('route')->group(function() {
        Route::get('/', [RoutesController::class, 'index'])->name('route.index');
        Route::post('/store', [RoutesController::class, 'store'])->name('route.store');
        Route::patch('/update/{route}', [RoutesController::class, 'update'])->name('route.update');
        Route::delete('/delete/{route}', [RoutesController::class, 'destroy'])->name('route.delete');
    });

    Route::prefix('route_city')->group(function() {
        Route::get('/', [RouteCitiesController::class, 'index'])->name('route_city.index');
        Route::post('/store', [RouteCitiesController::class, 'store'])->name('route_city.store');
        Route::patch('/update/{route}', [RouteCitiesController::class, 'update'])->name('route_city.update');
        Route::delete('/delete/{route}', [RouteCitiesController::class, 'destroy'])->name('route_city.delete');
    });

    Route::prefix('account')->group(function() {
        Route::get('/', [UsersController::class, 'index'])->name('account.index');
        Route::post('/store', [UsersController::class, 'store'])->name('account.store');
        Route::patch('/update/{user}', [UsersController::class, 'update'])->name('account.update');
        Route::delete('/delete/{user}', [UsersController::class, 'destroy'])->name('account.delete');
        Route::delete('/reset_password/{user}', [UsersController::class, 'reset_password'])->name('account.reset_password');
    });

    Route::prefix('rental')->group(function() {
        Route::get('/', [CarRentalController::class, 'index'])->name('rental.index')->middleware('is_client');
        Route::get('/create', [CarRentalController::class, 'create'])->name('rental.create');
        Route::post('/search_available_car', [CarRentalController::class, 'searchAvailableCar'])->name('rental.search');
        Route::post('/store', [CarRentalController::class, 'store'])->name('rental.store');
        Route::get('/show/{rental}', [CarRentalController::class, 'show'])->name('rental.show');
        Route::get('/edit/{rental}', [CarRentalController::class, 'edit'])->name('rental.edit');
        Route::patch('/update/{rental}', [CarRentalController::class, 'update'])->name('rental.update');
        Route::delete('/delete/{route}', [CarRentalController::class, 'destroy'])->name('rental.delete');
        Route::patch('/cancel/{rental}', [CarRentalController::class, 'cancel'])->name('rental.cancel');
    });

    Route::prefix('payment')->group(function() {
        Route::get('/create/{rental}', [RentalPaymentController::class, 'create'])->name('payment.create');
        Route::post('/store', [RentalPaymentController::class, 'store'])->name('payment.store');
    });

    Route::prefix('rating')->group(function() {
        Route::post('/store/{rental}', [CarRentalRatingController::class, 'store'])->name('rating.store');
    });

    Route::prefix('reports')->group(function() {
        Route::get('/', function () {
            return Inertia::render('Reports');
        })->name('reports');


        // revenues report
        Route::get('/revenues-report', function() {
            return Inertia::render('Reports/RevenueReport');
        })->name('report.revenue');

        Route::post('/revenues-report', [ReportController::class, 'RevenueReport'])->name('revenue');


        // booking report
        Route::get('/booking-report', function() {
            return Inertia::render('Reports/BookingReport');
        })->name('report.booking');

        Route::post('/booking-report', [ReportController::class, 'BookingReport'])->name('booking');

        // payment transactions report
        Route::get('/payment-transactions-report', function() {
            return Inertia::render('Reports/PaymentTransactionsReport');
        })->name('report.payment_transactions');

        Route::post('/payment-transactions-report', [ReportController::class, 'PaymentTransactionsReport'])->name('payment_transactions');

        // car utilization report
        Route::get('/car-utilization-report', function() {
            return Inertia::render('Reports/CarUtilizationReport');
        })->name('report.car_utilization');

        Route::post('/car-utilization-report', [ReportController::class, 'CarUtilizationReport'])->name('car_utilization_report');

        // car owner earning report
        Route::get('/car-owner-earning-report', function() {
            return Inertia::render('Reports/CarOwnerEarningReport');
        })->name('report.car_owner_earning');

        Route::post('/car-owner-earning-report', [ReportController::class, 'CarOwnerEarningReport'])->name('car_owner_earning_report');

        // customer feedback report
        Route::get('/customer-feedback', function() {
            return Inertia::render('Reports/CustomerFeedbackReport');
        })->name('report.customer_feedback');

        Route::post('/customer-feedback', [ReportController::class, 'CustomerFeedbackReport'])->name('customer_feedback');


        // car status report
        Route::get('/car-status', function() {
            return Inertia::render('Reports/CarStatus');
        })->name('report.car_status');

        Route::post('/car-status', [ReportController::class, 'CarStatusReport'])->name('car_status');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
