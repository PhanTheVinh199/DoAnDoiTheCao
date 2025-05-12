<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Cập Nhật Ngân Hàng</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold">Cập Nhật Ngân Hàng</h2>
            <a href="{{ route('ruttien') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('add_nganhang_user_store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="ten_ngan_hang" class="block text-gray-700 font-medium mb-2">Ngân Hàng</label>
                <input type="text" name="ten_ngan_hang" id="ten_ngan_hang" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div class="mb-4">
                <label for="so_tai_khoan" class="block text-gray-700 font-medium mb-2">Số Tài Khoản</label>
                <input type="text" name="so_tai_khoan" id="so_tai_khoan" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div class="mb-4">
                <label for="chu_tai_khoan" class="block text-gray-700 font-medium mb-2">Chủ Tài Khoản</label>
                <input type="text" name="chu_tai_khoan" id="chu_tai_khoan" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('ruttien') }}" class="bg-gray-500 text-white px-4 py-2 rounded focus:outline-none hover:bg-gray-600">Đóng</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded focus:outline-none hover:bg-blue-700">Cập Nhật</button>
            </div>
        </form>
    </div>

</body>
</html>
