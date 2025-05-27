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
            <input type="hidden" name="ngay_cap_nhat" value="{{ optional($donHang->ngay_cap_nhat)->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s') }}">
            <input name="id_mathecao" type="hidden" value="{{$donHang->id_mathecao}}">
            <div class="p-4">
                <em>
                    <h1 style="text-align: center;">Nhà Cung Cấp</h1>
                </em>
                <b><label style="text-align: center;" class="block text-gray-700 mb-2">{{$nhaCungCap}}</label></b>
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
                        <option value="hoat_dong" {{ $donHang->trang_thai == 'hoat_dong' ? 'selected' : '' }}>Hoạt Động</option>
                        <option value="cho_xu_ly" {{ $donHang->trang_thai == 'cho_xu_ly' ? 'selected' : '' }}>Chờ Xử Lý</option>
                        <option value="da_huy" {{ $donHang->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                        <!-- <option value="test" {{ $donHang->trang_thai === 'test' ? 'selected' : '' }}>Test Lỗi</option> -->
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{route('admin.mathecao.donhang.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>

                    <button class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật Đơn Hàng</button>
                </div>
            </div>
        </div>
    </form>
    @if(session('concurrency_error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo',
            text: "{{ session('concurrency_error') }}",
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.reload();
        });
    </script>
    @endif
</body>

</html>