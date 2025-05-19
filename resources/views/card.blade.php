@include('partials.header')

@auth('thanhvien')
<style>
    /* CSS của bạn vẫn giữ nguyên */
    #product-prices {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        perspective: 1000px; /* tạo không gian 3D cho con bên trong */
    }

    .price-item {
        background-color: #f9f9f9;
        padding: 18px 25px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1 1 200px;
        text-align: center;
        min-width: 160px;
        cursor: pointer;
        transition:
            transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
            box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1),
            background-color 0.3s ease;
        transform-style: preserve-3d;
    }

    .price-item:hover {
        background-color: #e6f0ff;
        box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
        transform: translateZ(15px) scale(1.05) rotateX(3deg) rotateY(3deg);
    }

    .selected {
        border: 3px solid #007bff;
        box-shadow: 0 0 20px rgba(0, 123, 255, 0.7);
        background-color: #d0e4ff;
        transform: translateZ(20px) scale(1.07);
    }

    .cart-item {
        margin-bottom: 15px;
    }

    .cart-item input {
        width: 60px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 5px;
        transition: border-color 0.3s ease;
    }

    .cart-item input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    .cart-summary {
        margin-top: 30px;
        font-weight: 600;
        font-size: 1.15rem;
        color: #333;
    }

    .btn-checkout {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px 30px;
        cursor: pointer;
        margin-top: 25px;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.5);
        transition:
            background-color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.3s ease;
    }

    .btn-checkout:hover {
        background-color: #218838;
        box-shadow: 0 10px 20px rgba(33, 136, 56, 0.7);
        transform: translateY(-3px);
    }

    .card-3d {
        display: block;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        transform-style: preserve-3d;
        perspective: 1000px;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .card-3d:hover {
        transform: rotateY(15deg) rotateX(10deg) translateZ(10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .card-3d .card-image img {
        display: block;
        width: 100%;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        transition: transform 0.4s ease;
    }

    .card-3d:hover .card-image img {
        transform: scale(1.05);
    }

    .card-3d .card-body {
        padding: 15px;
        text-align: center;
    }

    .card-3d .card-text {
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
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
                            <a href="javascript:void(0)" class="card-product card-3d" data-id="{{ $nhaCungCap->id_nhacungcap }}">
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
        // Lấy nhà cung cấp đầu tiên trong danh sách
        var $firstProvider = $('a[data-id]').first();

        if ($firstProvider.length) {
            // Thêm class selected cho nhà cung cấp đầu tiên
            $firstProvider.addClass('selected');

            // Lấy id và tên nhà cung cấp đầu tiên
            var nhaCungCapId = $firstProvider.data('id');
            var providerName = $firstProvider.find('.card-text').text();

            // Gọi AJAX lấy mệnh giá sản phẩm nhà cung cấp đầu tiên
            $.ajax({
                url: '/get-product-prices/' + nhaCungCapId,
                method: 'GET',
                success: function(response) {
                    // Hiển thị mệnh giá sản phẩm
                    $('#product-prices').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                    alert('Có lỗi xảy ra!');
                }
            });
        }

        // Xử lý khi click chọn nhà cung cấp
        $('a[data-id]').on('click', function() {
            var nhaCungCapId = $(this).data('id');
            var providerName = $(this).find('.card-text').text();

            // Xóa giỏ hàng cũ
            $('#cart-empty-message').show();
            $('#cart-details').hide();

            // Gọi AJAX lấy mệnh giá sản phẩm nhà cung cấp được chọn
            $.ajax({
                url: '/get-product-prices/' + nhaCungCapId,
                method: 'GET',
                success: function(response) {
                    $('#product-prices').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                    alert('Có lỗi xảy ra!');
                }
            });

            // Xóa class selected tất cả nhà cung cấp
            $('a[data-id]').removeClass('selected');

            // Thêm class selected cho nhà cung cấp được click
            $(this).addClass('selected');
        });

        // Xử lý chọn mệnh giá
        $(document).on('click', '.price-item', function() {
            $('.price-item').removeClass('selected');
            $(this).addClass('selected');

            var providerName = $('a.selected').find('.card-text').text();
            var price = parseFloat($(this).data('price'));
            var discount = parseFloat($(this).data('discount'));
            var idMatheCao = $(this).data('id-mathecao');

            var priceAfterDiscount = price - (price * discount / 100);

            $('#cart-empty-message').hide();
            $('#cart-details').show();
            $('#cart-provider-name').text(providerName);
            $('#cart-price').text(price.toFixed(0));
            $('#cart-price-after-discount').text(priceAfterDiscount.toFixed(0));
            $('#cart-discount').text(discount);
            $('#cart-total').text(priceAfterDiscount.toFixed(0));

            $('#quantity').off('input').on('input', function() {
                var quantity = $(this).val();
                var total = priceAfterDiscount * quantity;
                $('#cart-total').text(total.toFixed(0));
            });

            $('#checkout-button').off('click').on('click', function() {
                var providerName = $('a.selected').find('.card-text').text();
                var price = parseFloat($('.price-item.selected').data('price'));
                var discount = parseFloat($('.price-item.selected').data('discount'));
                var quantity = $('#quantity').val();
                var nhaCungCapId = $('a.selected').data('id');

                var priceAfterDiscount = price - (price * discount / 100);

                var url = "{{ route('pay') }}?provider=" + encodeURIComponent(providerName) +
                    "&price=" + price +
                    "&discount=" + discount +
                    "&quantity=" + quantity +
                    "&priceAfterDiscount=" + priceAfterDiscount +
                    "&nhaCungCapId=" + nhaCungCapId +
                    "&idMatheCao=" + idMatheCao;

                window.location.href = url;
            });
        });
    });
</script>

@include('partials.footer')
