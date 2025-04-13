<?php echo $__env->make('admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>;

    <div class="main" style="margin-top: 10px; padding: 30px">
        <div class="container">
            <div class="row d-flex">

                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Đơn bán thẻ</h1>
                    <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">
                        
                        <input type="text" placeholder="Mã Đơn" class="form-control w-auto">
                        <button class="btn btn-primary">Tìm kiếm</button>
                        <!-- <button class="btn btn-danger">Bỏ lọc</button> -->
                    </div>
                    <div class="d-flex gap-4 mb-4" style="margin-left: 500px;">
                        
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Mã Đơn </th>
                                <th>Sản Phẩm</th>
                                <!-- <th>Mã Thẻ</th>
                                <th>Seri</th> -->
                                <th>Mệnh giá</th>

                                <th>Số lượng</th>
                                <th>Chiếc khấu</th>
                                <th>Thành tiền</th>
                                <th>Khách Hàng</th>
                                <th>Email nhận Thẻ</th>
                                <th>Ngày tạo</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>ord-123</td>
                                <td>Viettel</td>
                                <!-- <td>72238866089289</td>
                                <td>59850007774848</td> -->
                                <td>200,000 </td>

                                <td>1</td>
                                <td>10%</td>
                                <td>183,000 </td>

                                <td>admin</td>
                                <td>admin@gmail.com</td>
                                <td>2025-04-01 12:08:30</td>
                                <td>
                                    <button type="button" class="btn btn-success" style="font-size: 13px;">Hoạt
                                        Động</button>
                                </td>

                                <td>
                                    <a href="<?php echo e(route('admin.mathecao.donhang_edit')); ?>" class="btn btn-dark">Sửa</a>
                                    <!-- <a href="<?php echo e(route('admin.mathecao.donhang_edit', ['id' => 5])); ?>">Chỉnh sửa đơn hàng #5</a> -->
                                    <button type="button" class="btn btn-dark">Xóa</button>
                                </td>



                            </tr>
                            <!-- <tr>
                                <td>2</td>
                                <td>Vinaphone</td>
                                <td>72238866089289</td>
                                <td>59850007774848</td>
                                <td>100,000	</td>
                                <td>8%</td>
                                <td>1</td>
                                <td>192,000	</td>
                                
                                <td>admin</td>
                                <td>2025-04-01 12:08:30</td>
                                <td>
                                    <button type="button" class="btn btn-warning">Xử lí</button>
                                </td>
                                
                                <td>
                                    <button type="button" class="btn btn-success">Sửa</button>
                                    <button type="button" class="btn btn-danger">Xóa</button>
                                </td>
                               
                               
                                
                            </tr> -->
                            <!-- <tr>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0Thẻ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                              
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0Thẻ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                              
                               
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0Thẻ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0Thẻ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                
                               
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0Thẻ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0 đ</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                               
                            </tr> -->

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

</html><?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/admin/mathecao/donhang/mathecao_donhang.blade.php ENDPATH**/ ?>