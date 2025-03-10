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

// // Homepage route
// Route::get('/', function () {
//     return view('welcome');
// });

// // Route to handle all english paths
// Route::get('/en/{any}', function () {
//     return view('welcome');
// })->where('any', '.*');

// // Route just for the /en path
// Route::get('/en', function() {
//     return view('welcome');
// });

// // Route for all the other paths
// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any', '.*');

// Route to get a sent mail preview
Route::get('/mail-preview', [\App\Http\Controllers\APIController::class, 'previewEmail']);

Route::post('paypal', [PaypalController::class, 'paypal'])->name('paypal');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('cancel');