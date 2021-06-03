<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Master\CoaController;
use App\Http\Controllers\Admin\Master\CustomerController;
use App\Http\Controllers\Admin\Master\EmployeeController;
use App\Http\Controllers\Admin\Master\MaterialController;
use App\Http\Controllers\Admin\Master\OverheadController;
use App\Http\Controllers\Admin\Master\ProductController;
use App\Http\Controllers\Admin\Master\SupplierController;
use App\Http\Controllers\Admin\Master\TeamController;
use App\Http\Controllers\Admin\Master\UserController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Transaction\MaterialOutController;
use App\Http\Controllers\Admin\Transaction\MaterialTransactionController;
use App\Http\Controllers\Admin\Transaction\ProductTransactionController;

Route::group(['prefix' => 'admin', 'middleware' => 'role:admin|produksi'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'master', 'as' => 'master.'], function() {
        Route::resource('coa', CoaController::class)->except(['show', 'create'])->middleware('role:admin');
        Route::get('material/{type}/index', [MaterialController::class, 'index'])->name('material.index');
        Route::resource('material', MaterialController::class)->except(['show', 'create', 'index']);
        Route::get('overhead/{type}/index', [OverheadController::class, 'index'])->name('overhead.index');
        Route::resource('overhead', OverheadController::class)->except(['show', 'create', 'index']);
        Route::resource('team', TeamController::class)->except(['show', 'create']);
        Route::resource('employee', EmployeeController::class)->except(['show', 'create']);
        Route::resource('supplier', SupplierController::class)->except(['show', 'create']);
        Route::resource('user', UserController::class)->except(['show', 'create'])->middleware('role:admin');
        Route::resource('product', ProductController::class)->except(['show', 'create']);
        Route::resource('customer', CustomerController::class)->except(['show', 'create']);
    });

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function() {
        Route::get('material/{type}/index', [MaterialTransactionController::class, 'index'])->name('material.index');
        Route::post('material', [MaterialTransactionController::class, 'store'])->name('material.store');
        Route::delete('material/{id}', [MaterialTransactionController::class, 'destroy'])->name('material.destroy');

        Route::get('material-out/{type}/index', [MaterialOutController::class, 'index'])->name('material-out.index');
        Route::resource('material-out', MaterialOutController::class)->except('index');

        Route::get('product', [ProductTransactionController::class, 'index'])->name('product.index');
        Route::get('product/{id}', [ProductTransactionController::class, 'show'])->name('product.show');
        Route::get('product/create', [ProductTransactionController::class, 'create'])->name('product.create');
        Route::post('product', [ProductTransactionController::class, 'store'])->name('product.store');
        Route::delete('product/{id}', [ProductTransactionController::class, 'destroy'])->name('product.destroy');
    });

    Route::group(['prefix' => 'report', 'as' => 'report.', 'middleware' => 'role:admin'], function() {
        Route::get('material/{type}', [ReportController::class, 'material_index'])->name('material.index');
        Route::post('material/{type}', [ReportController::class, 'material_print'])->name('material.print');
    });

});
