@include('admin.sidebar')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-white p-4 rounded shadow">
                    <!-- Header -->
                    <div class="mb-4">
                        <h1 class="h2 mb-3">Danh Sách Ngân Hàng Admin</h1>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <a href="{{ route('admin.nganhang.admin.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Thêm ngân hàng admin mới
                            </a>

                            <form method="GET" action="{{ route('admin.nganhang.admin.index') }}" class="flex-grow-1">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Tìm kiếm tài khoản admin..." 
                                           value="{{ request()->get('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Tài Khoản Admin</th>
                                    <th width="20%">Ngân Hàng</th>
                                    <th width="15%">Số Tài Khoản</th>
                                    <th width="20%">Chủ TK</th>
                                    <th width="10%">Trạng Thái</th>
                                    <th width="10%">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dsNganHang as $item)
                                    @if($item->thanhvien && $item->thanhvien->role === 'admin')
                                        <tr>
                                            <td>{{ $item->id_danhsach }}</td>
                                            <td>{{ $item->thanhvien->tai_khoan ?? 'N/A' }}</td>
                                            <td>{{ $item->ten_ngan_hang }}</td>
                                            <td>{{ $item->so_tai_khoan }}</td>
                                            <td>{{ $item->chu_tai_khoan }}</td>
                                            <td>
                                                @if($item->trang_thai == 'hoat_dong')
                                                    <span class="badge bg-success">Hoạt Động</span>
                                                @else
                                                    <span class="badge bg-danger">Ngừng Hoạt Động</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.nganhang.admin.delete', $item->id_danhsach) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa ngân hàng admin này?')"
                                                      style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3">
                                            <i class="fas fa-database me-2"></i>
                                            Không có dữ liệu ngân hàng admin
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4">
                        {{ $dsNganHang->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
