<?php

use Illuminate\Support\Facades\Route;
use YunusEmreBaloglu\ChunkUpload\Http\Controllers\ChunkUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Define a route for deploying with a token

Route::post(config('chunk-upload.url'), [ChunkUploadController::class, 'upload'])->name('chunk-upload.upload');
Route::post(config('chunk-upload.url_delete_file').'/{file}', [ChunkUploadController::class, 'delete_file'])->name('chunk-upload.delete_file');
