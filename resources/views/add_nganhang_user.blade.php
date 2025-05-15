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

        <div class="mb-3">
            <label for="ten_ngan_hang" class="form-label">Tên ngân hàng</label>
            <input type="text" name="ten_ngan_hang" class="form-control" id="ten_ngan_hang" required value="{{ old('ten_ngan_hang') }}">
            @error('ten_ngan_hang')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="so_tai_khoan" class="form-label">Số tài khoản</label>
            <input type="text" name="so_tai_khoan" class="form-control" id="so_tai_khoan" required value="{{ old('so_tai_khoan') }}">
            @error('so_tai_khoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="chu_tai_khoan" class="form-label">Chủ tài khoản</label>
            <input type="text" name="chu_tai_khoan" class="form-control" id="chu_tai_khoan" required value="{{ old('chu_tai_khoan') }}">
            @error('chu_tai_khoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Thêm ngân hàng</button>
    </form>
    </div>

</body>
</html>
