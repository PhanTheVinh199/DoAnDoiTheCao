<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </link>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <form action="{{ route('admin.mathecao.nhacungcap.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-lg font-semibold">Thêm Nhà Cung Cấp</h2>
                <a  href="{{ route('admin.mathecao.nhacungcap.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Tên nhà cung cấp</label>
                    <input type="text" name="ten" id="ten" class="w-full border rounded px-3 py-2" maxlength="50" />
                    <small id="ten-count" class="text-sm text-gray-500 mt-1 block">0/50 ký tự</small>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Hình ảnh</label>
                    <input type="file" name="hinhanh" id="hinhanh" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.mathecao.nhacungcap.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Thêm nhà cung cấp</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        const tenInput = document.getElementById('ten');
        const tenCount = document.getElementById('ten-count');
        tenInput.addEventListener('input', () => {
            const len = tenInput.value.length;
            tenCount.textContent = `${len}/50 ký tự`;
        });
    </script>
</body>

</html>