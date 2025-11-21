<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosisController;
Route::get('/', [DiagnosisController::class,'index']);
Route::post('/', [DiagnosisController::class, 'search']); 
