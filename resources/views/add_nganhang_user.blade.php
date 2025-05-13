<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cập Nhật Ngân Hàng</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold">Cập Nhật Ngân Hàng</h2>
            <a href="{{ route('ruttien') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

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
                <a href="{{ route('ruttien') }}" class="bg-gray-500 text-white px-4 py-2 rounded focus:outline-none hover:bg-gray-600">Đóng</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded focus:outline-none hover:bg-blue-700">Cập Nhật</button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        document.getElementById('bankForm').onsubmit = function (e) {
            e.preventDefault(); // Ngừng gửi form để kiểm tra trước

            // Kiểm tra dữ liệu trước khi gửi form
            let tenNganHang = document.getElementById('ten_ngan_hang').value;
            let soTaiKhoan = document.getElementById('so_tai_khoan').value;
            let chuTaiKhoan = document.getElementById('chu_tai_khoan').value;

            // Kiểm tra nếu dữ liệu không hợp lệ
            if (!/^[a-zA-Z\s]+$/.test(tenNganHang)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Tên ngân hàng chỉ được chứa chữ và khoảng trắng!',
                });
            } else if (!/^\d+$/.test(soTaiKhoan)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Số tài khoản phải là số hợp lệ!',
                });
            } else if (!/^[a-zA-Z\s]+$/.test(chuTaiKhoan)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Chủ tài khoản chỉ được chứa chữ và khoảng trắng!',
                });
            } else {
                // Nếu dữ liệu hợp lệ, yêu cầu xác nhận
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
                        // Gửi form nếu người dùng đồng ý
                        document.getElementById('bankForm').submit();
                    }
                });
            }
        }
    </script>

</body>
</html>
