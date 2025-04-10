<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Thêm Nhà Cung Cấp</h2>
            <button class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tên nhà cung cấp</label>
                <input type="text" class="w-full border rounded px-3 py-2" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Hình ảnh</label>
                <input type="file" class="w-full border rounded px-3 py-2" />
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{route('admin.mathecao.nhacungcap')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Thêm nhà cung cấp</button>
            </div>
        </div>
    </div>
</body>
</html>