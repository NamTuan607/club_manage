<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClubRole;

class ClubRoleController extends Controller
{
    public function index()
    {
        $roles = ClubRole::all();

        return view('club_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('club_roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role_name' => 'required|string|max:255|unique:club_roles,role_name',
            'description' => 'nullable|string'
        ]);

        ClubRole::create($data);

        return redirect()->route('club_roles.index')->with('success','Đã tạo vai trò.');
    }

    public function show(string $id)
    {
        $role = ClubRole::findOrFail($id);

        return view('club_roles.show', compact('role'));
    }

    public function edit(string $id)
    {
        $role = ClubRole::findOrFail($id);

        return view('club_roles.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        $role = ClubRole::findOrFail($id);
        $data = $request->validate([
            'role_name' => 'required|string|max:255|unique:club_roles,role_name,'.$id,
            'description' => 'nullable|string'
        ]);

        $role->update($data);

        return redirect()->route('club_roles.index')->with('success','Đã cập nhật vai trò.');
    }

    public function destroy(string $id)
    {
        $role = ClubRole::findOrFail($id);

        if ($role->members()->exists()) {
            return redirect()->route('club_roles.index')->with('error', 'Không thể xóa vai trò đang được sử dụng bởi thành viên.');
        }

        $role->delete();

        return redirect()->route('club_roles.index')->with('success','Đã xóa vai trò.');
    }
}