<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureUserIsApproved;
use Illuminate\Support\Facades\Auth;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AppController::class, 'welcome'])->name('welcome');
Route::fallback([AppController::class, 'notFound']);

Route::middleware(['auth', EnsureUserIsApproved::class])->group(function () {
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
    Route::resource('users', UserController::class);
    Route::get('approvals', [UserController::class, 'index'])->name(
        'approvals'
    );
    Route::post('approvals/{user}', [UserController::class, 'approve'])->name(
        'approve'
    );
});

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate']);
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store']);
Route::post('/', [UserController::class, 'logout'])->name('logout');
Route::get('/pending_approval', function () {
    return view('errors.pending_approval');
})->name('errors.pending_approval');
