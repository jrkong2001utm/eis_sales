<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
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

// Route::get('/', function () {
//    return view('dasboard');
// });

Route::resource('/contact', SalesController::class);
Route::get('/', function() {
    return view('dashboard');
});

Route::get('/report', [SalesController::class, 'index'])->name('report');

Route::get('/dateBetween', [SalesController::class, 'dateBetween'])->name('dateBetween');

Route::get('/distinctProducts', [ProductController::class, 'getDistinctProducts'])->name('distinctProducts');

Route::get('/sales_dashboard', [SalesController::class, 'dashboard'])->name('sales_dashboard');

