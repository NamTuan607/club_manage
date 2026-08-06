<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;

Route::resource('clubs', ClubController::class);

Route::get('/', function () {
    return view('welcome');
});
