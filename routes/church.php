<?php

/*
|--------------------------------------------------------------------------
| Affiliate Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Admin

use App\Http\Controllers\ChurchController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::controller(ChurchController::class)->group(function () {
        Route::get('/church/all', 'index')->name('church.index');
        Route::get('/church/create', 'create')->name('church.create');
        Route::post('/church', 'store')->name('church.store');
        Route::post('/church/published', 'updatePublished')->name('church.published');
        Route::get('/church/{id}/edit', 'edit')->name('church.edit');
        Route::post('/church/{id}', 'update')->name('church.update');
        Route::get('/church/destroy/{id}', 'destroy')->name('church.destroy');
    });
});

//FrontEnd
Route::controller(ChurchController::class)->group(function () {
    Route::get('/donate/to/church', 'home')->name('church.home');
});
