@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">
                    <a href="{{ route('admin.doithecao.danhsach.create') }}" class="btn btn-danger">Thêm Sản Phẩm</a>
                </div>

                <button class="btn btn-dark" onclick="showTable('Viettel')">Viettel</button>
                <button class="btn btn-dark" onclick="showTable('Mobifone')">Mobifone</button>
                <button class="btn btn-dark" onclick="showTable('VinaPhone')">VinaPhone</button>

                <br><br>

                <!-- Bảng giá Viettel -->
                <table class="table table-bordered" id="Viettel" style="display:table;">
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
                            @if ($item->nhacungcap && $item->nhacungcap->ten === 'Viettel')
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
                                        <a href="{{ route('admin.doithecao.danhsach.edit', $item->id_doithecao) }}" class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.doithecao.danhsach.destroy', $item->id_doithecao) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
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

                <!-- Bảng giá Mobifone -->
                <table class="table table-bordered" id="Mobifone" style="display:none;">
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
                            @if ($item->nhacungcap && $item->nhacungcap->ten === 'Mobifone')
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
                                        <a href="{{ route('admin.doithecao.danhsach.edit', $item->id_doithecao) }}" class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.doithecao.danhsach.destroy', $item->id_doithecao) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
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

                <!-- Bảng giá VinaPhone -->
                <table class="table table-bordered" id="VinaPhone" style="display:none;">
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
                            @if ($item->nhacungcap && $item->nhacungcap->ten === 'VinaPhone')
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
                                        <a href="{{ route('admin.doithecao.danhsach.edit', $item->id_doithecao) }}" class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.doithecao.danhsach.destroy', $item->id_doithecao) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('menuToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });

        function showTable(network) {
            document.getElementById("Viettel").style.display = "none";
            document.getElementById("Mobifone").style.display = "none";
            document.getElementById("VinaPhone").style.display = "none";
            document.getElementById(network).style.display = "table";
        }
    </script>
</div>
</body>
</html>