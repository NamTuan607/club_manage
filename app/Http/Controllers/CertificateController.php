<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\StudentPoint;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['studentPoint.student', 'studentPoint.event'])
            ->latest('issued_at')
            ->paginate(12);

        return view('certificates.index', compact('certificates'));
    }

    public function create(Request $request)
    {
        $studentPoints = StudentPoint::with(['student', 'event'])
            ->whereDoesntHave('certificate')
            ->latest('awarded_at')
            ->get();
        $selectedStudentPointId = $request->integer('student_point_id');

        return view('certificates.create', compact('studentPoints', 'selectedStudentPointId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_point_id' => ['required', 'exists:student_points,id'],
            'certificate_code' => ['nullable', 'string', 'max:100', 'unique:certificates,certificate_code'],
            'issued_at' => ['required', 'date'],
            'status' => ['required', 'in:valid,revoked'],
        ]);

        if (Certificate::where('student_point_id', $data['student_point_id'])->exists()) {
            throw ValidationException::withMessages([
                'student_point_id' => 'Bản ghi điểm này đã có chứng nhận.',
            ]);
        }

        $data['certificate_code'] = $data['certificate_code'] ?: $this->nextCode();
        Certificate::create($data);

        return redirect()->route('certificates.index')->with('success', 'Đã cấp chứng nhận.');
    }

    public function show(Certificate $certificate)
    {
        $certificate->load(['studentPoint.student', 'studentPoint.event.club', 'studentPoint.rule']);

        return view('certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        return view('certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $data = $request->validate([
            'certificate_code' => ['required', 'string', 'max:100', Rule::unique('certificates', 'certificate_code')->ignore($certificate->id)],
            'issued_at' => ['required', 'date'],
            'status' => ['required', 'in:valid,revoked'],
        ]);

        $certificate->update($data);

        return redirect()->route('certificates.show', $certificate)->with('success', 'Đã cập nhật chứng nhận.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Đã xóa chứng nhận.');
    }

    private function nextCode(): string
    {
        do {
            $code = 'CN-' . now()->format('Ymd') . '-' . strtoupper(str()->random(6));
        } while (Certificate::where('certificate_code', $code)->exists());

        return $code;
    }
}
