<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'produksi', 'middleware' => 'role:produksi', 'as' => 'production.'], function() {
    // Route::get('/', [HomeController::class, 'index'])->name('index');

});
