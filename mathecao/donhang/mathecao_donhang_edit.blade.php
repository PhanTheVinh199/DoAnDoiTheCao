<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </link>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <form action="{{ route('admin.mathecao.donhang.update', $donHang->id_donbanthe)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-lg font-semibold">Cập Nhật Đơn Hàng</h2>
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <input name="id_mathecao" type="hidden" value="{{$donHang->id_mathecao}}">
            <div class="p-4">
                <!-- <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nhà Cung Cấp</label>
                    <select class="w-full border rounded px-3 py-2" disabled>
                        <option value="">-- Chọn nhà cung cấp --</option>
                        <option value="Viettel">Viettel</option>
                        <option value="Mobifone">Mobifone</option>
                        <option value="Vinaphone">Vinaphone</option>
                    </select>
                </div> -->
                <em>
                    <h1 style="text-align: center;">Nhà Cung Cấp</h1>
                </em>
                <b><label style="text-align: center;" class="block text-gray-700 mb-2">{{$nhaCungCap}}</label></b>
                <!-- <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nhà Cung Cấp</label>
                    <input type="text" class="w-full border rounded px-3 py-2" value="{{ $nhaCungCap }}" disabled />
                </div> -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Mệnh Giá </label>
                    <input type="text" class="w-full border rounded px-3 py-2" value="{{ $donHang->so_luong * $donHang->sanpham->menh_gia }}" disabled />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Số Lượng</label>
                    <input type="text" class="w-full border rounded px-3 py-2" value="{{$donHang->so_luong}}" disabled />
                </div>


                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Trạng Thái</label>
                    <select name="trang_thai" class="w-full border rounded px-3 py-2">
                        <option value="Hoạt động" {{ $donHang->trang_thai == 'Hoạt động' ? 'selected' : '' }}>Hoạt Động</option>
                        <option value="Chờ xử lý" {{ $donHang->trang_thai == 'Chờ xử lý' ? 'selected' : '' }}>Đang Xử Lý</option>
                        <option value="Đã huỷ" {{ $donHang->trang_thai == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{route('admin.mathecao.donhang.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>

                    <button class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật Đơn Hàng</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>