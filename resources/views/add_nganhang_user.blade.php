<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Ngân Hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold">Cập Nhật Ngân Hàng</h2>
            <a href="{{ route('ruttien') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        {{-- Hiển thị lỗi từ server (nếu có) --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('add_nganhang_user_store') }}" method="POST" id="bankForm">
            @csrf
            <div class="mb-4">
                <label for="ten_ngan_hang" class="block text-gray-700 font-medium mb-2">Ngân Hàng</label>
                <input type="text" name="ten_ngan_hang" id="ten_ngan_hang" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div class="mb-4">
                <label for="so_tai_khoan" class="block text-gray-700 font-medium mb-2">Số Tài Khoản</label>
                <input type="text" name="so_tai_khoan" id="so_tai_khoan" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div class="mb-4">
                <label for="chu_tai_khoan" class="block text-gray-700 font-medium mb-2">Chủ Tài Khoản</label>
                <input type="text" name="chu_tai_khoan" id="chu_tai_khoan" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('ruttien') }}" class="bg-gray-500 text-white px-4 py-2 rounded focus:outline-none hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-1"></i> Đóng
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded focus:outline-none hover:bg-blue-700">Cập Nhật</button>
            </div>
        </form>
    </div>

    {{-- Thông báo thành công từ session --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    {{-- Xử lý submit bằng JavaScript --}}
    <script type="text/javascript">
        document.getElementById('bankForm').onsubmit = function (e) {
            e.preventDefault();

            const tenNganHang = document.getElementById('ten_ngan_hang').value.trim();
            const soTaiKhoan = document.getElementById('so_tai_khoan').value.trim();
            const chuTaiKhoan = document.getElementById('chu_tai_khoan').value.trim();

            // Regex hỗ trợ tiếng Việt có dấu
            const regexChu = /^[\p{L}\s]+$/u;
            const regexSo = /^\d+$/;

            if (!regexChu.test(tenNganHang)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Tên ngân hàng chỉ được chứa chữ cái (có dấu) và khoảng trắng!',
                });
            } else if (!regexSo.test(soTaiKhoan)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Số tài khoản phải là số!',
                });
            } else if (!regexChu.test(chuTaiKhoan)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Chủ tài khoản chỉ được chứa chữ cái (có dấu) và khoảng trắng!',
                });
            } else {
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn thêm ngân hàng này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('bankForm').submit();
                    }
                });
            }
        }
    </script>

</body>
</html>
