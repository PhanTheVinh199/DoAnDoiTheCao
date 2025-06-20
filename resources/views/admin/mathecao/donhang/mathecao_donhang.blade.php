    @include('admin.sidebar')

    <div class="main" style="margin-top: 10px; padding: 30px">
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
        @if(request()->filled('ma_don') && $dsDonHang->isEmpty())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Không tìm thấy',
                text: "Không tìm thấy đơn hàng nào phù hợp với từ khóa '{{ request('ma_don') }}'",
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('admin.mathecao.donhang.index') }}";
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
                    <h1 class="h2 mb-4">Đơn bán thẻ</h1>
                    <form method="GET" action="{{ route('admin.mathecao.donhang.index') }}">
                        <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">

                            <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto" value="{{ request('ma_don') }}" maxlength="100">

                            <button class="btn btn-primary">Tìm kiếm</button>
                            <!-- <button class="btn btn-danger">Bỏ lọc</button> -->
                        </div>
                    </form>
                    <div class="d-flex gap-4 mb-4" style="margin-left: 500px;">

                    </div>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Mã Đơn </th>
                                <th>Sản Phẩm</th>
                                <!-- <th>Mã Thẻ</th>
                                    <th>Seri</th> -->
                                <th>Mệnh giá</th>

                                <th>Số lượng</th>
                                <th>Chiếc khấu</th>
                                <th>Thành tiền</th>
                                <th>Khách Hàng</th>
                                <th>Email nhận Thẻ</th>
                                <th>Ngày tạo</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dsDonHang as $dh)
                            <tr>
                                <td>{{$dh->id_donbanthe}}</td>
                                <td>{{$dh->ma_don}}</td>
                                <td>{{ $dh->sanpham?->nhacungcap?->ten ?? 'Chưa có nhà cung cấp' }}</td>
                                <!-- <td>72238866089289</td>
                                    <td>59850007774848</td> -->
                                <td>{{$dh->sanpham?->menh_gia ?? 'Chưa có mệnh giá' }}</td>

                                <td>{{$dh->so_luong}}</td>
                                <td>{{$dh->sanpham?->chiet_khau ?? 'Chưa có Chiết Khấu' }}%</td>
                                <td>{{ $dh->thanh_tien}}</td>

                                <td>{{$dh->thanhvien?->tai_khoan ?? 'Chưa có Tài Khoản'}}</td>
                                <td>{{$dh->thanhvien?->email ?? 'Chưa có email'}}</td>
                                <td>{{$dh->ngay_tao}}</td>
                                <td>
                                    @if($dh->trang_thai == 'cho_xu_ly')
                                    <button type="button" class="btn btn-warning" style="font-size: 13px;">Chờ xử lý</button>
                                    @elseif($dh->trang_thai == 'hoat_dong')
                                    <button type="button" class="btn btn-success" style="font-size: 13px;">Hoạt động</button>
                                    @elseif($dh->trang_thai == 'da_huy')
                                    <button type="button" class="btn btn-danger" style="font-size: 13px;">Đã hủy</button>
                                    @endif

                                </td>

                                <td>
                                    <a href="{{ route('admin.mathecao.donhang.edit', $dh->id_donbanthe)}}" class="btn btn-dark">Sửa</a>


                                    <form action="{{ route('admin.mathecao.donhang.destroy', $dh->id_donbanthe) }}" method="POST" class="delete-form">
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
                        {{ $dsDonHang->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <span>Đang hiển thị {{ $dsDonHang->count() }} đơn hàng, tổng cộng {{ $dsDonHang->total() }} đơn</span>
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






                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    jQuery(document).on('submit', '.delete-form', function(e) {
                        e.preventDefault();
                        const form = $(this);

                        Swal.fire({
                            title: 'Bạn có chắc chắn muốn xóa đơn hàng này?',
                            text: "Hành động này sẽ không thể hoàn tác!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Đồng ý',
                            cancelButtonText: 'Hủy'
                        }).then(res => {
                            if (!res.isConfirmed) return;

                            $.ajax({
                                url: form.attr('action'),
                                method: 'POST',
                                data: form.serialize(),
                                success: function(resp) {
                                    Swal.fire('Thành công', resp.success, 'success')
                                        .then(() => {
                                            form.closest('tr').remove();
                                        });
                                },
                                error: function(xhr) {
                                    if (xhr.status === 404) {
                                        Swal.fire('Lỗi', 'Đơn hàng không tồn tại! Vui lòng tải lại trang.', 'error');
                                    } else {
                                        Swal.fire('Lỗi', 'Xóa không thành công.', 'error');
                                    }
                                }
                            });
                        });
                    });
                </script>

                </body>

                </html>