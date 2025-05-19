   @include('admin.sidebar')

   <div class="container" style="margin-top: 10px; padding: 30px">
       <div class="row d-flex">
           <div class="bg-white p-3 rounded shadow">
               <h1>Danh Sách Ngân Hàng Admin</h1>

               @if(session('success'))
               <div class="alert alert-success">{{ session('success') }}</div>
               @endif

               <div class="mb-3">
                   <a href="{{ route('admin.nganhang.admin.create') }}" class="btn btn-primary">
                       <i class="fas fa-plus"></i> Thêm Ngân Hàng Admin
                   </a>
               </div>

               <form method="GET" action="{{ route('admin.nganhang.admin.index') }}" class="mb-3 d-flex">
                   <input type="text" name="search" placeholder="Tìm kiếm..." class="form-control me-2" value="{{ request('search') }}">
                   <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
               </form>

               <table class="table table-bordered table-hover">
                   <thead>
                       <tr>
                           <th>ID</th>
                           <th>Tên ngân hàng</th>
                           <th>Số tài khoản</th>
                           <th>Chủ tài khoản</th>
                           <th>Trạng thái</th>
                           <th>Admin liên kết</th>
                           <th>Hành động</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($banks as $bank)
                       <tr>
                           <td>{{ $bank->id_danhsach }}</td>
                           <td>{{ $bank->ten_ngan_hang }}</td>
                           <td>{{ $bank->so_tai_khoan }}</td>
                           <td>{{ $bank->chu_tai_khoan }}</td>
                           <td>
                               <span class="badge {{ $bank->trang_thai == 'hoat_dong' ? 'bg-success' : 'bg-danger' }}">
                                   {{ ucfirst(str_replace('_', ' ', $bank->trang_thai)) }}
                               </span>
                           </td>
                           <td>{{ $bank->thanhvien->tai_khoan ?? 'N/A' }}</td>
                           <td>
                               <form action="{{ route('admin.nganhang.admin.delete', $bank->id_danhsach) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa ngân hàng này?')">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" class="btn btn-danger btn-sm">
                                       <i class="fas fa-trash"></i> Xóa
                                   </button>
                               </form>
                           </td>
                       </tr>
                       @empty
                       <tr>
                           <td colspan="7" class="text-center">Không có ngân hàng admin nào.</td>
                       </tr>
                       @endforelse
                   </tbody>
               </table>

               <div class="d-flex justify-content-end pt-5">
                    {{ $banks->links('pagination::bootstrap-4') }}
                </div>

           </div>
       </div>
   </div>
