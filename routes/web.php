<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ClientSystemController;
use App\Http\Controllers\User\CoachController;
use App\Http\Controllers\User\ExerciseController;
use App\Http\Controllers\User\PlanController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SuscriptionController;
use App\Http\Controllers\User\TrainingSessionController;
use App\Http\Controllers\User\UserClientController;
use App\Http\Controllers\User\UserController;
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
    Route::get('clients/{client}/system',[UserClientController::class,'createSystem'])->name('clients.create_system');
    Route::post('clients/{client}/system',[UserClientController::class,'storeSystem'])->name('clients.store_system');
    Route::get('clients/{client}/edit/system',[UserClientController::class,'editSystem'])->name('clients.edit_system');
    Route::patch('clients/{client}/edit/system',[UserClientController::class,'updateSystem'])->name('clients.update_system');
    Route::delete('clients/{client}/destroy/system',[UserClientController::class,'destroySystem'])->name('clients.destroy_system');

    //USER - CLIENT SUSCRIPTION
    Route::get('clients/{client}/suscription',[UserClientController::class,'createSuscription'])->name('clients.createSuscription');
    Route::post('clients/{client}/suscription',[UserClientController::class,'storeSuscription'])->name('clients.storeSuscription');
    Route::get('clients/{client}/edit/{id}/suscription',[UserClientController::class,'showSuscription'])->name('clients.showSuscription');
    Route::patch('clients/{client}/edit/{id}/suscription',[UserClientController::class,'cancelSuscription'])->name('clients.cancelSuscription');
    Route::get('clients/{client}/suscription-invoice/{id}',[UserClientController::class,'suscriptionInvoice'])->name('clients.suscriptionInvoice');

    // USER - CLIENT TRAINING SESSIONS
    Route::get('clients/{client}/training-sessions/',[UserClientController::class , 'assignAttendance'])->name('clients.assignAttendanceTrainingSessions');
    Route::post('clients/{client}/training-sessions/',[UserClientController::class , 'storeAttendance'])->name('clients.storeAttendanceTrainingSession');
    Route::get('clients/{client}/training-sessions/{id}',[UserClientController::class , 'attendaceShow'])->name('clients.showAttendanceTrainingSession');
    Route::patch('clients/{client}/training-sessions/{id}',[UserClientController::class , 'registerAttendanceDate'])->name('clients.registerAttendanceDate');
    Route::delete('clients/{client}/training-sessions/delete/{id}',[UserClientController::class , 'destroyAttendace'])->name('clients.destroyAttendanceTrainingSession');

    // USER - CLIENT PURCHASES
    Route::get('clients/{client}/purchase',[UserClientController::class , 'createPurchase'])->name('clients.createPurchase');
    Route::post('clients/{client}/purchase',[UserClientController::class , 'storePurchase'])->name('clients.storePurchase');
    Route::get('clients/{client}/purchase/{id}',[UserClientController::class , 'showPurchase'])->name('clients.showPurchase');
    Route::patch('clients/{client}/purchase/{id}',[UserClientController::class , 'cancelPurchase'])->name('clients.cancelPurchase');
    Route::get('clients/{client}/purchase-invoice/{id}',[UserClientController::class,'purchaseInvoice'])->name('clients.purchaseInvoice');

    // USER - PRODUCTS
    Route::resource('/products',ProductController::class);
    Route::post('products/{product}/restore',[ProductController::class,'restore'])->name('products.restore');

    //USER -COACHES
    Route::resource('/coaches',CoachController::class);
    Route::post('coaches/{coach}/restore',[CoachController::class,'restore'])->name('coaches.restore');
    Route::get('coaches/{coach}/training-sessions/{id}',[CoachController::class,'showTrainingSessions'])->name('coaches.showTrainingSessions');  

    //USER - TRAINING SESSIONS
    Route::resource('/training-sessions',TrainingSessionController::class);
    Route::delete('training-sessions/{training_session}/disassociate-all-clients',[TrainingSessionController::class,'disassociateAllClients'])->name('training-sessions.disassociateAllClients');
    Route::delete('training-sessions/{training_session}/disassociate-all-exercises',[TrainingSessionController::class,'disassociateAllExercises'])->name('training-sessions.disassociateAllExercises');
    Route::delete('training-sessions/{training_session}/disassociate-all-coaches',[TrainingSessionController::class,'disassociateAllCoaches'])->name('training-sessions.disassociateAllCoaches');
    Route::resource('/exercises',ExerciseController::class)->except(['index']);
    //USERS 
    Route::resource('/users',UserController::class);
    Route::patch('users/{user}/update-password',[UserController::class,'updatePassword'])->name('users.updatePassword');
    Route::post('users/{user}/restore',[UserController::class,'restore'])->name('users.restore');

    //USERS - SUSCRIPTIONS
    Route::resource('/suscriptions',SuscriptionController::class);
    Route::get('suscriptions/{suscription}/invoice',[SuscriptionController::class,'suscriptionInvoice'])->name('suscriptions.suscriptionInvoice');
    Route::patch('suscriptions/{suscription}/cancel',[SuscriptionController::class,'cancelSuscription'])->name('suscriptions.cancelSuscription');

    //USERS - PLANS
    Route::resource('/plans',PlanController::class)->except(['index']);
}); 


require __DIR__.'/auth.php';
