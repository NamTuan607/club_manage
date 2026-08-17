<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Str;


class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $clubs = Club::all();

    return view('clubs.index', compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'founding_date' => 'nullable|date',
            'advisor' => 'nullable|string|max:255',
            'president' => 'nullable|string|max:255',
            'max_members' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/clubs'), $filename);
            $data['logo'] = 'uploads/clubs/' . $filename;
        }

        Club::create($data);

        return redirect()->route('clubs.index');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $club = Club::with(['members.student','members.clubRole'])->findOrFail($id);

        return view('clubs.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $club = Club::findOrFail($id);

        return view('clubs.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $club = Club::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'founding_date' => 'nullable|date',
            'advisor' => 'nullable|string|max:255',
            'president' => 'nullable|string|max:255',
            'max_members' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            // remove old file if exists
            if ($club->logo && file_exists(public_path($club->logo))) {
                @unlink(public_path($club->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/clubs'), $filename);
            $data['logo'] = 'uploads/clubs/' . $filename;
        }

        $club->update($data);

        return redirect()->route('clubs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $club = Club::findOrFail($id);

        // Prevent delete if club has members
        if ($club->members()->exists()) {
            return redirect()->route('clubs.index')->with('error', 'Không thể xóa CLB đang có thành viên. Vui lòng chuyển hoặc xóa thành viên trước khi xóa CLB.');
        }

        if ($club->logo && file_exists(public_path($club->logo))) {
            @unlink(public_path($club->logo));
        }

        $club->delete();

        return redirect()->route('clubs.index')->with('success', 'Đã xóa CLB.');
    }
}
