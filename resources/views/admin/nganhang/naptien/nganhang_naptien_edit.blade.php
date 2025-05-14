<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật Nạp Tiền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: rgb(107, 114, 128);
        }
    </style>
</head>

<body class="form ">

    <!-- Modal -->
    <div class="modal fade show" id="napTienModal" tabindex="-1" aria-labelledby="napTienModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="napTienModalLabel">Cập nhật Nạp Tiền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('admin.naptien.approve', $napTien->id_lichsunap) }}" method="POST">
                        @csrf
                        @method('POST')

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
                            <button type="submit" class="btn btn-danger">Cập nhật</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script>
        document.getElementById('closeModalButton').addEventListener('click', function () {
            // Điều hướng về trang chủ hoặc bất kỳ trang nào bạn muốn
            window.location.href = "{{ route('admin.naptien.index') }}";  // Điều hướng về trang danh sách
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>
