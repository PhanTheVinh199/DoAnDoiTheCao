@include('partials.header')
@auth('thanhvien')
<div class="section-gap">
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
    <div class="container">
        <div class="description mb-3">
            <div class="title">
                Lịch sử mua thẻ
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-filter mb-4">
                    <div class="form-m1">
                        <form action="{{ route('lichsumuathe') }}" method="GET">
                            <div class="row row5 rowmb3">
                                <!-- Mã đơn -->
                                <div class="col-lg col-md-3 col-6">
                                    <div class="form-theme_item">
                                        <div class="form-theme_item--input">
                                            <input class="form-control" value="{{ request('order_code') }}" name="order_code"
                                                placeholder="Mã đơn" maxlength="100">
                                        </div>
                                    </div>
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-lg col-md-3 col-6">
                                    <div class="form-theme_item">
                                        <div class="form-theme_item--input">
                                            <select name="status" class="form-control">
                                                <option value="" selected="selected">Trạng thái</option>
                                                <option value="hoat_dong" {{ request('status') == 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                                                <option value="da_huy" {{ request('status') == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                                                <option value="cho_xu_ly" {{ request('status') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Từ ngày -->
                                <div class="col-lg col-md-3 col-6">
                                    <div class="form-theme_item">
                                        <div class="position-relative">
                                            <input class="form-control" value="{{ request('from_date') }}" name="from_date"
                                                type="date">
                                            <div class="icon-ios"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Các nút tìm kiếm và lọc -->
                                <div class="col-12 col-md flex-lg-grow-0 d-flex align-items-center px-0">
                                    <button class="btn btn-primary btn-small text-nowrap m-1 my-md-0" type="submit" name="submit" value="filter">
                                        <span class="fal fa-search me-1"></span>
                                        Lọc
                                    </button>

                                    <a href="{{ route('lichsumuathe') }}" class="btn btn-danger btn-small text-nowrap m-1 my-md-0">
                                        <i class="fa fa-trash-alt me-1"></i>
                                        Bỏ lọc
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table id="table-rowspan" class="table table-bordered table-module-white">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Mệnh giá</th>
                                    <th>Tổng Tiền</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($dsDonHang->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-danger">
                                        Không tìm thấy đơn hàng với mã hoặc trạng thái đã chọn.
                                    </td>
                                </tr>
                                @else
                                @foreach($dsDonHang as $dh)
                                <tr>
                                    <th>{{$dh->ma_don}}</th>
                                    <th>{{ $dh->sanpham?->nhacungcap?->ten ?? 'Chưa có nhà cung cấp' }}</th>
                                    <th>{{ $dh->so_luong}}</th>
                                    <th>{{ $dh->sanpham?->menh_gia ?? 'Chưa có mệnh giá' }}</th>
                                    <th>{{ $dh->thanh_tien}}</th>
                                    <th>{{$dh->ngay_tao}}</th>
                                    <th>
                                        @if($dh->trang_thai == 'cho_xu_ly')
                                        <button type="button" class="btn btn-warning">Chờ xử lý</button>
                                        @elseif($dh->trang_thai == 'hoat_dong')
                                        <button type="button" class="btn btn-success">Hoạt động</button>
                                        @elseif($dh->trang_thai == 'da_huy')
                                        <button type="button" class="btn btn-danger">Đã hủy</button>
                                        @endif
                                    </th>
                                </tr>
                                @endforeach
                                @endif {{-- Thêm dòng này để đóng if --}}
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $dsDonHang->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <span>Đang hiển thị {{ $dsDonHang->count() }} đơn hàng, tổng cộng {{ $dsDonHang->total() }} đơn</span>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container mt-5 mb-5">
    <div class="alert alert-warning text-center">
        <strong>Vui lòng đăng nhập để tiếp tục dịch vụ.</strong><br>
        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Đăng nhập</a>
    </div>
</div>
@endauth
</body>

</html>
@include('partials.footer')