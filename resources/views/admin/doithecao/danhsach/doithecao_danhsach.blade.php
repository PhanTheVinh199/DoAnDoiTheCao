@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">
                    <a href="{{ route('admin.doithecao.danhsach.create') }}" class="btn btn-danger">Thêm Sản Phẩm</a>
                </div>

                {{-- Tạo nút cho mỗi nhà cung cấp --}}
                @foreach ($nhacungcap as $item)
                    <button class="btn btn-dark" onclick="showTable('{{ $item->ten }}')">{{ $item->ten }}</button>
                @endforeach

                <br><br>

                <!-- Lặp qua các bảng sản phẩm của nhà cung cấp -->
                @foreach ($nhacungcap as $index => $item)
                    <table class="table table-bordered" id="{{ $item->ten }}" style="display: {{ $index == 0 ? 'table' : 'none' }};">
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
                            @php $hasProduct = false; @endphp
                            @foreach ($danhsach as $product)
                                @if ($product->nhacungcap && $product->nhacungcap->ten === $item->ten)
                                    @php $hasProduct = true; @endphp
                                    <tr>
                                        <td>{{ $product->id_doithecao }}</td>
                                        <td>{{ $product->nhacungcap->ten }}</td>
                                        <td>{{ number_format($product->menh_gia, 0, ',', '.') }} VNĐ</td>
                                        <td>{{ $product->chiet_khau }}%</td>
                                        <td>
                                            @if($product->trang_thai == '1')
                                                <button type="button" class="btn btn-success">Hoạt động</button>
                                            @elseif($product->trang_thai == '0')
                                                <button type="button" class="btn btn-danger">Đã hủy</button>
                                            @elseif($product->trang_thai == '2')
                                                <button type="button" class="btn btn-warning">Chờ xử lý</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.doithecao.danhsach.edit', $product->id_doithecao) }}" class="btn btn-sm btn-primary">Sửa</a>
                                            <button class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $product->id_doithecao }}', '{{ $product->nhacungcap->ten }}')">Xóa</button>

                                            {{-- Form xóa ẩn --}}
                                            <form id="delete-form-{{ $product->id_doithecao }}" action="{{ route('admin.doithecao.danhsach.destroy', $product->id_doithecao) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if (!$hasProduct)
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có sản phẩm</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Hiển thị bảng theo nhà cung cấp
        function showTable(network) {
            let tables = document.querySelectorAll("table");
            tables.forEach(table => table.style.display = "none");

            let buttons = document.querySelectorAll("button");
            buttons.forEach(button => button.classList.remove("active"));

            let table = document.getElementById(network);
            if (table) table.style.display = "table";

            let activeButton = document.querySelector(`button[onclick="showTable('${network}')"]`);
            if (activeButton) activeButton.classList.add("active");
        }

        // Xác nhận xóa bằng SweetAlert2
        function confirmDelete(id, name) {
            Swal.fire({
                title: `Bạn có chắc chắn muốn xóa sản phẩm của nhà cung cấp "${name}"?`,
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi form ẩn để xóa
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Hiển thị toast khi có session
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 3500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            @endif
        });
    </script>
</div>
