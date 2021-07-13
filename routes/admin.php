<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Master\CoaController;
use App\Http\Controllers\Admin\Master\TeamController;
use App\Http\Controllers\Admin\Master\UserController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Master\ProductController;
use App\Http\Controllers\Admin\Master\CustomerController;
use App\Http\Controllers\Admin\Master\EmployeeController;
use App\Http\Controllers\Admin\Master\MaterialController;
use App\Http\Controllers\Admin\Master\OverheadController;
use App\Http\Controllers\Admin\Master\SupplierController;
use App\Http\Controllers\Admin\Transaction\SellingController;
use App\Http\Controllers\Admin\Report\ProductionReportController;
use App\Http\Controllers\Admin\Transaction\MaterialOutController;
use App\Http\Controllers\Admin\Transaction\ProductTransactionController;
use App\Http\Controllers\Admin\Transaction\MaterialTransactionController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
    Route::get('/', [HomeController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'master', 'as' => 'master.', 'middleware' => 'role:produksi|admin'], function() {
        Route::get('material/{type}/index', [MaterialController::class, 'index'])->name('material.index');
        Route::resource('material', MaterialController::class)->except(['show', 'create', 'index']);
        Route::get('overhead/{type}/index', [OverheadController::class, 'index'])->name('overhead.index');
        Route::resource('overhead', OverheadController::class)->except(['show', 'create', 'index']);
        Route::resource('team', TeamController::class)->except(['show', 'create']);
        Route::resource('employee', EmployeeController::class)->except(['show', 'create']);
        Route::resource('supplier', SupplierController::class)->except(['show', 'create']);
        Route::resource('product', ProductController::class)->except(['show', 'create']);
        Route::resource('customer', CustomerController::class)->except(['show', 'create']);
        Route::group(['middleware' => 'role:admin'], function() {
            Route::resource('coa', CoaController::class)->except(['show', 'create'])->middleware('role:admin');
            Route::resource('user', UserController::class)->except(['show', 'create'])->middleware('role:admin');
        });
    });

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function() {
        Route::group(['middleware' => 'role:admin'], function() {

        });
        Route::group(['middleware' => 'role:produksi'], function() {
            Route::put('selesai-produksi/{id}', [ProductTransactionController::class, 'selesaiProduksi'])->name('product.selesai');
            Route::get('selesai', [ProductTransactionController::class, 'indexSelesai'])->name('product.indexselesai');
        });
        Route::get('material/{type}/index', [MaterialTransactionController::class, 'index'])->name('material.index');
        Route::post('material', [MaterialTransactionController::class, 'store'])->name('material.store');
        Route::delete('material/{id}', [MaterialTransactionController::class, 'destroy'])->name('material.destroy');

        Route::get('material-out/{type}/index', [MaterialOutController::class, 'index'])->name('material-out.index');
        Route::resource('material-out', MaterialOutController::class)->except('index');

        Route::get('product', [ProductTransactionController::class, 'index'])->name('product.index');
        Route::get('product/create', [ProductTransactionController::class, 'create'])->name('product.create');
        Route::get('product/{id}', [ProductTransactionController::class, 'show'])->name('product.show');
        Route::post('product', [ProductTransactionController::class, 'store'])->name('product.store');
        Route::delete('product/{id}', [ProductTransactionController::class, 'destroy'])->name('product.destroy');
        Route::get('selling', [SellingController::class, 'index'])->name('selling.index');
        Route::post('selling', [SellingController::class, 'store'])->name('selling.store');
        Route::delete('selling/{id}', [SellingController::class, 'destroy'])->name('selling.destroy');
    });

    Route::group(['prefix' => 'report', 'as' => 'report.', 'middleware' => 'role:admin|pemilik'], function() {
        Route::get('material/{type}', [ReportController::class, 'material_index'])->name('material.index');
        Route::post('material/{type}', [ReportController::class, 'material_print'])->name('material.print');
        Route::get('stock/material/{type}', [ReportController::class, 'stock_material'])->name('stock.material');
        Route::post('stock/material/{id}', [ReportController::class, 'stock_material_post'])->name('stock.material.post');
        Route::get('selling', [ReportController::class, 'product_selling'])->name('selling.index');
        Route::post('selling', [ReportController::class, 'product_selling_print'])->name('selling.print');

        Route::get('storage', [ReportController::class, 'storage_index'])->name('storage.index');
        Route::post('storage/{id}', [ReportController::class, 'storage_post'])->name('storage.post');

        Route::get('arpin/babi', [ReportController::class, 'dev_babi']);
        Route::get('arpin/babi2', [ReportController::class, 'dev_babi2']);

        Route::get('harga-pokok-produksi', [ProductionReportController::class, 'index'])->name('production.index');
        Route::post('harga-pokok-produksi', [ProductionReportController::class, 'post'])->name('production.post');
        Route::get('harga-pokok-produksi-print', [ProductionReportController::class, 'post'])->name('production.print');
    });

});
