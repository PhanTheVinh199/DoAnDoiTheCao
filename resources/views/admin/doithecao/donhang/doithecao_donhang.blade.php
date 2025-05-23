@include('admin.sidebar')
<div class="main" style="margin-top: 10px; padding: 30px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Đơn Hàng</h1>
                <!-- Phần tìm kiếm -->
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">
                    <form action="{{ route('admin.doithecao.donhang.index') }}" method="GET" class="d-flex">
                        <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto"
                            value="{{ request('ma_don') }}">
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
                            <th>Mệnh giá</th>
                            <th>Số lượng</th>
                            <th>Chiết khấu</th>
                            <th>Thành tiền</th>
                            <th>Khách Hàng</th>
                            <th>Ngày tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donhang as $order)
                            <tr>
                                <td>{{ $order->id_dondoithe }}</td>
                                <td>{{ $order->ma_don }}</td>

                                <!-- Hiển thị tên sản phẩm từ mối quan hệ 'doithecao' -->
                                <td>{{ $order->doithecao->nhacungcap->ten ?? 'N/A' }}</td>

                                <td>{{ $order->ma_the }}</td>
                                <td>{{ $order->serial }}</td>

                                <!-- Hiển thị mệnh giá từ mối quan hệ 'doithecao' -->
                                <td>{{ number_format($order->doithecao->menh_gia ?? 0, 0, ',', '.') }} VND</td>

                                <td>{{ $order->so_luong }}</td>

                                <!-- Hiển thị chiết khấu từ mối quan hệ 'doithecao' -->
                                <td>{{ $order->doithecao->chiet_khau ?? 'N/A' }}%</td>

                                <!-- Thành tiền -->
                                <td>{{ number_format($order->thanh_tien, 0, ',', '.') }} VND</td>

                                <!-- Hiển thị tên khách hàng từ mối quan hệ 'thanhvien' -->
                                <td>{{ $order->thanhvien->tai_khoan ?? 'N/A' }}</td>

                                <td>{{ $order->ngay_tao }}</td>

                                <td>
                                    @if ($order->trang_thai == 'cho_xu_ly')
                                        <button type="button" class="btn btn-warning">Chờ phê duyệt</button>
                                    @elseif($order->trang_thai == 'da_huy')
                                        <button type="button" class="btn btn-danger">Lỗi</button>
                                    @elseif($order->trang_thai == 'hoat_dong')
                                        <button type="button" class="btn btn-success">Thành Công</button>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.doithecao.donhang.edit', $order->id_dondoithe) }}"
                                        class="btn btn-dark">Sửa</a>
                                    <form action="{{ route('admin.doithecao.donhang.destroy', $order->id_dondoithe) }}" method="POST" style="display:inline;" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-dark btn-delete">Xóa</button>
</form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-end pt-5">
                    {{ $donhang->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>

{{-- Thêm SweetAlert hiển thị thông báo success hoặc error --}}
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: "{{ session('success') }}",
        
        confirmButtonText: 'OK'
    });
</script>
@endif

@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: "{{ session('error') }}",
        confirmButtonText: 'OK'
    });
</script>
@endif

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();  // Ngăn submit form ngay

            const form = this.closest('form');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa đơn hàng này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();  // submit form nếu xác nhận
                }
            });
        });
    });
</script>

</body>
</html>
