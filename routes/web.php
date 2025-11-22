<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\kategoriController;

Route::get('/', [DiagnosisController::class,'index']);
Route::post('/search', [DiagnosisController::class, 'search']); 
Route::post('/topologi',[kategoriController::class,'cariKategoriTpologi']);
Route::post('/semua',[kategoriController::class,'cariKategoriSemua']);

Route::post('/{namaLabel}', [DiagnosisController::class, 'detail'])->name('penyakit.detail');   