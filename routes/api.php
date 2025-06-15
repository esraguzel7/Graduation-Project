<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Readers\ReadersController;

Route::post('/reader/startup', [ReadersController::class, 'reader_startup'])->name('api.reader.startup');
Route::post('/reader/update', [ReadersController::class, 'reader_updates'])->name('api.reader.updates');
Route::post('/reader/process', [ReadersController::class, 'reader_process'])->name('api.reader.process');
