<?php

namespace App\Http\Controllers;

use App\Models\ClubMember;

class ClubMemberController extends Controller
{
    public function index()
    {
        $members = ClubMember::with([
            'club',
            'student',
            'clubRole'
        ])->get();

        return view('club_members.index', compact('members'));
    }
}