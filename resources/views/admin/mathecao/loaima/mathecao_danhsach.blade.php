@include('admin.sidebar')


<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                <div class="d-flex flex-wrap gap-2 mb-4 " style="margin-left: 1000px;">

                    <!-- <input type="text" placeholder="Sản Phẩm" class="form-control w-auto"> -->
                    <a href="{{ route('admin.mathecao.loaima.create') }}" class="btn btn-danger">Thêm Sản Phẩm </a>

                    <!-- <button class="btn btn-danger">Bỏ lọc</button> -->
                </div>
                @foreach($dsNhaCungCap as $ncc)
                <button class="btn btn-dark" onclick="showTable('Viettel')">{{$ncc->ten}}</button>
                @endforeach

                <br><br>

                <!-- Bảng giá Viettel -->
                <table class="table table-bordered" id="Viettel" style="display:table;">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Sản Phẩm</th>
                            <!-- <th>Hình Ảnh</th> -->
                            <th>Mệnh Giá</th>
                            <th>Chiết Khấu</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dsSanPham as $sp)
                        <tr>
                            <td>{{$sp ->id_mathecao}}</td>
                            <td>{{$sp ->nhacungcap->ten}}</td>
                            <!-- <td><img src="./public/img/the-viettel.png" alt="img-the"></td> -->
                            <td>{{$sp ->menh_gia}}</td>
                            <td>{{$sp ->chiet_khau}}</td>
                            <td><button type="button" class="btn btn-success">{{$sp ->trang_thai}}</button></td>
                            <td>
                                <a href="{{ route('admin.mathecao.loaima.edit', $sp->id_mathecao)}}" class="btn btn-dark">Sửa</a>
                                <!-- <button type="button" class="btn btn-dark">Sửa</button> -->
                                <form action="{{ route('admin.mathecao.loaima.destroy', $sp->id_mathecao) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                                <button type="button" class="btn btn-dark">Ẩn</button>
                            </td>
                        </tr>
                        @endforeach
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
                document.getElementById('menuToggle').addEventListener('click', function() {
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