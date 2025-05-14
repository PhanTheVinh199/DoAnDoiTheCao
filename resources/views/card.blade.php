@include('partials.header')

@auth('thanhvien')
    <style>
        /* CSS của bạn vẫn giữ nguyên */
        #product-prices {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .price-item {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1 1 200px;
            text-align: center;
            min-width: 150px;
            cursor: pointer;
        }

        .price-item:hover {
            background-color: #e0e0e0;
        }

        .selected {
            border: 3px solid #007bff;
            box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.5);
        }

        .cart-item {
            margin-bottom: 10px;
        }

        .cart-item input {
            width: 50px;
            text-align: center;
        }

        .cart-summary {
            margin-top: 20px;
        }

        .btn-checkout {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-checkout:hover {
            background-color: #218838;
        }
    </style>
    <div class="container tabs-m1 mt-5">
        <ul class="nav nav-tabs justify-content-start mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" id="tab-1" href="#cate1">
                    Thẻ Bán Chạy
                </a>
            </li>
        </ul>
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="tab-content mb-5">
                    <div class="tab-pane fade active show" id="cate1">
                        <div class="row row10">
                            @foreach ($dsNhaCungCap as $nhaCungCap)
                            <div class="col-lg-3 col-4">
                                <a href="javascript:void(0)" class="card-product card" data-id="{{ $nhaCungCap->id_nhacungcap }}">
                                    <div class="card-image">
                                        <img src="{{ asset($nhaCungCap->hinhanh) }}" alt="{{ $nhaCungCap->ten }}" />
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $nhaCungCap->ten }}</p>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="description mb-3">
                    <div class="sub-title">Chọn mệnh giá thẻ</div>
                </div>
                <div id="product-prices">
                    <!-- hiển thị giá -->
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                <div class="overflow-hidden" id="shopping-cart-wrapper">
                    <div class="card card-cart overflow-hidden">
                        <div class="card-header py-2 px-3">
                            <div class="card-title mb-0 d-flex align-items-center justify-content-between">
                                Giỏ hàng
                                <span><i class="far fa-shopping-basket"></i></span>
                            </div>
                        </div>
                        <div class="card-body p-3 bg-white">
                            <div class="text-danger py-2 h6 text-center mb-0" id="cart-empty-message">
                                Giỏ hàng đang trống
                            </div>
                            <div id="cart-details" style="display:none;">
                                <p><strong>Nhà cung cấp:</strong> <span id="cart-provider-name"></span></p>
                                <p><strong>Mệnh giá:</strong> <span id="cart-price"></span></p>
                                <p><strong>Giá sau chiết khấu:</strong> <span id="cart-price-after-discount"></span></p>
                                <p><strong>Chiết khấu:</strong> <span id="cart-discount"></span>%</p>
                                <div class="cart-item">
                                    <label for="quantity">Số lượng: </label>
                                    <input type="number" id="quantity" value="1" min="1" />
                                </div>
                                <div class="cart-summary">
                                    <strong>Tổng cộng: <span id="cart-total"></span></strong>
                                </div>
                                <button class="btn-checkout" id="checkout-button">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <form action="{{ route('card') }}" method="GET">
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

                                
                                        <!-- Các nút tìm kiếm và lọc -->
                                        <div class="col-12 col-md flex-lg-grow-0 d-flex align-items-center px-0">
                                            <button class="btn btn-primary btn-small text-nowrap m-1 my-md-0" type="submit" name="submit" value="filter">
                                                <span class="fal fa-search me-1"></span>
                                                Lọc
                                            </button>

                                            <a href="{{ route('card') }}" class="btn btn-danger btn-small text-nowrap m-1 my-md-0">
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
                                        @foreach($dsDonHang as $dh)
                                        <tr>
                                            <th>{{$dh->ma_don}}</th>
                                            <th>{{ $dh->sanpham?->nhacungcap?->ten ?? 'Chưa có nhà cung cấp' }}</th>
                                            <th>{{ $dh->so_luong}}</th>
                                            <th>{{ $dh->sanpham?->menh_gia ?? 'Chưa có mệnh giá' }}</th>
                                            <th>{{ $dh->thanh_tien}}</th>
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
    </div>
@else
    <div class="container mt-5 mb-5">
        <div class="alert alert-warning text-center">
            <strong>Vui lòng đăng nhập để tiếp tục dịch vụ.</strong><br>
            <a href="{{ route('login') }}" class="btn btn-primary mt-3">Đăng nhập</a>
        </div>
    </div>
