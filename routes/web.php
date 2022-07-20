<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourcesController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [ResourcesController::class, 'index'])->name('index');
    Route::prefix('resource')->name('resource.')->group( function () {
        Route::post('/store', [ResourcesController::class, 'store'])->name('store');
        Route::get('/{resource}/show', [ResourcesController::class, 'show'])->name('show');
        Route::put('/{resource}/update', [ResourcesController::class, 'update'])->name('update');
        Route::delete('/{resource}/destroy', [ResourcesController::class, 'destroy'])->name('destroy');
    });

});
