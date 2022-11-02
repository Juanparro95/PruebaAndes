<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BlogController::class, 'index'])->name('index');


// Route::resource('/laravel', )->names('laravel');
Route::post('/get_card', [BlogController::class, 'get_data'])->name('get_card');
Route::post('/store', [BlogController::class, 'store'])->name('store');
Route::post('/destroy', [BlogController::class, 'destroy'])->name('destroy');
Route::post('/update', [BlogController::class, 'update'])->name('update');