<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thêm Nhà Cung Cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Thêm Nhà Cung Cấp</h2>
            <a href="{{ route('admin.doithecao.nhacungcap.index') }}" class="text-gray-500 hover:text-gray-700" aria-label="Đóng">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('admin.doithecao.nhacungcap.them') }}" method="POST" enctype="multipart/form-data" class="p-4" autocomplete="off">
            @csrf

            {{-- Tên nhà cung cấp --}}
            <div class="mb-4">
                <label for="ten" class="block text-gray-700 mb-2">Tên nhà cung cấp</label>
                <input id="ten" type="text" name="ten" value="{{ old('ten') }}" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                       aria-describedby="ten-error" />
                @error('ten')
                    <p id="ten-error" class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hình ảnh --}}
            <div class="mb-4">
                <label for="hinh_anh" class="block text-gray-700 mb-2">Hình ảnh</label>
                <input id="hinh_anh" type="file" name="hinh_anh" accept="image/*" onchange="previewImage(event)"
                       class="w-full border rounded px-3 py-2" aria-describedby="hinh_anh-error" />
                @error('hinh_anh')
                    <p id="hinh_anh-error" class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div class="mt-2">
                    <img id="imagePreview" class="hidden w-32 h-32 object-cover rounded border" alt="Ảnh xem trước" />
                </div>
            </div>

            {{-- Trạng thái --}}
            <div class="mb-4">
                <label for="trang_thai" class="block text-gray-700 mb-2">Trạng thái</label>
                <select id="trang_thai" name="trang_thai" class="w-full border rounded px-3 py-2" aria-describedby="trang_thai-error">
                    <option value="hoat_dong" {{ old('trang_thai') == 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="an" {{ old('trang_thai') == 'an' ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('trang_thai')
                    <p id="trang_thai-error" class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nút --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.doithecao.nhacungcap.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Hủy</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" id="submitBtn">
                    Thêm nhà cung cấp
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                // Reset preview nếu không chọn file
                preview.src = '';
                preview.classList.add('hidden');
            }
        }

        // Optional: disable nút submit sau khi bấm để tránh gửi form nhiều lần
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerText = 'Đang xử lý...';
        });
    </script>
</body>
</html>
