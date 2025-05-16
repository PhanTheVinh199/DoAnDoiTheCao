@extends('admin.sidebar')

@section('title', 'Thêm Ngân Hàng Admin')

@section('content')
<div class="container mt-4">
    <h1>Thêm Ngân Hàng Admin</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            Vui lòng kiểm tra lại các lỗi bên dưới.
        </div>
    @endif

    <form action="{{ route('admin.nganhang.admin.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="thanhvien_id" class="form-label">Chọn Admin Liên Kết</label>
            <select name="thanhvien_id" id="thanhvien_id" class="form-control" required>
                <option value="">-- Chọn Admin --</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id_thanhvien }}" {{ old('thanhvien_id') == $admin->id_thanhvien ? 'selected' : '' }}>
                        {{ $admin->tai_khoan }}
                    </option>
                @endforeach
            </select>
            @error('thanhvien_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ten_ngan_hang" class="form-label">Tên Ngân Hàng</label>
            <input type="text" name="ten_ngan_hang" id="ten_ngan_hang" class="form-control" value="{{ old('ten_ngan_hang') }}" required>
            @error('ten_ngan_hang')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="so_tai_khoan" class="form-label">Số Tài Khoản</label>
            <input type="text" name="so_tai_khoan" id="so_tai_khoan" class="form-control" value="{{ old('so_tai_khoan') }}" required>
            @error('so_tai_khoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="chu_tai_khoan" class="form-label">Chủ Tài Khoản</label>
            <input type="text" name="chu_tai_khoan" id="chu_tai_khoan" class="form-control" value="{{ old('chu_tai_khoan') }}" required>
            @error('chu_tai_khoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="trang_thai" class="form-label">Trạng Thái</label>
            <select name="trang_thai" id="trang_thai" class="form-control" required>
                <option value="hoat_dong" {{ old('trang_thai') == 'hoat_dong' ? 'selected' : '' }}>Hoạt Động</option>
                <option value="khong_hoat_dong" {{ old('trang_thai') == 'khong_hoat_dong' ? 'selected' : '' }}>Không Hoạt Động</option>
            </select>
            @error('trang_thai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Thêm Ngân Hàng Admin</button>
    </form>
</div>
@endsection
