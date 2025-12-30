<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\Admin\AdminDriverController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Payment callbacks
Route::match(['get', 'post'], '/payments/chapa/callback', [PaymentController::class, 'chapaCallback'])->name('payments.chapa.callback');

// Car browsing (public - no login required, but not for admin)
Route::middleware('not_superadmin')->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'changePassword'])->name('profile.password');

    // Customer dashboard
    Route::get('/dashboard', function () {
        // Redirect admin users to admin dashboard
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard')->middleware('auth');

    // Customer routes (not for admin)
    Route::middleware(['auth', 'not_superadmin'])->group(function () {
        // Reservations
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
        Route::get('/reservations/{reservation}/payment', [PaymentController::class, 'create'])->name('reservations.payment');
        Route::post('/reservations/{reservation}/payment', [PaymentController::class, 'store'])->name('reservations.payment.process');
        Route::get('/reservations/{reservation}/receipt', [PaymentController::class, 'receipt'])->name('reservations.receipt');

        // Rentals (customer view)
        Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
        Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
        Route::get('/rentals/{rental}/return', [RentalController::class, 'returnForm'])->name('rentals.return.form');
        Route::post('/rentals/{rental}/return', [RentalController::class, 'submitReturn'])->name('rentals.return.submit');
        Route::post('/rentals/{rental}/overdue/checkout', [RentalController::class, 'startOverduePayment'])->name('rentals.overdue.checkout');

        // Complaints
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
        Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
        Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    });
});

// Shared Admin routes (All admin roles)
Route::middleware(['auth', 'any_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    // Complaints Management
    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{complaint}/resolve', [AdminComplaintController::class, 'resolve'])->name('complaints.resolve');
});

// Admin routes (Staff and Manager only - NOT super admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Car management
    Route::get('/cars', [CarController::class, 'adminIndex'])->name('cars.index');
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::patch('/cars/{car}/toggle-availability', [CarController::class, 'toggleAvailability'])->name('cars.toggle-availability');

    // Reservation management
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.update-status');
    Route::patch('/reservations/{reservation}/convert-to-rental', [ReservationController::class, 'convertToRental'])->name('reservations.convert-to-rental');
    Route::patch('/reservations/{reservation}/payments/approve', [ReservationController::class, 'approvePayment'])->name('reservations.payments.approve');
    Route::patch('/reservations/{reservation}/payments/reset', [ReservationController::class, 'resetPayment'])->name('reservations.payments.reset');
    Route::patch('/reservations/{reservation}/assign-driver', [ReservationController::class, 'assignDriver'])->name('reservations.assign-driver');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Rental management
    Route::get('/rentals', [RentalController::class, 'adminIndex'])->name('rentals.index');
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::patch('/rentals/{rental}/status', [RentalController::class, 'updateStatus'])->name('rentals.update-status');
    Route::patch('/rentals/{rental}/return', [RentalController::class, 'processReturn'])->name('rentals.process-return');
    Route::patch('/rentals/{rental}/return/approve', [RentalController::class, 'approveReturn'])->name('rentals.return.approve');
    Route::patch('/rentals/{rental}/overdue/pay', [RentalController::class, 'markOverduePaid'])->name('rentals.overdue.pay');
    Route::delete('/rentals/{rental}', [RentalController::class, 'destroy'])->name('rentals.destroy');
    Route::get('/returns', [RentalController::class, 'returnManagement'])->name('returns.index');
    Route::patch('/returns/{rental}/approve', [RentalController::class, 'approveReturn'])->name('returns.approve');

    // Driver management
    Route::resource('drivers', AdminDriverController::class);
});

// Super Admin routes (Admin role only)
Route::middleware(['auth', 'superadmin'])->prefix('admin')->name('admin.')->group(function () {
    // User management (admin only)
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::put('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');

    // System settings management
    Route::get('/settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [\App\Http\Controllers\Admin\SystemSettingController::class, 'create'])->name('settings.create');
    Route::post('/settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'store'])->name('settings.store');
    Route::get('/settings/{setting}/edit', [\App\Http\Controllers\Admin\SystemSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{setting}', [\App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/{setting}', [\App\Http\Controllers\Admin\SystemSettingController::class, 'destroy'])->name('settings.destroy');

    // Activity logs
    Route::get('/logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{log}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('logs.show');
    Route::post('/logs/clear', [\App\Http\Controllers\Admin\ActivityLogController::class, 'clear'])->name('logs.clear');
});

// Manager-only routes
Route::middleware(['auth', 'manager'])->prefix('admin')->name('admin.')->group(function () {
    // Additional manager-specific routes can be added here
    // Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});
