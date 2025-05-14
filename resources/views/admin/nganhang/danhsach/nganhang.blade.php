@include('admin.sidebar')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-white p-4 rounded shadow">
                    <!-- Header Section -->
                    <div class="mb-4">
                        <div class="mb-3">
                            <h1 class="h2 mb-3">Danh Sách Ngân Hàng</h1>
                            <div class="d-flex align-items-center gap-3">
                                <!-- Add Bank Button -->
                                <a href="{{ route('admin.nganhang.create') }}" class="btn btn-success d-flex align-items-center">
                                    <i class="fas fa-plus-circle me-2"></i> Thêm Ngân Hàng
                                </a>

                                <!-- Search Form -->
                                <form method="GET" action="{{ route('admin.nganhang.index') }}" class="flex-grow-1">
                                    <div class="input-group">
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Tìm kiếm tài khoản..." 
                                               value="{{ request()->get('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Tài Khoản</th>
                                    <th width="20%">Ngân Hàng</th>
                                    <th width="15%">Số Tài Khoản</th>
                                    <th width="20%">Chủ TK</th>
                                    <th width="10%">Trạng Thái</th>
                                    <th width="10%">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dsNganHang as $item)
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
                                        <div class="btn-group">
                                            
                                            <form action="{{ route('admin.nganhang.delete', $item->id_danhsach) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa ngân hàng này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <i class="fas fa-database me-2"></i>
                                        Không có dữ liệu ngân hàng
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