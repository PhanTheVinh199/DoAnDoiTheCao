<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <form action="{{ route('admin.doithecao.nhacungcap.update', $nhacungcap->id_nhacungcap) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4 p-4">
            <label class="block text-gray-700 mb-2">Tên Nhà Cung Cấp</label>
            <select name="ten" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Chọn nhà cung cấp --</option>
                <option value="VIETTEL" {{ $nhacungcap->ten == 'VIETTEL' ? 'selected' : '' }}>Viettel</option>
                <option value="VINAPHONE" {{ $nhacungcap->ten == 'VINAPHONE' ? 'selected' : '' }}>Vinaphone</option>
                <option value="MOBIFONE" {{ $nhacungcap->ten == 'MOBIFONE' ? 'selected' : '' }}>Mobifone</option>
                <option value="ZING" {{ $nhacungcap->ten == 'ZING' ? 'selected' : '' }}>Zing</option>
                <option value="VNMOBI" {{ $nhacungcap->ten == 'VNMOBI' ? 'selected' : '' }}>Vietnamobile</option>
                <option value="GARENA" {{ $nhacungcap->ten == 'GARENA' ? 'selected' : '' }}>Garena (Duyệt nhanh)</option>
                <option value="GATE" {{ $nhacungcap->ten == 'GATE' ? 'selected' : '' }}>Gate</option>
                <option value="VCOIN" {{ $nhacungcap->ten == 'VCOIN' ? 'selected' : '' }}>Vcoin</option>
                <option value="APPOTA" {{ $nhacungcap->ten == 'APPOTA' ? 'selected' : '' }}>Appota</option>
                <option value="SCOIN" {{ $nhacungcap->ten == 'SCOIN' ? 'selected' : '' }}>Scoin</option>
            </select>
        </div>

        <div class="mb-4 p-4">
            <label class="block text-gray-700 mb-2">Hình ảnh</label>
            <div class="mb-4">
                @if ($nhacungcap->hinh_anh)
                    <div class="flex items-start space-x-4">
                        <div class="w-32 h-32 border rounded overflow-hidden">
                            <img src="{{ asset($nhacungcap->hinh_anh) }}"
                                 alt="{{ $nhacungcap->ten }}"
                                 class="w-full h-full object-contain"
                                 onerror="this.src='{{ asset('images/no-image.png') }}'">
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">File hiện tại:</p>
                            <p class="text-sm font-medium break-all">{{ basename($nhacungcap->hinh_anh) }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="relative">
                <input type="file"
                       name="hinh_anh"
                       id="hinh_anh"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                       onchange="updateFileInfo(this)">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Kéo thả file vào đây hoặc click để chọn file</p>
                    <p class="text-sm text-gray-500" id="selectedFileName">Chưa có file nào được chọn</p>
                </div>
            </div>

            <div id="imagePreview" class="mt-4 hidden">
                <p class="text-sm font-medium text-gray-700 mb-2">Xem trước:</p>
                <div class="w-32 h-32 border rounded overflow-hidden">
                    <img id="preview" class="w-full h-full object-contain">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-2 p-4 border-t">
            <a href="{{ route('admin.doithecao.nhacungcap.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                Đóng
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Cập nhật
            </button>
        </div>
    </form>
</div>

<style>
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        border-radius: 6px;
        margin: 0 3px;
        transition: all 0.2s ease-in-out;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 123, 255, 0.2);
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }

    .pagination .page-link:hover {
        background-color: #e9f5ff;
        border-color: #007bff;
    }

    .pagination-summary,
    .small.text-muted {
        display: none !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    function updateFileInfo(input) {
        const fileName = input.files[0] ? input.files[0].name : 'Chưa có file nào được chọn';
        document.getElementById('selectedFileName').textContent = fileName;

        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            previewDiv.classList.add('hidden');
        }
    }

    const dropZone = document.querySelector('input[type="file"]').parentElement;

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500');
        const fileInput = document.getElementById('hinh_anh');
        fileInput.files = e.dataTransfer.files;
        updateFileInfo(fileInput);
    });

    // Sidebar toggle
    if (document.getElementById('menuToggle')) {
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
    }
</script>
</body>
</html>
