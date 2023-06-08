<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ClientSystemController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserClientController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[ HomeController::class, 'create'])->name('homepage');
Route::post('/contact_send',[HomeController::class,'contactSendEmail'])->name('contact_us.sendEmail');

Route::get('/dashboard', function () {
    return Inertia::render('User/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // USER - CLIENT
    Route::resource('/clients',UserClientController::class);
    Route::post('clients/{client}/restore',[UserClientController::class,'restore'])->name('clients.restore');
    //Route::delete('clients/{client}/forceDelete',[UserClientController::class,'forceDelete'])->name('clients.forceDelete');

    //USER - CLIENT_SYSTEM
    Route::get('clients/{client}/system',[ClientSystemController::class,'create'])->name('clients.create_system');
    Route::post('clients/{client}/system',[ClientSystemController::class,'store'])->name('clients.store_system');
    Route::get('clients/{client}/edit/system',[ClientSystemController::class,'edit'])->name('clients.edit_system');
    Route::patch('clients/{client}/edit/system',[ClientSystemController::class,'update'])->name('clients.update_system');
    Route::delete('clients/{client}/destroy/system',[ClientSystemController::class,'destroy'])->name('clients.destroy_system');

});


require __DIR__.'/auth.php';
