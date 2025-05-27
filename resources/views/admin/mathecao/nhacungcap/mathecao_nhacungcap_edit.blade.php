<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <form action="{{ route('admin.mathecao.nhacungcap.update', $ncc->id_nhacungcap) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-lg font-semibold">Cập nhật Nhà Cung Cấp</h2>
                <a href="{{route('admin.mathecao.nhacungcap.index')}}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="p-4">
                <input type="hidden" name="ngay_cap_nhat" value="{{ optional($ncc->ngay_cap_nhat)->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s') }}">
                <input name="id_nhacungcap" type="hidden" value="{{$ncc->id_nhacungcap}}">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Tên nhà cung cấp</label>
                    <input type="text" name="ten" id="ten" class="w-full border rounded px-3 py-2" value="{{$ncc->ten}}" maxlength="50" required />
                    <small id="ten-count" class="text-sm text-gray-500 mt-1 block">{{ mb_strlen($ncc->ten) }}/50 ký tự</small>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Hình ảnh</label>
                    @if ($ncc->hinhanh)
                        <img src="{{ asset($ncc->hinhanh) }}" width="100" class="mb-2">
                    @endif
                    <input type="file" name="hinhanh" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Trạng thái</label>
                    <select class="w-full border rounded px-3 py-2" name="trang_thai">
                        <option value="hoat_dong" {{ $ncc->trang_thai === 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="an" {{ $ncc->trang_thai === 'an' ? 'selected' : '' }}>Ẩn</option>
                        <!-- <option value="test" {{ $ncc->trang_thai === 'test' ? 'selected' : '' }}>Test Lỗi</option> -->
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <a href="{{route('admin.mathecao.nhacungcap.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Cập nhật</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        const tenInput = document.getElementById('ten');
        const tenCount = document.getElementById('ten-count');
        tenInput.addEventListener('input', () => {
            tenCount.textContent = `${tenInput.value.length}/50 ký tự`;
        });
    </script>
</body>

</html>
