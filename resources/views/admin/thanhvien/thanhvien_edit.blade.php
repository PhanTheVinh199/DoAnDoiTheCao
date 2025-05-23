<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel {
            background-color: #6c757d;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="form-container">
            <h1 class="h2 mb-4 text-center">Chỉnh Sửa Thành Viên</h1>

            <!-- Hiển thị thông báo lỗi -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Đã xảy ra lỗi:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form chỉnh sửa thông tin thành viên -->
            <form action="{{ route('admin.thanhvien.update', $thanhvien->id_thanhvien) }}" method="POST"
                class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <input type="hidden" name="updated_at" value="{{ $thanhvien->updated_at }}">


                <!-- Họ tên: Chỉ chữ và khoảng trắng -->
                <div class="mb-4">
                    <label for="ho_ten" class="form-label">Họ Tên</label>
                    <input type="text" name="ho_ten" value="{{ old('ho_ten', $thanhvien->ho_ten) }}"
                        class="form-control" pattern="^[A-Za-z ]{5,100}$" required>
                    <div class="invalid-feedback">Họ tên có ít nhất từ 2 -> 100 kí tự</div>
                </div>

                <!-- Tài khoản: chữ và số, không dấu cách -->
                <div class="mb-4">
                    <label for="tai_khoan" class="form-label">Tài Khoản</label>
                    <input type="text" name="tai_khoan" 
                        value="{{ old('tai_khoan', $thanhvien->tai_khoan) }}" class="form-control" readonly>
                    {{-- <div class="invalid-feedback">Tài khoản phải từ 4–20 ký tự, không chứa dấu cách hoặc ký tự đặc biệt.</div> --}}
                </div>

                <!-- Mật khẩu: ít nhất 6 ký tự, có chữ và số -->
                <div class="mb-4">
                    <label for="mat_khau" class="form-label">Mật Khẩu</label>
                    <input type="password" name="mat_khau" class="form-control"
                        pattern="^(?=.*\d)[A-Za-z\d]{6,100}$" placeholder="Để trống nếu không thay đổi">
                    <div class="invalid-feedback">Mật khẩu có ít nhất 6 ->100 ký tự, gồm chữ và số.</div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $thanhvien->email) }}"
                        class="form-control" pattern="^{6,100}$" required>
                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                </div>

                <!-- Số điện thoại: 9–12 chữ số -->
                <div class="mb-4">
                    <label for="phone" class="form-label">Số Điện Thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $thanhvien->phone) }}"
                        class="form-control" pattern="^\+?\d{9,20}$" required>
                    <div class="invalid-feedback">Số điện thoại phải có từ 9 đến 20 chữ số.</div>
                </div>

                <!-- Quyền -->
                <div class="mb-4">
                    <label for="quyen" class="form-label">Quyền</label>
                    <select name="quyen" class="form-select" required>
                        <option value="">-- Chọn quyền --</option>
                        <option value="admin" {{ old('quyen', $thanhvien->quyen) == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="user" {{ old('quyen', $thanhvien->quyen) == 'user' ? 'selected' : '' }}>User
                        </option>
                    </select>
                    <div class="invalid-feedback">Vui lòng chọn quyền.</div>
                </div>

                <!-- Nút -->
                {{-- <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('admin.thanhvien.danhsach') }}" class="btn btn-secondary px-4 py-2 me-3">Hủy</a>
        <button type="submit" class="btn btn-danger px-4 py-2">Cập nhật</button>
    </div> --}}
                <!-- Nút -->
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('admin.thanhvien.danhsach') }}" class="btn btn-secondary px-4 py-2 me-3">Hủy</a>
                    <button type="button" id="btn-submit" class="btn btn-danger px-4 py-2">Cập nhật</button>

                </div>

            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        // Kích hoạt kiểm tra form với Bootstrap
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>


<script>
    document.getElementById('btn-submit').addEventListener('click', function () {
        const form = this.closest('form');

        // Kích hoạt kiểm tra hợp lệ
        if (form.checkValidity()) {
            // Nếu hợp lệ, hiển thị hộp thoại xác nhận
            Swal.fire({
                title: 'Xác nhận cập nhật?',
                text: "Bạn có chắc chắn muốn lưu thay đổi này?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Có, cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            // Nếu không hợp lệ, hiển thị lỗi mặc định Bootstrap 5
            form.classList.add('was-validated');
        }
    });
</script>



</body>

</html>
