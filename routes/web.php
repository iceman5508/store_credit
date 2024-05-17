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
    return view('register');
})->name('register');



Route::middleware('auth')->prefix('dashboard/')->group(function(){

    Route::get('/addStore', [\App\Http\Controllers\StoreController::class,'addStore'])->name('addStore');
    Route::post('/stores', [\App\Http\Controllers\StoreController::class,'store'])->name('stores');
    Route::get('/deleteStore/{id}', [\App\Http\Controllers\StoreController::class,'destroy'])->name('deleteStore');
    Route::get('/storeLogin/{id}', [\App\Http\Controllers\StoreController::class,'storeLogin'])->name('storeLogin');

    Route::middleware('storeSelected')->group(function(){

        Route::post('select_subscription', [\App\Http\Controllers\PaymentController::class, 'payment'])->name('payment');

        Route::post('/save-customer', [\App\Http\Controllers\CustomerController::class, 'saveCustomer'])->name('saveCustomer');

        Route::post('/save-transaction', [\App\Http\Controllers\CustomerController::class, 'saveTransaction'])->name('saveTransaction');

        Route::patch('/update-user/{id}', [\App\Http\Controllers\CustomerController::class, 'updateUser'])->name('updateUser');

        Route::get('/customer-detail/{id}', [\App\Http\Controllers\CustomerController::class, 'details'])->name('customerDetail');

        Route::get('/customer-detail/{id}', [\App\Http\Controllers\CustomerController::class, 'details'])->name('customerDetail');

        Route::prefix('settings/')->group(function() {
            Route::get('/fields', [\App\Http\Controllers\FieldController::class, 'index'])->name('fields');
            Route::post('/fields', [\App\Http\Controllers\FieldController::class, 'toggleField'])->name('toggleField');
            Route::post('/userField/{user}', [\App\Http\Controllers\CustomerController::class, 'toggleUserField'])->name('toggleUserField');
            Route::post('/addField', [\App\Http\Controllers\FieldController::class, 'addField'])->name('addField');

        });

        Route::prefix('members/')->group(function() {
            Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
            Route::get('/transactions', [\App\Http\Controllers\CustomerController::class, 'transactions'])->name('transactions');
            Route::get('/employees', [\App\Http\Controllers\StoreController::class, 'index'])->name('employees');
            Route::post('/employees', [\App\Http\Controllers\StoreController::class, 'addEmployee'])->name('addEmployee');

        });

    });


});

