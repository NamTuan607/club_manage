@if(isset($member))
    <form action="{{ route('club_members.update', $member->id) }}" method="POST">
        @method('PUT')
@else
    <form action="{{ route('club_members.store') }}" method="POST">
@endif
    @csrf

    <div class="mb-3">
        <label class="form-label">Câu lạc bộ</label>
        <select name="club_id" class="form-select" required>
            <option value="">-- Chọn CLB --</option>
            @foreach($clubs as $c)
                <option value="{{ $c->id }}" {{ old('club_id', $member->club_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Sinh viên</label>
        <select name="student_id" class="form-select" required>
            <option value="">-- Chọn sinh viên --</option>
            @foreach($students as $s)
                <option value="{{ $s->id }}" {{ old('student_id', $member->student_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->full_name ?? $s->name ?? ('#'.$s->id) }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Vai trò</label>
        <select name="club_role_id" class="form-select" required>
            <option value="">-- Chọn vai trò --</option>
            @foreach($roles as $r)
                <option value="{{ $r->id }}" {{ old('club_role_id', $member->club_role_id ?? '') == $r->id ? 'selected' : '' }}>{{ $r->role_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ngày tham gia</label>
            <input type="date" name="join_date" value="{{ old('join_date', isset($member->join_date) ? 
                \Carbon\Carbon::parse($member->join_date)->format('Y-m-d') : '') }}" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Ngày rời (nếu có)</label>
            <input type="date" name="leave_date" value="{{ old('leave_date', isset($member->leave_date) && $member->leave_date ? \Carbon\Carbon::parse($member->leave_date)->format('Y-m-d') : '') }}" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="active" {{ old('status', $member->status ?? '')=='active' ? 'selected':'' }}>Hoạt động</option>
            <option value="inactive" {{ old('status', $member->status ?? '')=='inactive' ? 'selected':'' }}>Ngừng</option>
            <option value="pending" {{ old('status', $member->status ?? '')=='pending' ? 'selected':'' }}>Đang chờ</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Năm học</label>
        <input name="academic_year" value="{{ old('academic_year', $member->academic_year ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Ghi chú</label>
        <textarea name="note" class="form-control">{{ old('note', $member->note ?? '') }}</textarea>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('club_members.index') }}" class="btn btn-secondary">Quay lại</a>
        <button class="btn btn-primary">Lưu</button>
    </div>

</form>
