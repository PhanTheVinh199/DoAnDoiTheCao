<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Đơn Hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-lg font-semibold">Cập Nhật Đơn Hàng</h2>
            <a href="{{ route('admin.doithecao.donhang.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('admin.doithecao.donhang.update', $donhang->id_dondoithe) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            @php
                $fields = [
                    ['label' => 'Mã Đơn', 'name' => 'ma_don'],
                    ['label' => 'Mã Thẻ', 'name' => 'ma_the'],
                    ['label' => 'Serial', 'name' => 'serial'],
                ];
            @endphp

            @foreach ($fields as $field)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $field['label'] }}</label>
                    <input
                        type="text"
                        name="{{ $field['name'] }}"
                        value="{{ old($field['name'], $donhang->{$field['name']}) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                        disabled
                    >
                    @error($field['name'])
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sản Phẩm</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
                    <option>-- Chọn sản phẩm --</option>
                    @foreach (\App\Models\DoithecaoDanhsach::all() as $sp)
                        <option value="{{ $sp->id_doithecao }}"
                            {{ old('doithecao_id', $donhang->doithecao_id) == $sp->id_doithecao ? 'selected' : '' }}>
                            {{ $sp->ten_san_pham ?? 'Sản phẩm #' . $sp->id_doithecao }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Số Lượng</label>
                <input type="number" value="{{ old('so_luong', $donhang->so_luong) }}" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thành Tiền</label>
                <input type="number" value="{{ old('thanh_tien', $donhang->thanh_tien) }}" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng Thái</label>
                <select name="trang_thai" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="1" {{ old('trang_thai', $donhang->trang_thai) == 1 ? 'selected' : '' }}>Hoạt Động</option>
                    <option value="2" {{ old('trang_thai', $donhang->trang_thai) == 2 ? 'selected' : '' }}>Đang Xử Lý</option>
                    <option value="0" {{ old('trang_thai', $donhang->trang_thai) == 0 ? 'selected' : '' }}>Đã Hủy</option>
                </select>
                @error('trang_thai')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('admin.doithecao.donhang.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">Cập Nhật</button>
            </div>
        </form>
    </div>
</body>
</html>
