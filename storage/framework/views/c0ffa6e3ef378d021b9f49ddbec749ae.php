<?php echo $__env->make('admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>;
    <div class="main" style="margin-top: 10px; padding: 50px">
        <div class="container">
            <div class="row d-flex">

                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Nhà Cung Cấp</h1>
                    <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">

                        <!-- <input type="text" placeholder="Sản Phẩm" class="form-control w-auto"> -->
                        <a href="<?php echo e(route('admin.mathecao.nhacungcap_add')); ?>" class="btn btn-primary">Thêm Nhà Cung Cấp</a>

                        <!-- <button class="btn btn-danger">Bỏ lọc</button> -->
                    </div>
                    
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Sản Phẩm</th>
                                <th>Hình Ảnh</th>
                                <th>Ngày Tạo</th>
                                <th>Trạng Thái</th>

                                <th>Hành động</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Viettel</td>
                                <td>
                                    <img src="./public/img/the-viettel.png" alt="img-the">
                                </td>


                                <td>2025-04-01 12:08:30</td>
                                <td>
                                    <button type="button" class="btn btn-success">Hoạt Động</button>
                                </td>

                                <td>
                                    <a href="<?php echo e(route('admin.mathecao.nhacungcap_edit')); ?>" class="btn btn-dark">Sửa</a>
                                    <a href="" class="btn btn-dark">Xóa</a>
                                    <a href="" class="btn btn-dark">Ẩn</a>
                                </td>
                            </tr>
                            


                        </tbody>
                    </table>
                    <!-- <div class="d-flex align-items-center mt-4">
                        <select class="form-select w-auto me-2">
                            <option>-- Chọn thao tác --</option>
                        </select>
                        <button class="btn btn-primary">Thực hiện</button>
                    </div> -->
                </div>






















                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
                <!-- <script src="https://cdn.tailwindcss.com"></script> -->
                <script>
                    // Xử lý sự kiện mở/tắt sidebar khi nhấn vào nút ☰
                    document.getElementById('menuToggle').addEventListener('click', function () {
                        document.getElementById('sidebar').classList.toggle('open');
                    });
                </script>

</body>

</html><?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/admin/mathecao/nhacungcap/mathecao_nhacungcap.blade.php ENDPATH**/ ?>