<?php

use App\Http\Controllers\FlavorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('flavors', FlavorController::class);
Route::apiResource('users', UserController::class);
