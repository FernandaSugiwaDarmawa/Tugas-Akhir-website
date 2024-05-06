<?php

use App\Http\Controllers\AntaresController;

Route::get('/', [AntaresController::class, 'index'])->name('index'); 
Route::get('/fetch-data', [AntaresController::class, 'fetchData'])->name('fetch-data');

// Route untuk menampilkan jadwal kereta
Route::view('/jadwal-kereta', 'JadwalKereta')->name('jadwal-kereta');

// Route untuk melacak perjalanan kereta dengan ID unik
Route::get('/tracking1/{id}', [AntaresController::class, 'trackTrain'])->name('tracking1');

// Route untuk halaman pelacakan kereta
Route::view('/tracking1', 'Tracking1')->name('tracking1-page');
