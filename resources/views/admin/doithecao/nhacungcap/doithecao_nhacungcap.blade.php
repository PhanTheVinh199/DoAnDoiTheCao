@include('admin.sidebar')

    <!-- Main Content -->
    <div class="main" style="margin-top: 10px; padding: 50px">
        <div class="container">
            <div class="row d-flex">
                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Nhà Cung Cấp</h1>
    
                    <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end">
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
                            @foreach ($nhacungcaps as $nhacungcap)
                                <tr>
                                    <td>{{ $nhacungcap->id_nhacungcap }}</td>
                                    <td>{{ $nhacungcap->ten }}</td>
                                    <td>
                                        @if ($nhacungcap->hinh_anh)
                                            <img src="{{ asset('storage/' . $nhacungcap->hinh_anh) }}" alt="img-the" width="60">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $nhacungcap->created_at }}</td>
                                    <td>
                                        @if ($nhacungcap->trang_thai == 'hoat_dong')
                                            <button type="button" class="btn btn-success">Hoạt Động</button>
                                        @else
                                            <button type="button" class="btn btn-secondary">Đã Ẩn</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.doithecao.nhacungcap.edit', $nhacungcap->id_nhacungcap) }}" class="btn btn-dark">Sửa</a>                        
                                        <form action="{{ route('admin.doithecao.nhacungcap.delete', $nhacungcap->id_nhacungcap) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                Xóa
                                            </button>
                                        </form>
                        
                                        @if ($nhacungcap->trang_thai == 'hoat_dong')
                                            <form action="{{ route('admin.doithecao.nhacungcap.hide', $nhacungcap->id_nhacungcap) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Ẩn</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.doithecao.nhacungcap.show', $nhacungcap->id_nhacungcap) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Hiện</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        
                            @if ($nhacungcaps->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có nhà cung cấp nào.</td>
                                </tr>
                            @endif
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>

</body>

</html>
