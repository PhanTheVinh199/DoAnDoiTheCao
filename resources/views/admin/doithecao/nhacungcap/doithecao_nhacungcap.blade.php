@include('admin.sidebar')

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
                        <th>Nhà Cung Cấp</th>
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
                                <div style="width: 300px; height: 100px; position: relative; display: flex; justify-content: center; align-items: center;">
                                    @if ($nhacungcap->hinh_anh)
                                        <img src="{{ asset($nhacungcap->hinh_anh) }}"
                                             alt="{{ $nhacungcap->ten }}"
                                             class="nhacungcap-img"
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                             onerror="this.src='{{ asset('images/no-image.png') }}'">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}"
                                             alt="No Image"
                                             class="nhacungcap-img"
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    @endif
                                </div>

                            </td>
                            <td>{{ \Carbon\Carbon::parse($nhacungcap->created_at)->format('d/m/Y H:i:s') }}</td>
                            <td>
                                @if ($nhacungcap->trang_thai == 'hoat_dong')
                                    <button type="button" class="btn btn-success">Hoạt Động</button>
                                @else
                                    <button type="button" class="btn btn-secondary">Đã Ẩn</button>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.doithecao.nhacungcap.edit', $nhacungcap->id_nhacungcap) }}"
                                   class="btn btn-dark">Sửa</a>

                                <form action="{{ route('admin.doithecao.nhacungcap.delete', $nhacungcap->id_nhacungcap) }}"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>

                                @if ($nhacungcap->trang_thai == 'hoat_dong')
                                    <form action="{{ route('admin.doithecao.nhacungcap.hide', $nhacungcap->id_nhacungcap) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Ẩn</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.doithecao.nhacungcap.show', $nhacungcap->id_nhacungcap) }}"
                                          method="POST"
                                          style="display:inline;">
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

                <div class="d-flex justify-content-center mt-4">
                    {{ $nhacungcaps->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nhacungcap-img {
        width: 100%;
        max-width: 150px;
        height: auto;
        object-fit: contain;
    }

    table td img {
        width: 100%;
        max-width: 100px;
        height: auto;
    }

    .table td, .table th {
        text-align: center;
        vertical-align: middle;
    }

    .btn {
        font-size: 14px;
        margin: 0 2px;
    }

    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        border-radius: 6px;
        margin: 0 3px;
        transition: all 0.2s ease-in-out;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 123, 255, 0.2);
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }

    .pagination .page-link:hover {
        background-color: #e9f5ff;
        border-color: #007bff;
    }

    .pagination-summary,
    .small.text-muted {
        display: none !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    document.getElementById('menuToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>
</body>
</html>
