@include('partials.form-errors')
<form method="POST" action="{{ isset($clubMember) ? route('club_members.update', $clubMember) : route('club_members.store') }}">
    @csrf 
    
    @isset($clubMember) 
    @method('PUT') 
    @endisset

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label required">Câu lạc bộ</label>
            <select class="form-select" name="club_id" required>
                <option value="">-- Chọn CLB --</option>
                @foreach($clubs as $club)
                    <option value="{{ $club->id }}" @selected(old('club_id', $clubMember->club_id ?? '') == $club->id)>
                        {{ $club->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label required">Sinh viên</label>
            <select class="form-select" name="student_id" required>
                <option value="">-- Chọn sinh viên --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @selected(old('student_id', $clubMember->student_id ?? '') == $student->id)>
                        {{ $student->full_name }} - {{ $student->student_code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label required">Chức vụ trong CLB</label>
            <select class="form-select" name="club_role_id" required>
                <option value="">-- Chọn chức vụ --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('club_role_id', $clubMember->club_role_id ?? '') == $role->id)>
                        {{ $role->club->short_name ?? $role->club->name }} - {{ $role->role_name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text">Chức vụ phải đúng với CLB đã chọn.</div>
        </div>

        <div class="col-md-3">
            <label class="form-label required">Ngày tham gia</label>
            <input class="form-control" type="date" name="join_date" value="{{ old('join_date', isset($clubMember) ? $clubMember->join_date->format('Y-m-d') : '') }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Ngày rời</label>
            <input class="form-control" type="date" name="leave_date" value="{{ old('leave_date', isset($clubMember) && $clubMember->leave_date ? $clubMember->leave_date->format('Y-m-d') : '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label required">Trạng thái</label>
            <select class="form-select" name="status">
                <option value="active" @selected(old('status', $clubMember->status ?? 'active') === 'active')>Hoạt động</option>
                <option value="pending" @selected(old('status', $clubMember->status ?? '') === 'pending')>Chờ duyệt</option>
                <option value="inactive" @selected(old('status', $clubMember->status ?? '') === 'inactive')>Ngừng</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Năm học</label>
            <input class="form-control" name="academic_year" value="{{ old('academic_year', $clubMember->academic_year ?? '') }}" placeholder="2025-2026">
        </div>

        <div class="col-12">
            <label class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note" rows="3">{{ old('note', $clubMember->note ?? '') }}</textarea>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end gap-2">
        <a class="btn btn-light border" href="{{ isset($clubMember) ? route('club_members.show', $clubMember) : route('club_members.index') }}">Hủy</a>
        <button class="btn btn-primary">Lưu</button>
    </div>
</form>