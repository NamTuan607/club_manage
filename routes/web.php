<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubRoleController;
use App\Http\Controllers\ClubMemberController;

Route::resource('clubs', ClubController::class);
Route::resource('club_roles', ClubRoleController::class);
Route::resource('club_members', ClubMemberController::class);

Route::get('/', function () {
    return view('welcome');
});
