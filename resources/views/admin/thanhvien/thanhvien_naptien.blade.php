<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nạp Tiền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Nạp Tiền Cho Thành Viên</h2>

        <!-- Form Nạp Tiền -->
        <form action="{{ route('thanhvien.naptien', $thanhvien->id_thanhvien) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="mb-3">
                <label for="tai_khoan" class="form-label">Tên Đăng Nhập</label>
                <input type="text" id="tai_khoan" name="tai_khoan" value="{{ $thanhvien->tai_khoan }}" class="form-control" disabled />
            </div>
        
            <div class="mb-3">
                <label for="so_tien" class="form-label">Số Tiền</label>
                <input type="number" id="so_tien" name="so_tien" class="form-control" required />
            </div>
        
            <div class="mb-3">
                <label for="transaction_type" class="form-label">Chọn Nạp/Rút</label>
                <select id="transaction_type" name="transaction_type" class="form-select">
                    <option value="naptien">Nạp Tiền</option>
                    <option value="rutien">Rút Tiền</option>
                </select>
            </div>
        
            <div class="d-flex justify-content-end space-x-2 mt-4">
                <a href="{{ route('thanhvien.danhsach') }}" class="btn btn-secondary me-2">Đóng</a>
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
        </form>
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Xử lý submit form và xác nhận thông qua SweetAlert2
        document.getElementById('formNapTien').addEventListener('submit', function(e) {
            e.preventDefault(); // Ngừng gửi form tự động

            // Kiểm tra giá trị của 'transaction_type' và 'so_tien'
            let soTien = document.getElementById('so_tien').value;
            let transactionType = document.getElementById('transaction_type').value;

            // Nếu số tiền nhỏ hơn hoặc bằng 0, hiển thị thông báo lỗi
            if (soTien <= 0) {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Số tiền phải lớn hơn 0!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Hiển thị cảnh báo xác nhận
            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn thực hiện giao dịch này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tiến hành gửi form
                    document.getElementById('formNapTien').submit();
                }
            });
        });
    </script>
</body>

</html>
