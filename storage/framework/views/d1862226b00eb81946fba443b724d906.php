<?php echo $__env->make('admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>




<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách </h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 850px;">


                    <form method="GET" action="<?php echo e(route('admin.nganhang.index')); ?>"
                        class="d-flex justify-content-start">
                        <!-- Ô tìm kiếm -->
                        <input type="text" name="search" placeholder="Tìm kiếm Tài Khoản" class="form-control me-2"
                            value="<?php echo e(request()->get('search')); ?>" style="width: 200px;">
                        <!-- Nút tìm kiếm -->
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>



                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tài Khoản</th>
                            <th>Ngân Hàng</th>
                            <th>Số Tài Khoản</th>
                            <th>Chủ TK</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dsNganHang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($item->id_danhsach); ?></td>
                            <td><?php echo e($item->thanhvien->tai_khoan ?? 'Null'); ?></td>
                            <td><?php echo e($item->ten_ngan_hang); ?></td>
                            <td><?php echo e($item->so_tai_khoan); ?></td>
                            <td><?php echo e($item->chu_tai_khoan); ?></td>
                            <td>
                                <?php if($item->trang_thai == 'hoat_dong'): ?>
                                <button type="button" class="btn btn-success">Hoạt Động</button>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="<?php echo e(route('admin.nganhang.delete', $item->id_danhsach)); ?>" method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-dark">Xóa</button>
                                </form>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu phù hợp với tìm kiếm của bạn.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Phân Trang -->
                <div class="d-flex justify-content-end pt-5">
                    <?php echo e($dsNganHang->links('pagination::bootstrap-4')); ?>

                </div>







            </div><?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/admin/nganhang/danhsach/nganhang.blade.php ENDPATH**/ ?>