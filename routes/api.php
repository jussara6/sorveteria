<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlavorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('flavors', FlavorController::class);
Route::apiResource('users', UserController::class);
