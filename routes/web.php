<?php

use App\Http\Controllers\PaypalController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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

// Homepage route
// Route::get('/', function () {
//     return view('welcome');
// });

// Route to get a sent mail preview in browser
Route::get('/mail-preview', [\App\Http\Controllers\APIController::class, 'previewEmail']);

Route::post('paypal', [PaypalController::class, 'paypal'])->name('paypal');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('cancel');
