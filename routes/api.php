<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\MatchController;

Route::apiResource('works', WorkController::class);

Route::post('/match', [MatchController::class, 'compare']);

