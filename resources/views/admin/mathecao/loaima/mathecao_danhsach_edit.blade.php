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
                <a href="{{route('admin.mathecao.loaima.index')}}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="p-4">
                <input type="hidden" name="ngay_cap_nhat" value="{{ optional($dsSanPham->ngay_cap_nhat)->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s') }}">
                <input name="id_mathecao" type="hidden" value="{{$dsSanPham->id_mathecao}}">
                <div class="mb-4">
                    <em>
                        <h1 style="text-align: center;">Nhà Cung Cấp</h1>
                    </em>
                    <b><label style="text-align: center;" class="block text-gray-700 mb-2">{{$dsSanPham->nhaCungCap->ten}}</label></b>
                </div>
                <div class="mb-4" hidden>
                    <label class="block text-gray-700 mb-2">Hình ảnh</label>
                    <input type="file" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="mb-4">
                    <label for="menh_gia" class="block text-gray-700 mb-2">Mệnh Giá</label>
                    <input type="number" name="menh_gia" id="menh_gia" class="w-full border rounded px-3 py-2" value="{{ $dsSanPham->menh_gia }}" required min="10000" max="5000000" step="10000" />
                    <small id="menh_gia-help" class="text-sm text-gray-500 mt-1 block">
                        Chỉ được nhập từ 10.000 đến 5.000.000 VND
                    </small>
                </div>

                <div class="mb-4">
                    <label for="chiet_khau" class="block text-gray-700 mb-2">Chiết Khấu</label>
                    <input type="number" name="chiet_khau" id="chiet_khau" class="w-full border rounded px-3 py-2" value="{{ $dsSanPham->chiet_khau }}" required min="0" max="100" step="0.1" />
                    <small id="chiet_khau-help" class="text-sm text-gray-500 mt-1 block">
                        Nhập giá trị từ 0 đến 100 (%)
                    </small>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Trạng thái</label>
                    <select class="w-full border rounded px-3 py-2" name="trang_thai">
                        <option value="hoat_dong" {{ $dsSanPham->trang_thai === 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="an" {{ $dsSanPham->trang_thai === 'an' ? 'selected' : '' }}>Ẩn</option>
                        <!-- <option value="test" {{ $dsSanPham->trang_thai === 'test' ? 'selected' : '' }}>Test Lỗi</option> -->
                    </select>
                </div>



                <div class="flex justify-end space-x-2">
                    <a href="{{route('admin.mathecao.loaima.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật Sản Phẩm</button>
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