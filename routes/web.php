<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('transaction/import', [TransactionController::class, 'showImportForm'])->name('transaction.import');
Route::post('transaction/import', [TransactionController::class, 'importFromCsv'])->name('transaction.import.csv');

// resource method generates several common routes used for Restful controllers
Route::resource('transaction', TransactionController::class);

