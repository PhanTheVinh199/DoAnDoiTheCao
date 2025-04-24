@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 30px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Đơn bán thẻ</h1>
                <!-- Phần tìm kiếm -->
                <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end">
                    <form action="{{ route('admin.doithecao.donhang.index') }}" method="GET" class="d-flex">
                        <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto" value="{{ request('ma_don') }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã Đơn</th>
                            <th>Sản Phẩm</th>
                            <th>Mã Thẻ</th>
                            <th>Seri</th>
                            <th>Mệnh Giá</th>
                            <th>Số Lượng</th>
                            <th>Chiết Khấu</th>
                            <th>Thành Tiền</th>
                            <th>Khách Hàng</th>
                            <th>Thành Viên</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donhang as $order)
                            <tr>
                                <td>{{ $order->id_dondoithe }}</td>
                                <td>{{ $order->ma_don }}</td>
                                <td>{{ $order->doithecao->ten ?? 'N/A' }}</td>
                                <td>{{ $order->ma_the }}</td>
                                <td>{{ $order->serial }}</td>
                                <td>{{ number_format($order->thanh_tien, 0, ',', '.') }}</td>
                                <td>{{ $order->so_luong }}</td>
                                <td>{{ number_format($order->chiet_khau ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format($order->thanh_tien, 0, ',', '.') }}</td>
                                <td>{{ $order->khach_hang ?? 'N/A' }}</td>
                                <td>{{ $order->thanhvien->ten ?? 'N/A' }}</td>
                                <td>{{ $order->ngay_tao }}</td>
                                <td>
                                    <button type="button" class="btn btn-success">{{ $order->trang_thai }}</button>
                                </td>
                                <td>
                                    <a href="{{ route('admin.doithecao.donhang.edit', $order->id_dondoithe) }}" class="btn btn-dark">Sửa</a>
                                    <form action="{{ route('admin.doithecao.donhang.destroy', $order->id_dondoithe) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center">
                    {{ $donhang->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    document.getElementById('menuToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>
</body>
</html>
