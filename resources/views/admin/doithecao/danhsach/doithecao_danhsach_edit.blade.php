<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold text-gray-800">Cập Nhật Sản Phẩm</h2>
            <a href="{{ route('admin.doithecao.danhsach.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('admin.doithecao.danhsach.update', $sanpham->id_doithecao) }}" method="POST" enctype="multipart/form-data" class="p-4 space-y-4">
            @csrf
            @method('PUT')

            <!-- Nhà cung cấp -->
            <div>
                <label class="block text-gray-700 mb-1">Tên Nhà Cung Cấp</label>
                <select name="nhacungcap_id" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                    <option value="{{ $sanpham->nhacungcap_id }}" selected>
                        {{ $nhacungcaps->firstWhere('id_nhacungcap', $sanpham->nhacungcap_id)->ten ?? 'Không xác định' }}
                    </option>
                </select>
                <input type="hidden" name="nhacungcap_id" value="{{ $sanpham->nhacungcap_id }}">
            </div>

            <!-- Mệnh giá -->
            <div>
                <label class="block text-gray-700 mb-1">Mệnh Giá</label>
                <input type="number" name="menh_gia" value="{{ $sanpham->menh_gia }}" class="w-full border rounded px-3 py-2" />
            </div>

            <!-- Chiết khấu -->
            <div>
                <label class="block text-gray-700 mb-1">Chiết Khấu (%)</label>
                <input type="number" step="0.01" name="chiet_khau" value="{{ $sanpham->chiet_khau }}" class="w-full border rounded px-3 py-2" />
            </div>

            <!-- Trạng thái
            <div>
                <label class="block text-gray-700 mb-1">Trạng Thái</label>
                <select name="trang_thai" class="w-full border rounded px-3 py-2">
                    <option value="hoat_dong" {{ $sanpham->trang_thai == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="da_huy" {{ $sanpham->trang_thai == 0 ? 'selected' : '' }}>Đã hủy</option>
                    <option value="cho_xu_ly" {{ $sanpham->trang_thai == 2 ? 'selected' : '' }}>Chờ xử lý</option>
                </select>
            </div> -->

            <!-- Button -->
            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('admin.doithecao.danhsach.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> Đóng
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-save mr-1"></i> Cập Nhật
                </button>
            </div>
        </form>
    </div>
</body>
</html>
