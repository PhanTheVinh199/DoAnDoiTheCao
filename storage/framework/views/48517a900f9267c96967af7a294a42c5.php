<?php echo $__env->make('admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="main" style="margin-top: 10px; padding: 30px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Thành Viên</h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">
                    <form method="GET" action="<?php echo e(route('admin.thanhvien.danhsach')); ?>"
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
                            <th>Họ Tên</th>
                            <th>Tài Khoản</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Số Dư</th>
                            <th>Quyền</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dsThanhVien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->id_thanhvien); ?></td>
                                <td><?php echo e($item->ho_ten); ?></td>
                                <td><?php echo e($item->tai_khoan); ?></td>
                                <td><?php echo e($item->email); ?></td>
                                <td><?php echo e($item->phone); ?></td>
                                <td><?php echo e($item->so_du); ?></td>
                                <td style="color: red;"><?php echo e($item->quyen); ?></td>
                                <td>

                                    <button type="button" class="btn btn-success">Hoạt Động</button>

                                </td>

                                <td>
                                    <a href="<?php echo e(route('admin.thanhvien.edit', $item->id_thanhvien)); ?>"
                                        class="btn btn-dark d-inline-block mr-2">Sửa</a>

                                    <form action="<?php echo e(route('admin.thanhvien.delete', $item->id_thanhvien)); ?>"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-dark">Xóa</button>
                                    </form>
                                    




                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <!-- Phân trang -->
                <!-- <div class="d-flex justify-content-center">
                    <?php echo e($dsThanhVien->links()); ?>

                </div> -->
                <!-- Phân Trang -->
                <div class="d-flex justify-content-end pt-5">
                    <?php echo e($dsThanhVien->links('pagination::bootstrap-4')); ?>

                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/admin/thanhvien/danhsach.blade.php ENDPATH**/ ?>