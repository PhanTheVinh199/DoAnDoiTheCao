<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Thêm Sản Phẩm</h2>
            <a href="{{ route('admin.doithecao.danhsach.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>
        
        <form action="{{ route('admin.doithecao.danhsach.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tên Nhà Cung Cấp</label>
                <select name="nhacungcap_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Chọn nhà cung cấp --</option>
                    @foreach($nhacungcaps as $nhacungcap)
                        <option value="{{ $nhacungcap -> id_nhacungcap }}">{{ $nhacungcap->ten }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Mệnh Giá</label>
                <input type="number" name="menh_gia" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Chiết Khấu (%)</label>
                <input type="number" step="0.01" name="chiet_khau" class="w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Trạng thái</label>
                <select name="trang_thai" class="w-full border rounded px-3 py-2">
                    <option value="hoat_dong">Hoạt động</option>
                    <option value="da_huy">Đã hủy</option>
                    <option value="cho_xu_ly">Chờ xử lý</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.doithecao.danhsach.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded">Thêm Sản Phẩm</button>
            </div>
        </form>
    </div>

</body>
</html>
