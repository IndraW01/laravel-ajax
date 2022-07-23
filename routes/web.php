<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/mahasiswas');

Route::get('/mahasiswas/all', [MahasiswaController::class, 'allMahasiswa']);
Route::resource('/mahasiswas', MahasiswaController::class)->names('mahasiswa')->scoped([
    'mahasiswa' => 'nim'
]);