@endauth
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Tự động chọn nhà cung cấp có data-id="1" khi trang tải
        var nhaCungCapId = "1"; // Lấy data-id là 1

        // Mô phỏng click vào thẻ có data-id="1" và thêm lớp selected
        $('a[data-id="' + nhaCungCapId + '"]').addClass('selected').trigger('click');

        // Lắng nghe sự kiện click của các nhà cung cấp
        $('a[data-id]').on('click', function() {
            var nhaCungCapId = $(this).data('id');
            var providerName = $(this).find('.card-text').text(); // Lấy tên nhà cung cấp từ card-text

            // Xóa giỏ hàng cũ khi chọn nhà cung cấp mới
            $('#cart-empty-message').show();
            $('#cart-details').hide(); // Ẩn giỏ hàng

            // Gửi yêu cầu AJAX để lấy mệnh giá sản phẩm
            $.ajax({
                url: '/get-product-prices/' + nhaCungCapId,
                method: 'GET',
                success: function(response) {
                    console.log(response); // Kiểm tra phản hồi từ server

                    // Xóa nội dung cũ trước khi hiển thị mệnh giá mới
                    $('#product-prices').html('');

                    // Hiển thị mệnh giá sản phẩm vào phần #product-prices
                    $('#product-prices').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error); // Kiểm tra lỗi trong console
                    alert('Có lỗi xảy ra!');
                }
            });

            // Xóa lớp selected khỏi tất cả các thẻ
            $('a[data-id]').removeClass('selected');

            // Thêm lớp selected cho thẻ được click
            $(this).addClass('selected');
        });

        // Lắng nghe sự kiện click của mệnh giá
        $(document).on('click', '.price-item', function() {
            // Xóa lớp selected khỏi tất cả các mệnh giá
            $('.price-item').removeClass('selected');

            // Thêm lớp selected cho mệnh giá được click
            $(this).addClass('selected');

            // Lấy thông tin mệnh giá và nhà cung cấp
            var providerName = $('a.selected').find('.card-text').text(); // Lấy tên nhà cung cấp từ thẻ được chọn
            var price = parseFloat($(this).data('price')); // Lấy giá mệnh giá từ data-price
            var discount = parseFloat($(this).data('discount')); // Lấy chiết khấu từ data-discount
            var idMatheCao = $(this).data('id-mathecao'); // Lấy id_mathecao từ data-id-mathecao

            // Tính giá sau chiết khấu
            var priceAfterDiscount = price - (price * discount / 100); // Áp dụng chiết khấu

            // Cập nhật giỏ hàng
            $('#cart-empty-message').hide();
            $('#cart-details').show();
            $('#cart-provider-name').text(providerName);
            $('#cart-price').text(price.toFixed(0)); // Hiển thị mệnh giá
            $('#cart-price-after-discount').text(priceAfterDiscount.toFixed(0)); // Hiển thị giá sau chiết khấu
            $('#cart-discount').text(discount); // Hiển thị chiết khấu
            $('#cart-total').text(priceAfterDiscount.toFixed(0)); // Hiển thị tổng cộng

            // Cập nhật số lượng
            $('#quantity').on('input', function() {
                var quantity = $(this).val();
                var total = priceAfterDiscount * quantity;
                $('#cart-total').text(total.toFixed(0)); // Cập nhật tổng cộng
            });

            $('#checkout-button').on('click', function() {
                // Lấy thông tin cần thiết
                var providerName = $('a.selected').find('.card-text').text(); // Tên nhà cung cấp
                var price = parseFloat($('.price-item.selected').data('price')); // Mệnh giá
                var discount = parseFloat($('.price-item.selected').data('discount')); // Chiết khấu
                var quantity = $('#quantity').val(); // Số lượng
                var nhaCungCapId = $('a.selected').data('id'); // Lấy id nhà cung cấp từ thẻ đã chọn

                // Tính giá sau chiết khấu
                var priceAfterDiscount = price - (price * discount / 100);

                // Tạo URL với các tham số cần thiết, bao gồm id_mathecao
                var url = "{{ route('pay') }}?provider=" + encodeURIComponent(providerName) +
                    "&price=" + price +
                    "&discount=" + discount +
                    "&quantity=" + quantity +
                    "&priceAfterDiscount=" + priceAfterDiscount +
                    "&nhaCungCapId=" + nhaCungCapId +
                    "&idMatheCao=" + idMatheCao; // Thêm id_mathecao vào URL

                // Điều hướng đến trang thanh toán với các tham số
                window.location.href = url;
            });
        });
    });
</script>
@include('partials.footer')