@include('admin.sidebar')




<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách </h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 850px;">


                    <form method="GET" action="{{ route('admin.nganhang.index') }}"
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
                            <th>Tài Khoản</th>
                            <th>Ngân Hàng</th>
                            <th>Số Tài Khoản</th>
                            <th>Chủ TK</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dsNganHang as $item)
                        <tr>
                            <td>{{ $item->id_danhsach }}</td>
                            <td>{{ $item->thanhvien->tai_khoan ?? 'Null' }}</td>
                            <td>{{ $item->ten_ngan_hang }}</td>
                            <td>{{ $item->so_tai_khoan }}</td>
                            <td>{{ $item->chu_tai_khoan }}</td>
                            <td>
                                @if($item->trang_thai == 'hoat_dong')
                                <button type="button" class="btn btn-success">Hoạt Động</button>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.nganhang.delete', $item->id_danhsach) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark">Xóa</button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu phù hợp với tìm kiếm của bạn.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Phân Trang -->
                <div class="d-flex justify-content-end pt-5">
                    {{ $dsNganHang->links('pagination::bootstrap-4') }}
                </div>







            </div>