    @include('admin.sidebar')

    <div class="main" style="margin-top: 10px; padding: 30px">
        <div class="container">
            <div class="row d-flex">

                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Đơn bán thẻ</h1>
                    <form method="GET" action="{{ route('admin.mathecao.donhang.index') }}">
                        <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">

                            <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto" value="{{ request('ma_don') }}">

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
                                <td>{{ $dh->so_luong * $dh->sanpham?->menh_gia ?? 'Chưa có mênhk giá' }}</td>

                                <td>{{$dh->thanhvien?->tai_khoan ?? 'Chưa có Tài Khoản'}}</td>
                                <td>{{$dh->thanhvien?->email ?? 'Chưa có email'}}</td>
                                <td>{{$dh->ngay_tao}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" style="font-size: 13px;">{{$dh->trang_thai}}</button>
                                </td>

                                <td>
                                    <a href="{{ route('admin.mathecao.donhang.edit', $dh->id_donbanthe)}}" class="btn btn-dark">Sửa</a>


                                    <form action="{{ route('admin.mathecao.donhang.destroy', $dh->id_donbanthe) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark">Xóa</button>
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
                <!-- <script src="https://cdn.tailwindcss.com"></script> -->
                <script>
                    // Xử lý sự kiện mở/tắt sidebar khi nhấn vào nút ☰
                    document.getElementById('menuToggle').addEventListener('click', function() {
                        document.getElementById('sidebar').classList.toggle('open');
                    });
                </script>

                </body>

                </html>