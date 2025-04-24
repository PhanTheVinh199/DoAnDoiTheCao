<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </link>
</head>
<form action="{{ route('admin.mathecao.loaima.update', $dsSanPham->id_mathecao)}}" method="POST">
    @csrf
    @method('PUT')

    <body class="flex items-center justify-center min-h-screen bg-gray-500">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-lg font-semibold">Cập Nhật Sản Phẩm</h2>
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <input name="id_mathecao" type="hidden" value="{{$dsSanPham->id_mathecao}}">
                <div class="mb-4">
                    <em>
                        <h1 style="text-align: center;">Nhà Cung Cấp</h1>
                    </em>
                    <b><label style="text-align: center;" class="block text-gray-700 mb-2">{{$dsSanPham->nhaCungCap->ten}}</label></b>
                    <!-- <select class="w-full border rounded px-3 py-2">
                        <option value="">-- Chọn nhà cung cấp --</option>
                        <option value="Viettel">Viettel</option>
                    </select> -->
                </div>
                <div class="mb-4" hidden>
                    <label class="block text-gray-700 mb-2">Hình ảnh</label>
                    <input type="file" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Mệnh Giá </label>
                    <input type="text" name="menh_gia" class="w-full border rounded px-3 py-2" value="{{$dsSanPham->menh_gia}}" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Chiếc Khấu</label>
                    <input type="text" name="chiet_khau" class="w-full border rounded px-3 py-2" value="{{$dsSanPham->chiet_khau}}" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Trạng thái</label>
                    <select class="w-full border rounded px-3 py-2" name="trang_thai">
                        <option value="Hoạt động" {{ $dsSanPham->trang_thai === 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="Ẩn" {{ $dsSanPham->trang_thai === 'Ẩn' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>



                <div class="flex justify-end space-x-2">
                    <a href="{{route('admin.mathecao.loaima.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật Sản Phẩm</button>
                </div>
            </div>
        </div>
</form>
</body>

</html>