<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-500">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold">Cập Nhật Đơn Hàng</h2>
            <button class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nhà Cung Cấp</label>
                <select class="w-full border rounded px-3 py-2" disabled>
                    <option value="">-- Chọn nhà cung cấp --</option>
                    <option value="Viettel">Viettel</option>
                    <option value="Mobifone">Mobifone</option>
                    <option value="Vinaphone">Vinaphone</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Hình ảnh</label>
                <input type="file" class="w-full border rounded px-3 py-2" disabled />
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Mệnh Giá </label>
                <input type="text" class="w-full border rounded px-3 py-2" disabled />
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Số Lượng</label>
                <input type="text" class="w-full border rounded px-3 py-2" disabled />
            </div>
            

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Trạng Thái</label>
                <select class="w-full border rounded px-3 py-2">
                    <!-- <option value="">-- Chọn nhà cung cấp --</option> -->
                    <option value="Viettel">Hoạt Động</option>
                    <option value="Mobifone">Đang Xử Lý</option>
                    <option value="Vinaphone">Lỗi</option>
                </select>
            </div>
            
            <div class="flex justify-end space-x-2">
                <a href="<?php echo e(route('admin.mathecao.donhang')); ?>" class="bg-gray-500 text-white px-4 py-2 rounded">Đóng</a> 
                
                <button class="bg-red-700 text-white px-4 py-2 rounded">Cập nhật Đơn Hàng</button>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/admin/mathecao/donhang/mathecao_donhang_edit.blade.php ENDPATH**/ ?>