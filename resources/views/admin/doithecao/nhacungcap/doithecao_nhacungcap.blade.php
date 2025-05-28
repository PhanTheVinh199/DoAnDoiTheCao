@include('admin.sidebar')

<!-- Không dùng alert bootstrap nữa -->

<!-- Main Content -->
<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Nhà Cung Cấp</h1>

                <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end" style="width: 1100px">
                    <a href="{{ route('admin.doithecao.nhacungcap.add') }}" class="btn btn-primary">Thêm Nhà Cung Cấp</a>
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
                        @forelse ($nhacungcaps as $nhacungcap)
                            <tr id="row-{{ $nhacungcap->id_nhacungcap }}">
                                <td>{{ $nhacungcap->id_nhacungcap }}</td>
                                <td>{{ $nhacungcap->ten }}</td>
                                <td>
                                    @if ($nhacungcap->hinh_anh)
                                        <img src="{{ asset($nhacungcap->hinh_anh) }}" alt="img-the" width="60"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $nhacungcap->ngay_tao }}</td>
                                <td>
                                    @if ($nhacungcap->trang_thai == 'hoat_dong')
                                        <button type="button" class="btn btn-success">Hoạt Động</button>
                                    @else
                                        <button type="button" class="btn btn-secondary">Đã Ẩn</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.doithecao.nhacungcap.edit', $nhacungcap->id_nhacungcap) }}" class="btn btn-dark">Sửa</a>
                                    <button class="btn btn-danger btn-delete"
                                        data-id="{{ $nhacungcap->id_nhacungcap }}"
                                        data-updated-at="{{ $nhacungcap->updated_at?->toDateTimeString() }}">
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có nhà cung cấp nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Phân Trang -->
                <div class="d-flex justify-content-end pt-5">
                    {{ $nhacungcaps->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Thiết lập CSRF token cho tất cả request ajax
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });

    // Hiện thông báo success/error session bằng SweetAlert giữa trang
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK',
        position: 'center',
        allowOutsideClick: false,
        allowEscapeKey: false,
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK',
        position: 'center',
        allowOutsideClick: false,
        allowEscapeKey: false,
    });
    @endif

    // Bắt sự kiện click nút xóa
    $('.btn-delete').click(function () {
        const id = $(this).data('id');
        const updatedAt = $(this).data('updated-at');
        const btn = this;

        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.disabled = true; // disable nút tránh bấm lại

                $.ajax({
                    url: '{{ url('admin/doithecao/nhacungcap') }}/' + id,
                    type: 'DELETE',
                    data: { updated_at: updatedAt },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: response.message,
                            timer: 2500,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        }).then(() => {
                            // Ẩn và xóa dòng trong bảng
                            $('#row-' + id).fadeOut(400, function() { $(this).remove(); });
                        });
                    },
                    error: function (xhr) {
                        let message = 'Có lỗi xảy ra';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: message,
                            confirmButtonText: 'Tải lại trang',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(() => {
                            location.reload();
                        });
                        btn.disabled = false;
                    }
                });
            }
        });
    });
});
</script>
