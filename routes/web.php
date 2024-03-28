<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\EnsureIsAdmin;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('transaction/import', [
        TransactionController::class,
        'showImportForm',
    ])->name('transaction.import');

    Route::post('transaction/import', [
        TransactionController::class,
        'importFromCsv',
    ])->name('transaction.import.csv');

    // resource method generates several common routes used for Restful controllers
    Route::resource('transaction', TransactionController::class);
});

Route::middleware([EnsureIsAdmin::class, 'auth'])->group(function () {
    Route::resource('bucket', BucketController::class);
});

Route::get('/login', [UsersController::class, 'login'])->name('login');
Route::post('/login', [UsersController::class, 'authenticate']);
Route::get('/register', [UsersController::class, 'create'])->name('register');
Route::post('/register', [UsersController::class, 'store']);
Route::post('/', [UsersController::class, 'logout'])->name('logout');
