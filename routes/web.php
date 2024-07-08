<?php

use App\Http\Controllers\AntaresController;

Route::get('/', [AntaresController::class, 'index'])->name('index'); 
Route::get('/fetch-data', [AntaresController::class, 'fetchData'])->name('fetch-data');

// Route untuk menampilkan jadwal kereta
Route::view('/jadwal-kereta', 'JadwalKereta')->name('jadwal-kereta');

// Route untuk melacak perjalanan kereta dengan ID unik
Route::get('/tracking1/{id}', [AntaresController::class, 'trackTrain'])->name('tracking1');

// Route untuk halaman pelacakan kereta 1
Route::view('/tracking1', 'Tracking1')->name('tracking1-page');

// Route untuk halaman pelacakan kereta 2
Route::view('/tracking2', 'Tracking2')->name('tracking2-page');

Route::view('/tracking3', 'Tracking3')->name('tracking3-page');

Route::view('/tracking4', 'Tracking4')->name('tracking4-page');

Route::view('/tracking5', 'Tracking5')->name('tracking5-page');

Route::view('/tracking6', 'Tracking6')->name('tracking6-page');