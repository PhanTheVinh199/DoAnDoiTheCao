
@include('admin.sidebar')

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Cập nhật Nạp Tiền</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.nganhang.naptien.update', $napTien->id_lichsunap) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Mã Đơn -->
                <div class="mb-3">
                    <label class="form-label">Mã Đơn</label>
                    <input type="text" name="ma_don" value="{{ $napTien->ma_don }}" class="form-control" disabled />
                </div>

                <!-- Tên Đăng Nhập -->
                <div class="mb-3">
                    <label class="form-label">Tên Đăng Nhập</label>
                    <input type="text" name="tai_khoan" value="{{ $napTien->thanhvien->tai_khoan }}" class="form-control" disabled />
                </div>

                <!-- Số Tiền Nạp -->
                <div class="mb-3">
                    <label class="form-label">Số Tiền Nạp</label>
                    <input type="number" name="so_tien_nap" value="{{ $napTien->so_tien_nap }}" class="form-control" required />
                </div>

                <!-- Nội Dung -->
                <div class="mb-3">
                    <label class="form-label">Nội Dung</label>
                    <textarea name="noi_dung" class="form-control">{{ $napTien->noi_dung }}</textarea>
                </div>

                <!-- Trạng Thái -->
                <div class="mb-3">
                    <label class="form-label">Trạng Thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="cho_duyet" {{ $napTien->trang_thai == 'cho_duyet' ? 'selected' : '' }}>Chờ Duyệt</option>
                        <option value="da_duyet" {{ $napTien->trang_thai == 'da_duyet' ? 'selected' : '' }}>Đã Duyệt</option>
                        <option value="huy" {{ $napTien->trang_thai == 'huy' ? 'selected' : '' }}>Hủy</option>
                    </select>
                </div>

                <!-- Các nút -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.nganhang.naptien.index') }}" class="btn btn-secondary me-2">Đóng</a>
                    <button type="submit" class="btn btn-danger">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>