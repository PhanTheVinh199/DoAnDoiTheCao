@include('admin.sidebar');
<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Nhà Cung Cấp</h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">

                    <!-- <input type="text" placeholder="Sản Phẩm" class="form-control w-auto"> -->
                    <a href="{{ route('admin.mathecao.nhacungcap.create') }}" class="btn btn-primary">Thêm Nhà Cung Cấp</a>

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
                        @foreach($dsNhaCungCap as $ncc)
                        <tr>
                            <td>{{ $ncc->id_nhacungcap }}</td>
                            <td>{{ $ncc->ten }}</td>
                            <td>
                                <img src="{{ asset($ncc->hinhanh) }}" alt="img-the">
                            </td>


                            <td>{{ $ncc->ngay_tao }}</td>
                            <td>
                                <button type="button" class="btn btn-success">{{ $ncc->trang_thai }}</button>
                            </td>

                            <td>
                                <a href="{{ route('admin.mathecao.nhacungcap.edit', $ncc->id_nhacungcap) }}" class="btn btn-dark">Sửa</a>
                                <form action="{{ route('admin.mathecao.nhacungcap.destroy', $ncc->id_nhacungcap) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>

                                <a href="" class="btn btn-dark">Ẩn</a>
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

            </body>

            </html>