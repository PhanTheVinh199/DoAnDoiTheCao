<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Chỉnh sửa Nhà Cung Cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">

        {{-- Hiển thị lỗi session error --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded m-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Hiển thị lỗi validation --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded m-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.doithecao.nhacungcap.update', $nhacungcap->id_nhacungcap) }}" method="POST" enctype="multipart/form-data" class="p-6" id="editSupplierForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="updated_at" value="{{ $nhacungcap->updated_at ? $nhacungcap->updated_at->toDateTimeString() : '' }}">

            {{-- Tên nhà cung cấp --}}
            <div class="mb-6">
                <label for="ten" class="block text-gray-700 font-semibold mb-2">Tên Nhà Cung Cấp</label>
                <input type="text" id="ten" name="ten" value="{{ old('ten', $nhacungcap->ten) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                <p id="ten-error" class="text-red-600 text-sm mt-1" style="display:none;"></p>
                @error('ten')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ảnh hiện tại --}}
            @if ($nhacungcap->hinh_anh)
            <div class="mb-4">
                <p class="text-gray-700 font-semibold mb-2">Ảnh hiện tại:</p>
                <div class="w-32 h-32 border rounded overflow-hidden mb-2">
                    <img src="{{ asset($nhacungcap->hinh_anh) }}" alt="{{ $nhacungcap->ten }}" class="w-full h-full object-contain">
                </div>
                <p class="text-sm text-gray-600 break-words">{{ basename($nhacungcap->hinh_anh) }}</p>
            </div>
            @endif

            {{-- Upload ảnh mới --}}
            <div class="mb-6">
                <label for="hinh_anh" class="block text-gray-700 font-semibold mb-2">Thay đổi hình ảnh</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400"
                     id="dropZone"
                     onclick="document.getElementById('hinh_anh').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-blue-500');"
                     ondragleave="event.preventDefault(); this.classList.remove('border-blue-500');"
                     ondrop="event.preventDefault(); this.classList.remove('border-blue-500'); handleDrop(event);"
                >
                    <input type="file" id="hinh_anh" name="hinh_anh" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Kéo thả file vào đây hoặc click để chọn file</p>
                    <p class="text-sm text-gray-500 mt-1" id="fileName">Chưa có file nào được chọn</p>
                </div>

                @error('hinh_anh')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror

                <div id="previewContainer" class="hidden mt-4">
                    <p class="text-gray-700 font-semibold mb-2">Xem trước:</p>
                    <div class="w-32 h-32 border rounded overflow-hidden">
                        <img id="previewImage" class="w-full h-full object-contain" alt="Preview ảnh mới" />
                    </div>
                </div>
            </div>

            {{-- Trạng thái --}}
            <div class="mb-6" hidden>
                <label for="trang_thai" class="block text-gray-700 font-semibold mb-2">Trạng thái</label>
                <select id="trang_thai" name="trang_thai" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="hoat_dong" {{ old('trang_thai', $nhacungcap->trang_thai) == 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="an" {{ old('trang_thai', $nhacungcap->trang_thai) == 'an' ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('trang_thai')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nút submit và hủy --}}
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.doithecao.nhacungcap.index') }}"
                   class="bg-gray-500 text-white px-5 py-2 rounded hover:bg-gray-600 transition">Hủy</a>
                <button type="submit" id="submitBtn"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Cập nhật</button>
            </div>

        </form>
    </div>

<script>
$(document).ready(function() {
    const input = $('#hinh_anh');
    const previewContainer = $('#previewContainer');
    const previewImage = $('#previewImage');
    const fileNameEl = $('#fileName');

    // Bắt event change 1 lần duy nhất
    input.on('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            fileNameEl.text(file.name);

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.attr('src', e.target.result);
                previewContainer.removeClass('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            fileNameEl.text('Chưa có file nào được chọn');
            previewImage.attr('src', '');
            previewContainer.addClass('hidden');
        }
    });

    // Hàm xử lý kéo thả file
    window.handleDrop = function(event) {
        const dt = event.dataTransfer;
        const files = dt.files;
        if (files.length) {
            input[0].files = files;
            input.trigger('change'); // Kích hoạt event change để preview ảnh
        }
    };

    // Kiểm tra trùng tên realtime
    const tenInput = $('#ten');
    const tenError = $('#ten-error');
    const submitBtn = $('#submitBtn');
    const currentId = '{{ $nhacungcap->id_nhacungcap }}';

    tenInput.on('blur', function() {
        const tenValue = $(this).val().trim();

        if (tenValue === '') {
            tenError.text('Tên nhà cung cấp không được để trống.').show();
            submitBtn.prop('disabled', true);
            return;
        }

        $.ajax({
            url: '{{ route("admin.doithecao.nhacungcap.check-name") }}',
            method: 'GET',
            data: { ten: tenValue, exclude_id: currentId },
            success: function(response) {
                if (response.exists) {
                    tenError.text('Tên nhà cung cấp đã tồn tại, vui lòng chọn tên khác.').show();
                    submitBtn.prop('disabled', true);
                } else {
                    tenError.text('').hide();
                    submitBtn.prop('disabled', false);
                }
            },
            error: function() {
                tenError.text('').hide();
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>

</body>
</html>
