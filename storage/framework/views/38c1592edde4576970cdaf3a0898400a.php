<?php echo $__env->make('admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Lịch sử Rút Tiền</h1>

                <!-- Tìm kiếm -->
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 850px;">
                    <form action="<?php echo e(route('admin.nganhang.ruttien.index')); ?>" method="GET" class="d-flex">
                        <input type="text" name="search" placeholder="Mã Đơn " class="form-control w-auto"
                            style="margin-right: 10px" value="<?php echo e(request()->input('search')); ?>">
                        <button type="submit" class="btn btn-primary ml-5">Tìm kiếm</button>
                    </form>
                </div>

                <!-- Bảng lịch sử rút -->
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã Đơn</th>
                            <th>Tên Đăng Nhập</th>
                            <th>Ngân Hàng</th>
                            <th>Số Tài Khoản</th>
                            <th>Chủ TK</th>
                            <th>Số Tiền Rút</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dsRutTien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->id_lichsurut); ?></td>
                                <td><?php echo e($item->ma_don); ?></td>
                                <td><?php echo e($item->thanhvien->tai_khoan); ?></td>
                                <td><?php echo e($item->nganhang->ten_ngan_hang); ?></td>
                                <td><?php echo e($item->nganhang->so_tai_khoan); ?></td>
                                <td><?php echo e($item->nganhang->chu_tai_khoan); ?></td>
                                <td><?php echo e(number_format($item->so_tien_rut, 0, ',', '.')); ?> đ</td>
                                <td><?php echo e($item->created_at); ?></td>
                                <td>
                                    <?php if($item->trang_thai == 'cho_duyet'): ?>
                                        <button type="button" class="btn btn-warning">Chờ Phê Duyệt</button>
                                    <?php elseif($item->trang_thai == 'da_duyet'): ?>
                                        <button type="button" class="btn btn-success">Hoạt Động</button>
                                    <?php elseif($item->trang_thai == 'huy'): ?>
                                        <button type="button" class="btn btn-danger">Hủy</button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.nganhang.ruttien.edit', $item->id_lichsurut)); ?>"
                                        class="btn btn-dark d-inline-block mr-2">Sửa</a>
                                    <form action="<?php echo e(route('admin.nganhang.ruttien.delete', $item->id_lichsurut)); ?>"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-dark">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <!-- Nếu không có dữ liệu, hiển thị thông báo -->
                            <tr>
                                <td colspan="10" class="text-center">Không có dữ liệu </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-end pt-5">
                    <?php echo e($dsRutTien->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/admin/nganhang/ruttien/nganhang_ruttien.blade.php ENDPATH**/ ?>