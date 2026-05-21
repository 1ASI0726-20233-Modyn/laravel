<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseTableController;
use App\Http\Controllers\ProductCatalogueController;

Route::get('/', fn() => view('home'))->name('home');

Route::get('/catalogue', [ProductCatalogueController::class, 'index'])->name('catalogue.index');

Route::get('/tables',        [DatabaseTableController::class, 'index'])->name('tables.index');
Route::get('/tables/{tabla}',[DatabaseTableController::class, 'show'])->name('tables.show');

Route::get   ('/tables/{tabla}/create',    [DatabaseTableController::class, 'create'])->name('records.create');
Route::post  ('/tables/{tabla}',           [DatabaseTableController::class, 'store'])->name('records.store');
Route::get   ('/tables/{tabla}/{id}/edit', [DatabaseTableController::class, 'edit'])->name('records.edit');
Route::put   ('/tables/{tabla}/{id}',      [DatabaseTableController::class, 'update'])->name('records.update');
Route::delete('/tables/{tabla}/{id}',      [DatabaseTableController::class, 'destroy'])->name('records.destroy');
