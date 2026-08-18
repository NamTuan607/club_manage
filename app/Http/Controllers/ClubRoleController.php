<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClubRoleController extends Controller
{
    public function index()
    {
        $roles = ClubRole::with('club')->withCount('members')->orderBy('club_id')->orderBy('role_name')->paginate(12);

        return view('club_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('club_roles.create', ['clubs' => $this->clubs()]);
    }

    public function store(Request $request)
    {
        ClubRole::create($this->validated($request));

        return redirect()->route('club_roles.index')->with('success', 'Đã tạo chức vụ CLB.');
    }

    public function show(ClubRole $clubRole)
    {
        $clubRole->load(['club', 'members.student']);

        return view('club_roles.show', compact('clubRole'));
    }

    public function edit(ClubRole $clubRole)
    {
        return view('club_roles.edit', ['clubRole' => $clubRole, 'clubs' => $this->clubs()]);
    }

    public function update(Request $request, ClubRole $clubRole)
    {
        $clubRole->update($this->validated($request, $clubRole));

        return redirect()->route('club_roles.index')->with('success', 'Đã cập nhật chức vụ CLB.');
    }

    public function destroy(ClubRole $clubRole)
    {
        if ($clubRole->members()->exists()) {
            return back()->with('error', 'Không thể xóa chức vụ đang được thành viên sử dụng.');
        }

        $clubRole->delete();

        return redirect()->route('club_roles.index')->with('success', 'Đã xóa chức vụ CLB.');
    }

    private function clubs()
    {
        return Club::where('status', 'active')->orderBy('name')->get();
    }

    private function validated(Request $request, ?ClubRole $clubRole = null): array
    {
        return $request->validate([
            'club_id' => ['required', 'exists:clubs,id'],
            'role_name' => [
                'required', 'string', 'max:255',
                Rule::unique('club_roles', 'role_name')
                    ->where('club_id', $request->input('club_id'))
                    ->ignore($clubRole?->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
