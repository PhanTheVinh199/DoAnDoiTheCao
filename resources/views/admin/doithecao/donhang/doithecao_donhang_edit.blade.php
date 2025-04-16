<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Đơn Hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Cập Nhật Đơn Hàng</h2>
            <a href="{{ route('admin.doithecao.donhang.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>
        <div class="p-4">
            <form action="{{ route('admin.doithecao.donhang.update', $donhang->id_dondoithe) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Mã Đơn</label>
                    <input type="text" name="ma_don" class="w-full border rounded px-3 py-2" value="{{ $donhang->ma_don }}" required>
                    @error('ma_don')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Mã Thẻ</label>
                    <input type="text" name="ma_the" class="w-full border rounded px-3 py-2" value="{{ $donhang->ma_the }}" required>
                    @error('ma_the')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Serial</label>
                    <input type="text" name="serial" class="w-full border rounded px-3 py-2" value="{{ $donhang->serial }}" required>
                    @error('serial')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Sản Phẩm</label>
                    <select name="doithecao_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach (\App\Models\DoithecaoDanhsach::all() as $sanpham)
                            <option value="{{ $sanpham->id_doithecao }}" {{ $donhang->doithecao_id == $sanpham->id_doithecao ? 'selected' : '' }}>
                                {{ $sanpham->ten_san_pham ?? 'Sản phẩm #' . $sanpham->id_doithecao }}
                            </option>
                        @endforeach
                    </select>
                    @error('doithecao_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Số Lượng</label>
                    <input type="number" name="so_luong" class="w-full border rounded px-3 py-2" value="{{ $donhang->so_luong }}" min="1" required>
                    @error('so_luong')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Thành Tiền</label>
                    <input type="number" name="thanh_tien" class="w-full border rounded px-3 py-2" value="{{ $donhang->thanh_tien }}" min="0" required>
                    @error('thanh_tien')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Trạng Thái</label>
                    <select name="trang_thai" class="w-full border rounded px-3 py-2" required>
                        <option value="hoat_dong" {{ $donhang->trang_thai == 'hoat_dong' ? 'selected' : '' }}>Hoạt Động</option>
                        <option value="cho_xu_ly" {{ $donhang->trang_thai == 'cho_xu_ly' ? 'selected' : '' }}>Đang Xử Lý</option>
                        <option value="da_huy" {{ $donhang->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã Hủy</option>
                    </select>
                    @error('trang_thai')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.doithecao.donhang.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>