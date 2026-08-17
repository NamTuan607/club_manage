<?php

namespace App\Http\Controllers;

use App\Models\ClubRole;

class ClubRoleController extends Controller
{
    public function index()
    {
        $roles = ClubRole::all();

        return view('club_roles.index', compact('roles'));
    }
}