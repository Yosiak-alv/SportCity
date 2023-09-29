<?php

use App\Http\Controllers\Coach\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Coach\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Coach\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Coach\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Coach\Auth\NewPasswordController;
use App\Http\Controllers\Coach\Auth\PasswordController;
use App\Http\Controllers\Coach\Auth\PasswordResetLinkController;

use App\Http\Controllers\Coach\Auth\VerifyEmailController;

use App\Http\Controllers\Coach\ProfileCoachController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('coach')->group(static function() {

    Route::middleware('guest:coach')->group(function () {
        /* Route::get('register', [RegisteredUserController::class, 'create'])
                    ->name('client.register');
    
        Route::post('register', [RegisteredUserController::class, 'store']); */
    
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
                    ->name('coach.login');
    
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                    ->name('coach.password.request');
    
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                    ->name('coach.password.email');
    
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->name('coach.password.reset');
    
        Route::post('reset-password', [NewPasswordController::class, 'store'])
                    ->name('coach.password.store');
    });
    
    Route::middleware('auth:coach')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
                    ->name('coach.verification.notice');
    
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('coach.verification.verify');
    
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                    ->middleware('throttle:6,1')
                    ->name('coach.verification.send');
    
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                    ->name('coach.password.confirm');
    
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
        Route::put('password', [PasswordController::class, 'update'])->name('coach.password.update');
    
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('coach.logout');
    });

    Route::middleware('auth:coach')->group(function() {

        Route::get('/dashboard',function () {
            return Inertia::render('Coach/CoachDashboard');
        })->name('coach.dashboard');
        
        Route::get('/profile', [ProfileCoachController::class, 'edit'])->name('coach.profile.edit');
        Route::patch('/profile', [ProfileCoachController::class, 'update'])->name('coach.profile.update');
        Route::delete('/profile', [ProfileCoachController::class, 'destroy'])->name('coach.profile.destroy');

    });

});




