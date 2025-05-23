@include('admin.sidebar')

@if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif


<div class="main" style="margin-top: 10px; padding: 30px">
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
    @if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Thành Viên</h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">
                    <form method="GET" action="{{ route('admin.thanhvien.danhsach') }}"
                        class="d-flex justify-content-start">
                        <input type="text" name="search" placeholder="Tìm kiếm Tài Khoản"
                            class="form-control me-2" value="{{ request()->get('search') }}"
                            style="width: 200px;">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ Tên</th>
                            <th>Tài Khoản</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Số Dư</th>
                            <th>Quyền</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dsThanhVien as $item)
                            <tr>
                                <td>{{ $item->id_thanhvien }}</td>
                                <td>{{ $item->ho_ten }}</td>
                                <td>{{ $item->tai_khoan }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->so_du }}</td>
                                <td style="color: red;">{{ $item->quyen }}</td>
                                <td><button type="button" class="btn btn-success">Hoạt Động</button></td>
                                <td>
                                    <a href="{{ route('admin.thanhvien.edit', $item->id_thanhvien) }}"
                                        class="btn btn-dark d-inline-block mr-2">Sửa</a>

                                    <form action="{{ route('admin.thanhvien.delete', $item->id_thanhvien) }}"
                                        method="POST" class="d-inline-block form-delete"
                                        data-id="{{ $item->id_thanhvien }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-dark btn-delete">Xóa</button>
                                    </form>

                                    <a href="{{ route('admin.thanhvien.naptien', $item->id_thanhvien) }}"
                                        class="btn btn-dark d-inline-block mr-2">Nạp Tiền</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end pt-5">
                    {{ $dsThanhVien->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // SweetAlert2 xử lý nút XÓA
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.form-delete');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Có, xóa ngay!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Hiển thị thông báo thành công nếu có session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif


       

    });
</script>
