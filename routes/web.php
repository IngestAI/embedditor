<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FileEditorController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LibraryController::class, 'index'])->name('web::library::index');

Route::post('/save', [LibraryController::class, 'save'])->name('web::library::save');

Route::group(['prefix' => '/file'], function () {
    Route::post('/upload', [FileController::class, 'upload'])->name('web::file::upload');
    Route::get('/download/{key}', [FileController::class, 'download'])->name('web::file::download');
    Route::get('/view/{library_file}', [FileController::class, 'view'])->name('web::file::view');
    Route::get('/delete/{library_file}', [FileController::class, 'delete'])->name('web::file::delete');
    Route::get('/chunks/{library_file}', [FileController::class, 'chunks'])->name('web::file::chunks');

    Route::get('/chunks/edit/{library_file}', [FileEditorController::class, 'chunksEdit'])->name('web::file::chunks::edit');
    Route::put('/chunks/edit/{library_file}', [FileEditorController::class, 'chunksUpdate'])->name('web::file::chunks::update');
});
