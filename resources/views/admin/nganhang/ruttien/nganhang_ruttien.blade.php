@include('admin.sidebar')


<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Lịch sử Rút Tiền</h1>

                <!-- Tìm kiếm -->
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 850px;">
                    <form action="{{ route('admin.nganhang.ruttien.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" placeholder="Mã Đơn " class="form-control w-auto"
                            style="margin-right: 10px" value="{{ request()->input('search') }}">
                        <button type="submit" class="btn btn-primary ml-5">Tìm kiếm</button>
                    </form>
                </div>

                <!-- Bảng lịch sử rút -->
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã Đơn</th>
                            <th>Tên Đăng Nhập</th>
                            <th>Ngân Hàng</th>
                            <th>Số Tài Khoản</th>
                            <th>Chủ TK</th>
                            <th>Số Tiền Rút</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dsRutTien as $item)
                            <tr>
                                <td>{{ $item->id_lichsurut }}</td>
                                <td>{{ $item->ma_don }}</td>
                                <td>{{ $item->thanhvien->tai_khoan }}</td>
                                <td>{{ $item->nganhang->ten_ngan_hang }}</td>
                                <td>{{ $item->nganhang->so_tai_khoan }}</td>
                                <td>{{ $item->nganhang->chu_tai_khoan }}</td>
                                <td>{{ number_format($item->so_tien_rut, 0, ',', '.') }} đ</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if ($item->trang_thai == 'cho_duyet')
                                        <button type="button" class="btn btn-warning">Chờ Phê Duyệt</button>
                                    @elseif($item->trang_thai == 'da_duyet')
                                        <button type="button" class="btn btn-success">Hoạt Động</button>
                                    @elseif($item->trang_thai == 'huy')
                                        <button type="button" class="btn btn-danger">Hủy</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.nganhang.ruttien.edit', $item->id_lichsurut) }}"
                                        class="btn btn-dark d-inline-block mr-2">Sửa</a>
                                   <form action="{{ route('admin.nganhang.ruttien.delete', $item->id_lichsurut) }}"
      method="POST" class="d-inline-block form-delete-{{ $item->id_lichsurut }}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-dark btn-confirm-delete" data-id="{{ $item->id_lichsurut }}">
        Xóa
    </button>
</form>

                                </td>
                            </tr>
                        @empty
                            <!-- Nếu không có dữ liệu, hiển thị thông báo -->
                            <tr>
                                <td colspan="10" class="text-center">Không có dữ liệu </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-end pt-5">
                    {{ $dsRutTien->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: "{{ session('error') }}",
        confirmButtonText: 'OK'
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-confirm-delete').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: "Thao tác này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector(`.form-delete-${id}`).submit();
                }
            });
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Thành Công',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK'
    });
</script>
@endif


