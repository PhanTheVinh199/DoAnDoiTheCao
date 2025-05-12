@include('admin.sidebar')

<div class="container mt-4">
    <h4 class="mb-4">Cài đặt ngân hàng</h4>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.nganhang.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tên tài khoản thành viên</label>
            <input type="text" name="ten_thanhvien" class="form-control" placeholder="Nhập tài khoản: ví dụ Văn A" required value="{{ old('ten_thanhvien') }}">
            @error('ten_thanhvien')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tên ngân hàng</label>
            <input type="text" name="ten_ngan_hang" class="form-control" required value="{{ old('ten_ngan_hang') }}">
            @error('ten_ngan_hang')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Số tài khoản</label>
            <input type="text" name="so_tai_khoan" class="form-control" required value="{{ old('so_tai_khoan') }}">
            @error('so_tai_khoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Chủ tài khoản</label>
            <input type="text" name="chu_tai_khoan" class="form-control" required value="{{ old('chu_tai_khoan') }}">
            @error('chu_tai_khoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <label for="trang_thai">Trạng thái:</label>
        <label for="trang_thai">Trạng thái:</label>
        <select name="trang_thai" id="trang_thai" class="form-control">
            <option value="1" {{ old('trang_thai') == 1 ? 'selected' : '' }}>Hoạt động</option>
            <option value="0" {{ old('trang_thai') == 0 ? 'selected' : '' }}>Không hoạt động</option>
        </select>

        @error('trang_thai')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary mt-3">Thêm ngân hàng</button>
    </form>

    <hr>

    <div class="mb-4">
        <label class="col-form-label fw-bold">Cổng thanh toán:</label>
        <select class="form-control" name="paygate_code" required>
            @forelse($banks as $bank)
                <option value="{{ $bank->id }}">
                    {{ $bank->ten_ngan_hang }} - {{ $bank->so_tai_khoan }} ({{ $bank->chu_tai_khoan }})
                </option>
            @empty
                <option value="">Bạn chưa thêm ngân hàng nào</option>
            @endforelse
        </select>
    </div>
</div>
