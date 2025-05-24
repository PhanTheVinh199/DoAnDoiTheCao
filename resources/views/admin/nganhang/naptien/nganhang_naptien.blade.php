@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: "{{ session('success') }}",
            timer: 2000,
            confirmButtonText: 'Ok',
        });
    </script>
    @endif
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Lịch sử Nạp</h1>

                <!-- Tìm kiếm -->
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 850px;">
                    <form action="{{ route('admin.nganhang.naptien.index') }}" method="GET" class="d-flex">
                        <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto" value="{{ request()->input('ma_don') }}">
                        <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                    </form>
                </div>

                <!-- Bảng lịch sử nạp -->
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã Đơn</th>
                            <th>Tên Đăng Nhập</th>
                            <th>Số Tiền Nạp</th>
                            <th>Nội Dung</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dsNapTien as $item)
                        <tr>
                            <td>{{ $item->id_lichsunap }}</td>
                            <td>{{ $item->ma_don }}</td>
                            <td>{{ optional($item->thanhvien)->tai_khoan }}</td>
                            <td>{{ number_format($item->so_tien_nap, 0, ',', '.') }} đ</td>
                            <td>{{ $item->noi_dung }}</td>
                            <td>{{ $item->ngay_tao }}</td>
                            <td>
                                <!-- Trạng thái -->
                                @if ($item->trang_thai == 'cho_duyet')
                                <button type="button" class="btn btn-warning">Chờ Phê Duyệt</button>
                                @elseif($item->trang_thai == 'da_duyet')
                                <button type="button" class="btn btn-success">Đã Duyệt</button>
                                @elseif($item->trang_thai == 'huy')
                                <button type="button" class="btn btn-danger">Hủy</button>
                                @endif
                            </td>
                            <td>
                                <!-- Chỉnh sửa và xóa -->
                                <a href="{{ route('admin.nganhang.naptien.edit', $item->id_lichsunap) }}" class="btn btn-dark d-inline-block mr-2">Sửa</a>
                                <form action="{{ route('admin.nganhang.naptien.delete', $item->id_lichsunap) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>


                <!-- Phân trang -->
                <div class="d-flex justify-content-end pt-5">
                    {{ $dsNapTien->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    // Xử lý sự kiện mở/tắt sidebar khi nhấn vào nút ☰
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>