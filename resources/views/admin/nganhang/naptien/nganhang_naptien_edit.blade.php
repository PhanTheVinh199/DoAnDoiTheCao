@include('admin.sidebar')

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Cập nhật Nạp Tiền</h5>
        </div>
        <div class="card-body">
            <!-- Form cập nhật giao dịch -->
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
                    <textarea name="noi_dung" class="form-control">{{ $napTien->transfer_note }}</textarea>
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
                    <button type="button" class="btn btn-secondary me-2" id="closeModalButton">Đóng</button>
                    <button type="submit" class="btn btn-success">
                        @if($napTien->trang_thai == 'cho_duyet') 
                            Duyệt Giao Dịch
                        @else
                            Cập nhật
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('closeModalButton').addEventListener('click', function () {
        // Điều hướng về trang danh sách giao dịch
        window.location.href = "{{ route('admin.nganhang.naptien.index') }}";  // Điều hướng về trang danh sách
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
