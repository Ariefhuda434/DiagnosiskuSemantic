<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\kategoriController;

Route::get('/', [DiagnosisController::class,'index']);
Route::post('/search', [DiagnosisController::class, 'search']); 

Route::post('/{namaLabel}', [DiagnosisController::class, 'detail'])->name('penyakit.detail');   

Route::post('/kategori/lansia',[kategoriController::class,'cariKategoriLansia']);
Route::post('/kategori/dewasa',[kategoriController::class,'cariKategoriDewasa']);
Route::post('/kategori/remaja',[kategoriController::class,'cariKategoriRemaja']);
Route::post('/kategori/anak-kecil',[kategoriController::class,'cariKategoriAnakKecil']);
Route::post('/kategori/bayi',[kategoriController::class,'cariKategoriBayi']);
Route::post('/kategori/semua',[kategoriController::class,'cariKategoriSemua']);

Route::post('/kategori/pernapasan', [kategoriController::class, 'cariKategoriPernapasan']);
Route::post('/kategori/saraf', [kategoriController::class, 'cariKategoriSaraf']);
Route::post('/kategori/Indra', [kategoriController::class, 'cariKategoriIndra']);
Route::post('/kategori/Pencernaan', [kategoriController::class, 'cariKategoriPencernaan']);
Route::post('/kategori/Reproduksi', [kategoriController::class, 'cariKategoriReproduksi']);
Route::post('/kategori/Dermatologi', [kategoriController::class, 'cariKategoriDermatologi']);
Route::post('/kategori/Integumen', [kategoriController::class, 'cariKategoriIntegumen']);
Route::post('/kategori/Imunologi', [kategoriController::class, 'cariKategoriImunologi']);
Route::post('/kategori/Kardiovaskular', [kategoriController::class, 'cariKategoriKardiovaskular']);
Route::post('/kategori/Endokrin', [kategoriController::class, 'cariKategoriEndokrin']);
Route::post('/filter-category/{category}', [DiagnosisController::class, 'categorySearch']);