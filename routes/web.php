<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\RfidController;
use App\Http\Controllers\MyKadController;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GuardController;
use App\Http\Controllers\Admin\VisitorLogController;
use App\Http\Controllers\Admin\RfidCardController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Visitor Routes
Route::controller(VisitorController::class)->group(function () {
    Route::get('/visitor-registration', 'showRegistrationForm')->name('visitor.registration');
    Route::post('/rfid-registration', 'register')->name('visitor.register');
    Route::post('/visitor-checkin', 'checkIn')->name('visitor.checkin');
});

// Visit Routes
Route::controller(VisitController::class)->group(function () {
    Route::get('/checkins', 'index')->name('checkins.index');
    Route::get('/checkout', 'listVisits')->defaults('type', 'checkouts');
    Route::post('/checkout', 'checkout');
    Route::post('/checkins/{visit}/checkout', 'checkout')->name('checkins.checkout');
    Route::get('/checkins/{visit}', 'show')->name('checkins.show');
});

// RFID API Routes
Route::controller(RfidController::class)->group(function () {
    Route::get('/api/inactive-rfids', 'getInactiveRfids');
});


// MyKad Routes
Route::controller(MyKadController::class)->group(function () {
    Route::get('/mykad-direct-proxy', 'proxyReader');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication Routes (Guest only)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminController::class, 'login']);
    });

    // Protected Routes (Authenticated admin)
    Route::middleware('auth:admin')->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Admin Management Routes (CRUD)
        Route::get('/admins', [AdminController::class, 'showAdmins'])->name('admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');

        // Guards Management Routes (CRUD)
        Route::get('/guards', [GuardController::class, 'index'])->name('guards.index');
        Route::get('/guards/create', [GuardController::class, 'create'])->name('guards.create');
        Route::post('/guards', [GuardController::class, 'store'])->name('guards.store');
        Route::get('/guards/{user}/edit', [GuardController::class, 'edit'])->name('guards.edit');
        Route::put('/guards/{user}', [GuardController::class, 'update'])->name('guards.update');
        Route::delete('/guards/{user}', [GuardController::class, 'destroy'])->name('guards.destroy');

        // Visitor Logs
        Route::get('/visitor-logs', [VisitorLogController::class, 'index'])->name('visitor-logs.index');

        // RFID Cards
        Route::get('/rfid-cards', [RfidCardController::class, 'index'])->name('rfid-cards.index');
        Route::get('/rfid-cards/create', [RfidCardController::class, 'create'])->name('rfid-cards.create'); // ✅ NEW: add this
        Route::post('/rfid-cards', [RfidCardController::class, 'store'])->name('rfid-cards.store');
        Route::delete('/rfid-cards/{rfid}', [RfidCardController::class, 'destroy'])->name('rfid-cards.destroy');

        // Logout
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});


// Test Poll Route
Route::get('/test-poll', function () {
    return response()->json([
        'message' => 'Test successful',
        'time' => now()->toDateTimeString()
    ]);
});
