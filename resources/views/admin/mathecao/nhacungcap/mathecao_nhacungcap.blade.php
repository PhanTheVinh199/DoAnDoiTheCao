@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">

            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Nhà Cung Cấp</h1>
                <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 1000px;">

                    <!-- <input type="text" placeholder="Sản Phẩm" class="form-control w-auto"> -->
                    <a href="{{ route('admin.mathecao.nhacungcap.create') }}" class="btn btn-primary">Thêm Nhà Cung Cấp</a>

                    <!-- <button class="btn btn-danger">Bỏ lọc</button> -->
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
                        @foreach($dsNhaCungCap as $ncc)
                        <tr>
                            <td>{{ $ncc->id_nhacungcap }}</td>
                            <td>{{ $ncc->ten }}</td>
                            <td>
                                <div style="position: relative; width: 200px; height: 100px;">
                                    <img src="{{ asset($ncc->hinhanh) }}" alt="img-the" style="position: absolute; width: 100%; height: 100%;">
                                </div>
                            </td>


                            <td>{{ $ncc->ngay_tao }}</td>
                            <td>
                                @if($ncc->trang_thai == 'an')
                                <button type="button" class="btn btn-warning">Ẩn</button>
                                @elseif($ncc->trang_thai == 'hoat_dong')
                                <button type="button" class="btn btn-success">Hoạt động</button>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.mathecao.nhacungcap.edit', $ncc->id_nhacungcap) }}" class="btn btn-dark">Sửa</a>
                                <form action="{{ route('admin.mathecao.nhacungcap.destroy', $ncc->id_nhacungcap) }}"
                                    method="POST"
                                    class="delete-form"
                                    style="display:inline;">
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
                    {{ $dsNhaCungCap->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <span>Đang hiển thị {{ $dsNhaCungCap->count() }} Nhà Cung Cấp, tổng cộng {{ $dsNhaCungCap->total() }} Nhà Cung Cấp</span>
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
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                jQuery(document).on('submit', '.delete-form', function(e) {
                    e.preventDefault();
                    const form = $(this);

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa nhà cung cấp này?',
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



            </body>

            </html>