<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Master\CoaController;
use App\Http\Controllers\Admin\Master\EmployeeController;
use App\Http\Controllers\Admin\Master\MaterialController;
use App\Http\Controllers\Admin\Master\OverheadController;
use App\Http\Controllers\Admin\Master\SupplierController;
use App\Http\Controllers\Admin\Master\TeamController;

Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('admin.index');

    // Route::resource('users', UserController::class)->except(['show', 'create']);
    // Route::resource('teams', TeamController::class)->except(['show', 'create']);
    // Route::resource('employees', EmployeeController::class)->except(['show', 'create']);
    // Route::resource('supplier', SupplierController::class)->except(['show', 'create']);

    Route::group(['prefix' => 'master', 'as' => 'master.'], function() {
        Route::resource('coa', CoaController::class)->except(['show', 'create']);
        Route::get('material/{type}/index', [MaterialController::class, 'index'])->name('material.index');
        Route::resource('material', MaterialController::class)->except(['show', 'create', 'index']);
        Route::get('overhead/{type}/index', [OverheadController::class, 'index'])->name('overhead.index');
        Route::resource('overhead', OverheadController::class)->except(['show', 'create', 'index']);
        Route::resource('team', TeamController::class)->except(['show', 'create']);
        Route::resource('employee', EmployeeController::class)->except(['show', 'create']);
        Route::resource('supplier', SupplierController::class)->except(['show', 'create']);
    });

    Route::group(['prefix' => 'material', 'as' => 'material.'], function() {
        // Route::get('', [MaterialController::class, 'index'])->name('index');
        // Route::get('buy', [MaterialController::class, 'buy_index'])->name('buy');
        // Route::get('sell', [MaterialController::class, 'sell_index'])->name('sell');

        // Route::post('buy', [MaterialController::class, 'buy_store'])->name('buy.store');
        // Route::post('sell', [MaterialController::class, 'sell_store'])->name('sell.store');

        // Route::get('pembelian/print/{id}', [MaterialController::class, 'print_pembelian'])->name('buy.print');
    });
});

Route::get('dev/nota', function() {
    return view('pages.admin.print.nota-pembelian');
});
