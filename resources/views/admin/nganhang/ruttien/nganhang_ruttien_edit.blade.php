<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </link>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Cập nhật Rút Tiền</h2>
            <button class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4">
            <form action="{{ route('admin.nganhang.ruttien.update', $rutTien->id_lichsurut) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Phương thức PUT để cập nhật -->

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Mã Đơn</label>
                    <input type="text" name="ma_don" value="{{ $rutTien->ma_don }}"
                        class="w-full border rounded px-3 py-2" disabled />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Tên Đăng Nhập</label>
                    <input type="text" name="tai_khoan" value="{{ $rutTien->thanhvien->tai_khoan }}"
                        class="w-full border rounded px-3 py-2" disabled />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Số Tiền Rút</label>
                    <input type="text" name="so_tien_rut" value="{{ $rutTien->so_tien_rut }}"
                        class="w-full border rounded px-3 py-2" disabled />
                </div>

                <label class="block text-gray-700 mb-2">Trạng Thái</label>
                <select name="trang_thai" class="w-full border rounded px-3 py-2">
                    <option value="cho_duyet" {{ $rutTien->trang_thai == 'cho_duyet' ? 'selected' : '' }}>Chờ Phê Duyệt
                    </option>
                    <option value="da_duyet" {{ $rutTien->trang_thai == 'da_duyet' ? 'selected' : '' }}>Hoạt Động
                    </option>
                    <option value="huy" {{ $rutTien->trang_thai == 'huy' ? 'selected' : '' }}>Hủy</option>
                </select>


                <div class="flex justify-end space-x-2 mt-4">
                    <a href="{{ route('admin.nganhang.ruttien.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>