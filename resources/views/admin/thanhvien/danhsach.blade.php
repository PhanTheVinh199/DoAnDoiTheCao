@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 30px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Thành Viên</h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">
                    <form method="GET" action="{{ route('admin.thanhvien.danhsach') }}"
                        class="d-flex justify-content-start">
                        <!-- Ô tìm kiếm -->
                        <input type="text" name="search" placeholder="Tìm kiếm Tài Khoản" class="form-control me-2"
                            value="{{ request()->get('search') }}" style="width: 200px;">
                        <!-- Nút tìm kiếm -->
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
                                <td>

                                    <button type="button" class="btn btn-success">Hoạt Động</button>

                                </td>

                                <td>
                                    <a href="{{ route('admin.thanhvien.edit', $item->id_thanhvien) }}"
                                        class="btn btn-dark d-inline-block mr-2">Sửa</a>

                                    <form action="{{ route('admin.thanhvien.delete', $item->id_thanhvien) }}"
                                        method="POST" class="d-inline-block"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark">Xóa</button>
                                    </form>
                                    {{-- <a href="{{ route('admin.thanhvien.naptien', $item->id_thanhvien) }}"
                                        class="btn btn-dark d-inline-block mr-2">Nạp Tiền</a> --}}




                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <!-- <div class="d-flex justify-content-center">
                    {{ $dsThanhVien->links() }}
                </div> -->
                <!-- Phân Trang -->
                <div class="d-flex justify-content-end pt-5">
                    {{ $dsThanhVien->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>
