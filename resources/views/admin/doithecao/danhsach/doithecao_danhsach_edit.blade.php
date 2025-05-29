<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold text-gray-800">Cập Nhật Sản Phẩm</h2>
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

        <form action="{{ route('admin.doithecao.danhsach.update', $sanpham->id_doithecao) }}" method="POST"
            enctype="multipart/form-data" class="p-4 space-y-4">
            @csrf
            @method('PUT')

            <!-- Nhà cung cấp -->
            <div>
                <label class="block text-gray-700 mb-1">Tên Nhà Cung Cấp</label>
                <select name="nhacungcap_id_disabled"
                    class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
                    <option value="{{ $sanpham->nhacungcap_id }}" selected>
                        {{ $nhacungcaps->firstWhere('id_nhacungcap', $sanpham->nhacungcap_id)->ten ?? 'Không xác định' }}
                    </option>
                </select>

                <input type="hidden" name="nhacungcap_id" value="{{ $sanpham->nhacungcap_id }}">
                <input type="hidden" name="updated_at"
                    value="{{ $sanpham->updated_at ? $sanpham->updated_at->toDateTimeString() : now()->toDateTimeString() }}">


            </div>

            <!-- Mệnh giá -->
            <div>
                <label class="block text-gray-700 mb-1">Mệnh Giá</label>
                <input type="number" name="menh_gia" value="{{ old('menh_gia', $sanpham->menh_gia) }}"
                    class="w-full border rounded px-3 py-2" required />
                    @error('menh_gia')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
            </div>

            <!-- Chiết khấu -->
            <div>
                <label class="block text-gray-700 mb-1">Chiết Khấu (%)</label>
                <input type="number" step="0.01" name="chiet_khau"
                    value="{{ old('chiet_khau', $sanpham->chiet_khau) }}" class="w-full border rounded px-3 py-2"
                    required />
            </div>

            <!-- Trạng thái -->
            <div hidden>
                <label class="block text-gray-700 mb-1">Trạng Thái</label>
                <select name="trang_thai" class="w-full border rounded px-3 py-2" required>
                    <option value="1" {{ $sanpham->trang_thai == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ $sanpham->trang_thai == 0 ? 'selected' : '' }}>Đã hủy</option>
                    <option value="2" {{ $sanpham->trang_thai == 2 ? 'selected' : '' }}>Chờ xử lý</option>

                </select>
            </div>

            <!-- Nút -->
            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('admin.doithecao.danhsach.index') }}"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Đóng
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-save mr-1"></i> Cập Nhật
                </button>
            </div>
        </form>
    </div>

    {{-- Hiển thị thông báo nếu cập nhật thành công --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if(form) {
            form.addEventListener('submit', function() {
                const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                submitButtons.forEach(button => {
                    button.disabled = true;
                    button.innerText = 'Đang xử lý...';
                });
            });
        }
    });
</script>
</body>

</html>
