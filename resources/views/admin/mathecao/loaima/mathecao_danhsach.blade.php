@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: "{{ session('success') }}",
            timer: 2000,
            confirmButtonText: 'Ok',
        });
    </script>
    @endif
    @if(session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: "{{ session('error') }}",
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if(session('concurrency_error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: "{{ session('concurrency_error') }}",
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">
                    <a href="{{ route('admin.mathecao.loaima.create') }}" class="btn btn-danger">Thêm Sản Phẩm </a>
                </div>

                <button class="btn btn-dark" onclick="filterBySupplier('all')">All</button>
                @foreach($dsNhaCungCap as $ncc)
                <button class="btn btn-dark" onclick="filterBySupplier('{{$ncc->id_nhacungcap}}')">{{$ncc->ten}}</button>
                @endforeach

                <br><br>


                <table class="table table-bordered" id="productTable">
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
                        @foreach($dsSanPham as $sp)
                        <tr class="product-row" data-supplier-id="{{$sp->nhacungcap_id}}">
                            <td>{{$sp->id_mathecao}}</td>
                            <td>{{$sp->nhacungcap?->ten ?? 'Chưa có nhà cung cấp'}}</td>
                            <td>{{$sp->menh_gia}}</td>
                            <td>{{$sp->chiet_khau}}</td>
                            <td>@if($sp->trang_thai == 'an')
                                <button type="button" class="btn btn-warning">Ẩn</button>
                                @elseif($sp->trang_thai == 'hoat_dong')
                                <button type="button" class="btn btn-success">Hoạt động</button>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.mathecao.loaima.edit', $sp->id_mathecao)}}" class="btn btn-dark">Sửa</a>
                                <form action="{{ route('admin.mathecao.loaima.destroy', $sp->id_mathecao) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">

                    {{ $dsSanPham->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <span>Đang hiển thị {{ $dsSanPham->count() }} Sản phẩm, tổng cộng {{ $dsSanPham->total() }} Sản Phẩm</span>
                </div>

            </div>
        </div>
    </div>

    <style>
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

    <script>
        function filterBySupplier(supplierId) {
            let url = new URL(window.location.href);
            url.searchParams.set('supplier_id', supplierId);
            url.searchParams.set('page', 1);
            window.location.href = url;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        jQuery(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            const form = $(this);

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
                text: "Hành động này sẽ không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((res) => {
                if (!res.isConfirmed) return;

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire('Thành công', response.success, 'success')
                            .then(() => {
                                form.closest('tr').remove();
                            });
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            Swal.fire('Lỗi', 'Dữ liệu không tồn tại! Vui lòng tải lại trang.', 'error');
                        } else {
                            Swal.fire('Lỗi', 'Không thể xóa dữ liệu.', 'error');
                        }
                    }
                });
            });
        });
    </script>
</div>