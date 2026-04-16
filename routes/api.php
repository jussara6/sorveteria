<?php

use App\Http\Controllers\FlavorController;
use Illuminate\Support\Facades\Route;

Route::apiResource('flavors', FlavorController::class);
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);
