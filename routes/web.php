<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/works', fn () => Inertia::render('Works/Index'));
Route::get('/works/create', fn () => Inertia::render('Works/Create'));
Route::get('/works/{id}/edit', fn ($id) => Inertia::render('Works/Edit', ['id' => $id]));

Route::get('/job-listing', fn () => Inertia::render('Candidate/JobListing'));


