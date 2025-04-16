<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">

        @if ($errors->any())
            <div class="text-red-500 bg-red-100 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.doithecao.nhacungcap.update',  $nhacungcap -> id_nhacungcap) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tên Nhà Cung Cấp</label>
                <select name="ten" class="w-full border rounded px-3 py-2">
                    <option value="">-- Chọn nhà cung cấp --</option>
                    <option value="Viettel" {{ $nhacungcap->ten == 'Viettel' ? 'selected' : '' }}>Viettel</option>
                    <option value="Mobifone" {{ $nhacungcap->ten == 'Mobifone' ? 'selected' : '' }}>Mobifone</option>
                    <option value="Vinaphone" {{ $nhacungcap->ten == 'Vinaphone' ? 'selected' : '' }}>Vinaphone</option>
                </select>
            </div>
        
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Hình ảnh</label>
                <input type="file" name="hinh_anh" class="w-full border rounded px-3 py-2" />
                @if ($nhacungcap->hinh_anh)
                    <div class="mt-2">
                        <label class="block text-gray-700 mb-1">Ảnh hiện tại:</label>
                        <img src="{{ asset('storage/' . $nhacungcap->hinh_anh) }}" alt="Hình ảnh hiện tại" class="w-32 rounded border">
                    </div>
                @endif
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.doithecao.nhacungcap.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a>
                <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật Sản Phẩm</button>
            </div>
        </form>
    </div>
</body>
</html>