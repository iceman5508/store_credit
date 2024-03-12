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

Route::get('/',[App\Http\Controllers\HomeController::class, 'index']);



Auth::routes();


Route::get('/register', function (){
    return redirect(\route('login'));
})->name('register');

Route::get('/addStore', [\App\Http\Controllers\Auth\RegisterController::class,'showRegistrationForm'])->name('addStore');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/save-customer', [\App\Http\Controllers\CustomerController::class, 'saveCustomer'])->name('saveCustomer');

Route::post('/save-transaction', [\App\Http\Controllers\CustomerController::class, 'saveTransaction'])->name('saveTransaction');

Route::patch('/update-user/{id}', [\App\Http\Controllers\CustomerController::class, 'updateUser'])->name('updateUser');

Route::get('/customer-detail/{id}', [\App\Http\Controllers\CustomerController::class, 'details'])->name('customerDetail');
