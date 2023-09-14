<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*  Admin Route  */
Route::prefix('admin')->group(function (){
    Route::get('/login', [AdminController::class, 'index'])
    ->name('admin.login');

    Route::post('/login', [AdminController::class, 'store'])
    ->name('submit.login');

    Route::middleware('admin')->group(function () {
        Route::post ('/logout', [AdminController::class, 'AdminLogout'])
                ->name('admin.logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard.index');
        Route::get('/programs', [ProgramController::class, 'index'])
                ->name('programs.index');
        Route::get('/programs/create', [ProgramController::class, 'create'])
                ->name('programs.create');
        Route::post('/programs', [ProgramController::class, 'store'])
                ->name('programs.store');
        Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])
                ->name('programs.edit');
        Route::put('/programs/{program}', [ProgramController::class, 'update'])
                ->name('programs.update');
        Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])
                ->name('programs.destroy');
        Route::get('/programs/{program}/participants', [ProgramController::class, 'showParticipants'])
                ->name('programs.participants');
        Route::get('/programs/{program}/export', [ProgramController::class, 'exportPDF'])
                ->name('programs.export');
        Route::get('/programs/{program}/export-excel', [ProgramController::class, 'exportExcel'])
                ->name('programs.export-excel');
        Route::put('/programs/{program}/form', [ProgramController::class, 'updateForm'])
                ->name('program.form');
        Route::get('/profiles', [AdminController::class, 'edit'])
                ->name('admin.profile.edit');
        Route::patch('/profiles', [AdminController::class, 'update'])
                ->name('admin.profile.update');
        Route::delete('/profiles', [AdminController::class, 'destroy'])
                ->name('admin.profile.destroy');
        Route::put('password', [AdminController::class, 'updatePassword'])
                ->name('admin.password.update');
        Route::get('/admin-list', [AdminController::class, 'newAdmin'])
                ->name('admin.new-admin');
        Route::get('/users-list', [AdminController::class, 'listuser'])
                ->name('admin.users-list');
        Route::post('/admin-add/store', [AdminController::class, 'storeAdmin'])
                ->name('admin.storeAdmin');
        Route::post('/substitute/{admin}', [AdminController::class, 'substitute'])
                ->name('admin.substitute');
        Route::get('/reports', [ReportController::class, 'index'])
                ->name('reports.index');
        Route::match(['PUT', 'POST'], 'programs/{program}/toggle-status', [ProgramController::class, 'toggleStatus'])
                ->name('programs.toggle-status');

    });

});

Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])
                ->name('dashboard');
    Route::post('/apply-program/{program}', [UserController::class, 'applyProgram'])
                ->name('user.applyProgram');

    Route::post('/submit-attendance', [UserController::class, 'submitAttendance'])
                ->name('user.submitAttendance');

    Route::get('/profile', [ProfileController::class, 'edit'])
                ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
                ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
                ->name('profile.destroy');

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
                ->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
Route::post('/login', [WelcomeController::class, 'login'])->name('welcome.login');
Route::get('/register', [WelcomeController::class, 'daftar'])->name('welcome.register');
Route::post('/register', [WelcomeController::class, 'register'])->name('register.store');

Route::get('/guest', [WelcomeController::class, 'guest'])->name('welcome.guest');
Route::post('/guest', [WelcomeController::class, 'guestRegister'])->name('store.guest');



