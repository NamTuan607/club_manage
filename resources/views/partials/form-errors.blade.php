@if($errors->any())
    <div class="alert alert-danger">
        <strong>Vui lòng kiểm tra lại dữ liệu:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif
