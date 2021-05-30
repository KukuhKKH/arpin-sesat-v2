<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Master\CoaController;
use App\Http\Controllers\Admin\Master\EmployeeController;
use App\Http\Controllers\Admin\Master\MaterialController;
use App\Http\Controllers\Admin\Master\OverheadController;
use App\Http\Controllers\Admin\Master\SupplierController;
use App\Http\Controllers\Admin\Master\TeamController;
use App\Http\Controllers\Admin\Master\UserController;
use App\Http\Controllers\Admin\Transaction\MaterialTransactionController;

Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'master', 'as' => 'master.'], function() {
        Route::resource('coa', CoaController::class)->except(['show', 'create']);
        Route::get('material/{type}/index', [MaterialController::class, 'index'])->name('material.index');
        Route::resource('material', MaterialController::class)->except(['show', 'create', 'index']);
        Route::get('overhead/{type}/index', [OverheadController::class, 'index'])->name('overhead.index');
        Route::resource('overhead', OverheadController::class)->except(['show', 'create', 'index']);
        Route::resource('team', TeamController::class)->except(['show', 'create']);
        Route::resource('employee', EmployeeController::class)->except(['show', 'create']);
        Route::resource('supplier', SupplierController::class)->except(['show', 'create']);
        Route::resource('user', UserController::class)->except(['show', 'create']);
    });

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function() {
        Route::get('material/{type}/index', [MaterialTransactionController::class, 'index'])->name('material.index');
        Route::post('material', [MaterialTransactionController::class, 'store'])->name('material.store');
        Route::delete('material/{id}', [MaterialTransactionController::class, 'destroy'])->name('material.destroy');
    });

});
