<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-200">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Thêm Sản Phẩm</h2>
            <a href="{{ route('admin.doithecao.danhsach.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-700 border border-red-400 m-4 rounded">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.doithecao.danhsach.store') }}" method="POST" class="p-4" id="productForm">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tên Nhà Cung Cấp</label>
                <select name="nhacungcap_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Chọn nhà cung cấp --</option>
                    @foreach($nhacungcaps as $nhacungcap)
                        <option value="{{ $nhacungcap->id_nhacungcap }}" {{ old('nhacungcap_id') == $nhacungcap->id_nhacungcap ? 'selected' : '' }}>
                            {{ $nhacungcap->ten }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Mệnh Giá</label>
                <input type="text" name="menh_gia" value="{{ old('menh_gia') }}" class="w-full border rounded px-3 py-2" required />
                @error('menh_gia')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Chiết Khấu (%)</label>
                <input type="number" step="0.01" name="chiet_khau" value="{{ old('chiet_khau') }}" class="w-full border rounded px-3 py-2" required min="0" max="100" />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Trạng Thái</label>
                <select name="trang_thai" class="w-full border rounded px-3 py-2" required>
                    <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>Đã hủy</option>
                    <option value="2" {{ old('trang_thai') == '2' ? 'selected' : '' }}>Chờ xử lý</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.doithecao.danhsach.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-1"></i> Đóng
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-1"></i> Thêm Sản Phẩm
                </button>
            </div>
        </form>
    </div>

    {{-- Hiển thị thông báo khi thêm thành công --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productForm');

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Ngăn submit gốc

            Swal.fire({
                title: 'Bạn có chắc muốn thêm sản phẩm?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // ✅ submit form thủ công
                }
            });
        });

        // Disable nút submit khi form đang xử lý
        form.addEventListener('submit', function () {
            const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            submitButtons.forEach(button => {
                button.disabled = true;
                button.innerText = 'Đang xử lý...';
            });
        });
    });
</script>

</body>
</html>
