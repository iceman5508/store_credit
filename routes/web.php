<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[App\Http\Controllers\HomeController::class, 'index'])->name('default');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();


Route::get('/register', function (){
    return redirect(\route('login'));
})->name('register');

Route::middleware('auth')->prefix('dashboard/')->group(function(){
    Route::get('/addStore', [\App\Http\Controllers\Auth\RegisterController::class,'showRegistrationForm'])->name('addStore');

    Route::post('/save-customer', [\App\Http\Controllers\CustomerController::class, 'saveCustomer'])->name('saveCustomer');

    Route::post('/save-transaction', [\App\Http\Controllers\CustomerController::class, 'saveTransaction'])->name('saveTransaction');

    Route::patch('/update-user/{id}', [\App\Http\Controllers\CustomerController::class, 'updateUser'])->name('updateUser');

    Route::get('/customer-detail/{id}', [\App\Http\Controllers\CustomerController::class, 'details'])->name('customerDetail');

    Route::get('/customer-detail/{id}', [\App\Http\Controllers\CustomerController::class, 'details'])->name('customerDetail');

    Route::prefix('settings/')->group(function() {
        Route::get('/fields', [\App\Http\Controllers\FieldController::class, 'index'])->name('fields');
        Route::post('/fields', [\App\Http\Controllers\FieldController::class, 'toggleField'])->name('toggleField');

        Route::post('/addField', [\App\Http\Controllers\FieldController::class, 'addField'])->name('addField');

    });

});

