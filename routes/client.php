<?php

use App\Http\Controllers\Client\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Client\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Client\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Client\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Client\Auth\NewPasswordController;
use App\Http\Controllers\Client\Auth\PasswordController;
use App\Http\Controllers\Client\Auth\PasswordResetLinkController;
use App\Http\Controllers\Client\Auth\RegisteredUserController;
use App\Http\Controllers\Client\Auth\VerifyEmailController;
use App\Http\Controllers\Client\ProfileClientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('client')->group(static function() {

    Route::middleware('guest:client')->group(function () {
        /* Route::get('register', [RegisteredUserController::class, 'create'])
                    ->name('client.register');
    
        Route::post('register', [RegisteredUserController::class, 'store']); */
    
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
                    ->name('client.login');
    
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                    ->name('client.password.request');
    
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                    ->name('client.password.email');
    
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->name('client.password.reset');
    
        Route::post('reset-password', [NewPasswordController::class, 'store'])
                    ->name('client.password.store');
    });
    
    Route::middleware('auth:client')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
                    ->name('client.verification.notice');
    
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('client.verification.verify');
    
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                    ->middleware('throttle:6,1')
                    ->name('client.verification.send');
    
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                    ->name('client.password.confirm');
    
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
        Route::put('password', [PasswordController::class, 'update'])->name('client.password.update');
    
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('client.logout');
    });

    Route::middleware('auth:client')->group(function() {

       /*  Route::get('/dashboard', function () {
            //dd('hola');
            return Inertia::render('Client/ClientDashboard');
        })->name('client.dashboard'); */

        Route::get('/dashboard',function () {
            return Inertia::render('Client/ClientDashboard');
        })->name('client.dashboard');
        
        Route::get('/profile', [ProfileClientController::class, 'edit'])->name('client.profile.edit');
        Route::patch('/profile', [ProfileClientController::class, 'update'])->name('client.profile.update');
        Route::delete('/profile', [ProfileClientController::class, 'destroy'])->name('client.profile.destroy');

    });

});


