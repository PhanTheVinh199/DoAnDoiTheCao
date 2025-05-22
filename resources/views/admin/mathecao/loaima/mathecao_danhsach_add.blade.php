<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </link>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <form action="{{ route('admin.mathecao.loaima.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-lg font-semibold">Thêm Sản Phẩm</h2>
                <a href="{{route('admin.mathecao.loaima.index')}}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Tên Nhà Cung Cấp</label>
                    <select name="nhacungcap_id" id="nhacungcap_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Chọn nhà cung cấp --</option>
                        @foreach($dsNhaCungCap as $ncc)
                        <option value="{{ $ncc->id_nhacungcap }}">{{ $ncc->ten }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Mệnh Giá </label>
                    <input type="number" name="menh_gia" class="w-full border rounded px-3 py-2" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Chiếc Khấu</label>
                    <input type="number" name="chiet_khau" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{route('admin.mathecao.loaima.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                    <button class="bg-red-700 text-white px-4 py-2 rounded">Thêm Sản Phẩm</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>