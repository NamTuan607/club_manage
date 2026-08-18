<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount(['members', 'events'])->latest()->paginate(10);

        return view('clubs.index', compact('clubs'));
    }

    public function create()
    {
        return view('clubs.create');
    }

    public function store(Request $request)
    {
        Club::create($this->validated($request));

        return redirect()->route('clubs.index')->with('success', 'Đã tạo câu lạc bộ.');
    }

    public function show(Club $club)
    {
        $club->load(['members.student', 'members.clubRole', 'roles', 'events.category']);

        return view('clubs.show', compact('club'));
    }

    public function edit(Club $club)
    {
        return view('clubs.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        $club->update($this->validated($request, $club));

        return redirect()->route('clubs.show', $club)->with('success', 'Đã cập nhật câu lạc bộ.');
    }

    public function destroy(Club $club)
    {
        if ($club->members()->exists() || $club->events()->exists() || $club->roles()->exists()) {
            return back()->with('error', 'Không thể xóa CLB đang có vai trò, thành viên hoặc sự kiện.');
        }

        $this->removeLogo($club);
        $club->delete();

        return redirect()->route('clubs.index')->with('success', 'Đã xóa câu lạc bộ.');
    }

    private function validated(Request $request, ?Club $club = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('clubs', 'name')->ignore($club?->id)],
            'short_name' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:3000'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'founding_date' => ['nullable', 'date'],
            'advisor' => ['nullable', 'string', 'max:255'],
            'president' => ['nullable', 'string', 'max:255'],
            'max_members' => ['required', 'integer', 'min:1', 'max:10000'],
            'status' => ['required', 'in:active,inactive'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $this->removeLogo($club);
            $directory = public_path('uploads/clubs');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $file = $request->file('logo');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['logo'] = 'uploads/clubs/' . $filename;
        } else {
            unset($data['logo']);
        }

        return $data;
    }

    private function removeLogo(?Club $club): void
    {
        if ($club && $club->logo && str_starts_with($club->logo, 'uploads/clubs/') && file_exists(public_path($club->logo))) {
            unlink(public_path($club->logo));
        }
    }
}
