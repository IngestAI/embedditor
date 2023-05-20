<?php

use App\Http\Controllers\FileController;
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

Route::post('/file/upload', [FileController::class, 'upload'])->name('web::file::upload');
Route::get('/file/download/{id}', [FileController::class, 'download'])->name('web::file::download');
