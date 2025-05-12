@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">
                    <a href="{{ route('admin.doithecao.danhsach.create') }}" class="btn btn-danger">Thêm Sản Phẩm</a>
                </div>

                <div class="mb-4">
                    @foreach($nhacungcaps as $ncc)
                        <button class="btn btn-dark me-2" onclick="showTable('{{ $ncc->ten }}')">{{ $ncc->ten }}</button>
                    @endforeach
                </div>

                @foreach($nhacungcaps as $ncc)
                    <table class="table table-bordered" id="{{ $ncc->ten }}" style="display: {{ $loop->first ? 'table' : 'none' }};">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Sản Phẩm</th>
                            <th>Mệnh Giá</th>
                            <th>Chiết Khấu</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($danhsach as $item)
                            @if ($item->nhacungcap && $item->nhacungcap->ten === $ncc->ten)
                                <tr>
                                    <td>{{ $item->id_doithecao }}</td>
                                    <td>{{ $item->nhacungcap->ten }}</td>
                                    <td>{{ number_format($item->menh_gia, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $item->chiet_khau }}%</td>
                                    <td>
                                        <select name="trang_thai" class="w-full border rounded px-3 py-2">
                                            <option value="hoat_dong" {{ $item->trang_thai == 1 ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="da_huy" {{ $item->trang_thai == 0 ? 'selected' : '' }}>Đã hủy</option>
                                            <option value="cho_xu_ly" {{ $item->trang_thai == 2 ? 'selected' : '' }}>Chờ xử lý</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.doithecao.danhsach.edit', $item->id_doithecao) }}"
                                           class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.doithecao.danhsach.destroy', $item->id_doithecao) }}"
                                              method="POST"
                                              style="display:inline;"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $danhsach->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTable(network) {
        // Ẩn tất cả các bảng
        @foreach($nhacungcaps as $ncc)
        document.getElementById("{{ $ncc->ten }}").style.display = "none";
        @endforeach
        // Hiển thị bảng được chọn
        document.getElementById(network).style.display = "table";
    }

    document.getElementById('menuToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>
