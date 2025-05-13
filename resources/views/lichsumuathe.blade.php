@include('partials.header')
@auth('thanhvien')
<div class="section-gap">
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
                                                placeholder="Mã đơn">
                                        </div>
                                    </div>
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-lg col-md-3 col-6">
                                    <div class="form-theme_item">
                                        <div class="form-theme_item--input">
                                            <select name="status" class="form-control">
                                                <option value="" selected="selected">Trạng thái</option>
                                                <option value="Hoạt động" {{ request('status') == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                                                <option value="Đã huỷ" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                                <option value="Chờ xử lý" {{ request('status') == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
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

                                <!-- Đến ngày -->
                                <div class="col-lg col-md-3 col-6">
                                    <div class="form-theme_item">
                                        <div class="position-relative">
                                            <input class="form-control" value="{{ request('to_date') }}" name="to_date"
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
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dsDonHang as $dh)
                                <tr>
                                    <th>{{$dh->ma_don}}</th>
                                    <th>{{ $dh->sanpham?->nhacungcap?->ten ?? 'Chưa có nhà cung cấp' }}</th>
                                    <th>{{ $dh->so_luong}}</th>
                                    <th>{{ $dh->so_luong * $dh->sanpham?->menh_gia ?? 'Chưa có mênhk giá' }}</th>
                                    <th>{{$dh->ngay_tao}}</th>
                                    <th>
                                        @if($dh->trang_thai == 'Chờ xử lý')
                                        <button type="button" class="btn btn-warning">Chờ xử lý</button>
                                        @elseif($dh->trang_thai == 'Hoạt động')
                                        <button type="button" class="btn btn-success">Hoạt động</button>
                                        @elseif($dh->trang_thai == 'Đã hủy')
                                        <button type="button" class="btn btn-danger">Đã hủy</button>
                                        @endif
                                    </th>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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