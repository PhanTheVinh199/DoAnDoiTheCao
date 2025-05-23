<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nạp Tiền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">
    @if(session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: "{{ session('error') }}",
            confirmButtonText: 'Ok',
        });
    </script>
    @endif
    <div class="container mt-5">
        <h2 class="text-center mb-4">Nạp Tiền Cho Thành Viên</h2>

        <form action="{{ route('admin.thanhvien.naptien', $thanhvien->id_thanhvien) }}" method="POST" id="formNapTien">
            @csrf

            <div class="mb-3">
                <label for="tai_khoan" class="form-label">Tên Đăng Nhập</label>
                <input type="text" id="tai_khoan" name="tai_khoan" value="{{ $thanhvien->tai_khoan }}" class="form-control" disabled />
            </div>

            <input type="hidden" id="so_du_cu" name="so_du_cu" value="{{ $thanhvien->so_du }}" />

            <div class="mb-3">
                <label for="so_du" class="form-label">Số Dư Hiện Tại</label>
                <input type="text" id="so_du" name="so_du" value="{{ $thanhvien->so_du }}" class="form-control" disabled />
            </div>

            <div class="mb-3">
                <label for="so_tien" class="form-label">Số Tiền</label>
                <input type="number" id="so_tien" name="so_tien" class="form-control" required min="10000" max="5000000" step="1" />
                <small id="so_tien-help" class="text-sm text-gray-500 mt-1 block">
                    Chỉ được nhập từ 10.000 đến 5.000.000 VND
                </small>
            </div>


            <div class="mb-3">
                <label for="transaction_type" class="form-label">Chọn Nạp/Rút</label>
                <select id="transaction_type" name="transaction_type" class="form-select">
                    <option value="naptien">Nạp Tiền</option>
                    <option value="rutien">Rút Tiền</option>
                </select>
            </div>

            <div class="d-flex justify-content-end space-x-2 mt-4">
                <a href="{{ route('admin.thanhvien.danhsach') }}" class="btn btn-secondary me-2">Đóng</a>
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('formNapTien').addEventListener('submit', function(e) {
            e.preventDefault();

            // Nếu đang show popup conflict thì không hiện popup xác nhận nữa
            if (window.hasConflictPopup) return;

            let soTien = Number(document.getElementById('so_tien').value);

            if (soTien <= 0) {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Số tiền phải lớn hơn 0!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn thực hiện giao dịch này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
</body>

</html>