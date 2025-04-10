@include('admin.sidebar');

    <div class="main" style="margin-top: 10px; padding: 50px">
        <div class="container">
            <div class="row d-flex">

                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                    <div class="d-flex flex-wrap gap-2 mb-4 " style="margin-left: 1000px;">

                        <!-- <input type="text" placeholder="Sản Phẩm" class="form-control w-auto"> -->
                         <a href="./doithecao_danhsach_add.html" class="btn btn-danger">Thêm Sản Phẩm </a>

                        <!-- <button class="btn btn-danger">Bỏ lọc</button> -->
                    </div>

                    <button class="btn btn-dark" onclick="showTable('Viettel')">Viettel</button>
                    <button class="btn btn-dark" onclick="showTable('Mobifone')">Mobifone</button>
                    <button class="btn btn-dark" onclick="showTable('VinaPhone')">VinaPhone</button>

                    <br><br>

                    <!-- Bảng giá Viettel -->
                    <table class="table table-bordered" id="Viettel" style="display:table;">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Sản Phẩm</th>
                                <th>Hình Ảnh</th>
                                <th>Mệnh Giá</th>
                                <th>Chiết Khấu</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Viettel</td>
                                <td><img src="./public/img/the-viettel.png" alt="img-the"></td>
                                <td>10.000</td>
                                <td>10%</td>
                                <td><button type="button" class="btn btn-success">Hoạt Động</button></td>
                                <td>
                                    <a href="./doithecao_danhsach_edit.html" class="btn btn-dark">Sửa</a>
                                    <!-- <button type="button" class="btn btn-dark">Sửa</button> -->
                                    <button type="button" class="btn btn-dark">Xóa</button>
                                    <button type="button" class="btn btn-dark">Ẩn</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <!-- Bảng giá Mobifone -->
                    <table class="table table-bordered" id="Mobifone" style="display:none;">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Sản Phẩm</th>
                                <th>Hình Ảnh</th>
                                <th>Mệnh Giá</th>
                                <th>Chiết Khấu</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mobifone</td>
                                <td><img src="./public/img/the-mobifone.jpeg" alt="img-the"></td>
                                <td>10.000</td>
                                <td>5%</td>
                                <td><button type="button" class="btn btn-success">Hoạt Động</button></td>
                                <td>
                                    <!-- <button type="button" class="btn btn-dark">Sửa</button> -->
                                     <a href="./doithecao_danhsach_edit.html" class="btn btn-dark">Sửa</a>
                                    <button type="button" class="btn btn-dark">Xóa</button>
                                    <button type="button" class="btn btn-dark">Ẩn</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <!-- Bảng giá VinaPhone -->
                    <table class="table table-bordered" id="VinaPhone" style="display:none;">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Sản Phẩm</th>
                                <th>Hình Ảnh</th>
                                <th>Mệnh Giá</th>
                                <th>Chiết Khấu</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>VinaPhone</td>
                                <td><img src="./public/img/the-vinaphone.jpeg" alt="img-the"></td>
                                <td>10.000</td>
                                <td>7%</td>
                                <td><button type="button" class="btn btn-success">Hoạt Động</button></td>
                                <td>
                                    <button type="button" class="btn btn-dark">Sửa</button>
                                    <button type="button" class="btn btn-dark">Xóa</button>
                                    <button type="button" class="btn btn-dark">Ẩn</button>
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

                <script>
                    // Function to show specific table based on the selected network
                    function showTable(network) {
                        // Ẩn tất cả các bảng
                        document.getElementById("Viettel").style.display = "none";
                        document.getElementById("Mobifone").style.display = "none";
                        document.getElementById("VinaPhone").style.display = "none";

                        // Hiển thị bảng tương ứng với mạng được chọn
                        document.getElementById(network).style.display = "table";
                    }
                </script>

</body>

</html>
