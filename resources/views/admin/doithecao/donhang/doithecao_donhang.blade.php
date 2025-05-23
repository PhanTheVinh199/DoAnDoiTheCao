@include('admin.sidebar')

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="main" style="margin-top: 10px; padding: 30px">
    <div class="container">
        <div class="row d-flex justify-content-end mb-4">
            <form action="{{ route('admin.doithecao.donhang.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto" value="{{ request('ma_don') }}">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        <div class="bg-white p-3 rounded shadow">
            <h1 class="h2 mb-4">Đơn Hàng</h1>

            <table class="table table-bordered table-hover align-middle text-center">
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
                        <td>{{ $order->doithecao->nhacungcap->ten ?? 'N/A' }}</td>
                        <td>{{ $order->ma_the }}</td>
                        <td>{{ $order->serial }}</td>
                        <td>{{ number_format($order->doithecao->menh_gia ?? 0, 0, ',', '.') }} VND</td>
                        <td>{{ $order->so_luong }}</td>
                        <td>{{ $order->doithecao->chiet_khau ?? 'N/A' }}%</td>
                        <td>{{ number_format($order->thanh_tien, 0, ',', '.') }} VND</td>
                        <td>{{ $order->thanhvien->tai_khoan ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->ngay_tao)->format('d/m/Y H:i') }}</td>
                        <td>
                            @switch($order->trang_thai)
                                @case('cho_xu_ly')
                                    <span class="badge bg-warning text-dark">Chờ phê duyệt</span>
                                    @break
                                @case('da_huy')
                                    <span class="badge bg-danger">Lỗi</span>
                                    @break
                                @case('hoat_dong')
                                    <span class="badge bg-success">Thành Công</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Không xác định</span>
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('admin.doithecao.donhang.edit', $order->id_dondoithe) }}" class="btn btn-sm btn-info" title="Sửa đơn hàng">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.doithecao.donhang.destroy', $order->id_dondoithe) }}"
                                  method="POST"
                                  class="d-inline delete-form"
                                  data-id="{{ $order->id_dondoithe }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Xóa đơn hàng">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end pt-3">
                {{ $donhang->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar')?.classList.toggle('open');
        });

        // Handle concurrent deletion
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const productId = this.dataset.id;

                try {
                    // Correctly format the URL with the ID parameter
                    const checkUrl = `{{ url('admin/doithecao/donhang/check') }}/${productId}`;
                    const response = await fetch(checkUrl);
                    const data = await response.json();

                    if (!data.exists) {
                        alert('Đơn hàng này đã bị xóa bởi người dùng khác!');
                        location.reload();
                        return;
                    }

                    // If the item exists, proceed with form submission
                    this.submit();
                } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                }
            });
        });
    });
</script>
