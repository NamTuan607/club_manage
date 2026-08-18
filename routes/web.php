<?php

use App\Http\Controllers\ActivityPointRuleController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubMemberController;
use App\Http\Controllers\ClubRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventApprovalController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\StudentPointController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('clubs', ClubController::class);
Route::resource('club_roles', ClubRoleController::class);
Route::resource('club_members', ClubMemberController::class);

Route::resource('event-categories', EventCategoryController::class);
Route::resource('events', EventController::class);
Route::resource('event-approvals', EventApprovalController::class)->only(['index', 'create', 'store', 'show']);
Route::resource('registrations', EventRegistrationController::class)->only(['index', 'create', 'store', 'destroy']);
Route::resource('checkins', CheckinController::class)->only(['index', 'create', 'store', 'show']);

Route::resource('activity-point-rules', ActivityPointRuleController::class);
Route::resource('student-points', StudentPointController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
Route::resource('certificates', CertificateController::class);
