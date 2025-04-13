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
        .bx {
            font-size: 20px;
            padding: 5px;
            color: rgb(255, 245, 245);
        }

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
            <!-- Form chỉnh sửa thông tin thành viên -->
            <form action="{{ route('admin.thanhvien.update', $thanhvien->id_thanhvien) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Họ tên -->
                <div class="mb-4">
                    <label for="ho_ten" class="form-label">Họ Tên</label>
                    <input type="text" name="ho_ten" value="{{ $thanhvien->ho_ten }}" class="form-control" required>
                </div>

                <!-- Tài khoản -->
                <div class="mb-4">
                    <label for="tai_khoan" class="form-label">Tài Khoản</label>
                    <input type="text" name="tai_khoan" value="{{ $thanhvien->tai_khoan }}" class="form-control" required>
                </div>

                <!-- Mật khẩu -->
                <div class="mb-4">
                    <label for="mat_khau" class="form-label">Mật Khẩu</label>
                    <input type="password" name="mat_khau" class="form-control" placeholder="Để trống nếu không thay đổi">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $thanhvien->email }}" class="form-control" required>
                </div>

                <!-- Số điện thoại -->
                <div class="mb-4">
                    <label for="phone" class="form-label">Số Điện Thoại</label>
                    <input type="text" name="phone" value="{{ $thanhvien->phone }}" class="form-control" required>
                </div>

                <!-- Quyền -->
                <div class="mb-4">
                    <label for="quyen" class="form-label">Quyền</label>
                    <select name="quyen" class="form-select">
                        <option value="admin" {{ $thanhvien->quyen == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $thanhvien->quyen == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <!-- Thực hiện cập nhật -->
                <div class="d-flex justify-end mt-3">
                    <a href="{{ route('admin.thanhvien.danhsach') }}" class="btn btn-cancel text-white px-4 py-2 me-3">Hủy</a>
                    <button type="submit" class="btn btn-danger text-white px-4 py-2">Cập nhật</button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
