<?php

use App\Http\Controllers\FlavorController;
use Illuminate\Support\Facades\Route;

Route::apiResource('flavors', FlavorController::class);