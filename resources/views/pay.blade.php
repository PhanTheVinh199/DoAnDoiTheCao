@include('partials.header')

@auth('thanhvien')
@php
$mathecaoId = request('idMatheCao');
$quantity = (int) request('quantity');
$priceAfterDiscount = (int) request('priceAfterDiscount');

$sanPham = \DB::table('mathecao_danhsach')->where('id_mathecao', $mathecaoId)->first();

if (!$sanPham || $quantity <= 0 || $priceAfterDiscount <=0) {
    header('Location: ' . route(' card'));
    exit;
    }

    $provider=request('provider');
    $price=(int) request('price');
    $discount=(float) request('discount');
    $nhaCungCapId=(int) request('nhaCungCapId');
    @endphp

    <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Xác nhận thanh toán</h4>
                </div>
                <div class="card-body">

                    <div class="alert alert-info mb-4">
                        <strong>Chú ý:</strong> Bạn sắp thực hiện thanh toán. Hãy kiểm tra thông tin thanh toán trước khi xác nhận.
                    </div>

                    <table class="table table-bordered mb-4">
                        <tr>
                            <th>Tên tài khoản</th>
                            <td>{{ Auth::guard('thanhvien')->user()->tai_khoan }}</td>
                        </tr>
                        <tr>
                            <th>Số dư hiện tại</th>
                            <td>{{ number_format(Auth::guard('thanhvien')->user()->so_du) }} VNĐ</td>
                        </tr>
                        <tr>
                            <th>Số dư sau giao dịch</th>
                            <td>
                                @php
                                $totalAmount = $priceAfterDiscount * $quantity;
                                $remainingBalance = Auth::guard('thanhvien')->user()->so_du - $totalAmount;
                                @endphp
                                {{ number_format($remainingBalance) }} VNĐ
                            </td>
                        </tr>
                    </table>

                    <!-- Thông tin thanh toán -->
                    <p><strong>Nhà cung cấp:</strong> {{ $provider }}</p>
                    <p><strong>Mệnh giá:</strong> {{ number_format($price) }} VNĐ</p>
                    <p><strong>Chiết khấu:</strong> {{ $discount }}%</p>
                    <p><strong>Số lượng:</strong> {{ $quantity }}</p>
                    <p><strong>Giá sau chiết khấu:</strong> {{ number_format($priceAfterDiscount) }} VNĐ</p>
                    <p><strong>Tổng cộng:</strong> {{ number_format($totalAmount) }} VNĐ</p>
                    <hr>

                    @if($remainingBalance < 0)
                        <div class="alert alert-danger mb-4">
                        <strong>Lỗi:</strong> Số dư không đủ để thực hiện giao dịch. Vui lòng nạp thêm tiền vào tài khoản của bạn.
                        <a href="{{ route('naptien.form') }}">Nạp Tiền Ngay !!</a>
                </div>
                <button class="btn btn-success mt-3" disabled>Xác nhận thanh toán</button>
                <a href="{{ route('card') }}" class="btn btn-secondary mt-3">Quay lại</a>
                @else
                <form action="{{ route('process.payment') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email nhận mã thẻ:</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::guard('thanhvien')->user()->email }}" required placeholder="example@gmail.com">
                    </div>

                    {{-- Ẩn các dữ liệu cần thiết --}}
                    <input type="hidden" name="id_nhacungcap" value="{{ $nhaCungCapId }}">
                    <input type="hidden" name="price" value="{{ $price }}">
                    <input type="hidden" name="discount" value="{{ $discount }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                    <input type="hidden" name="priceAfterDiscount" value="{{ $priceAfterDiscount }}">
                    <input type="hidden" name="mathecao_id" value="{{ $mathecaoId }}">

                    <button type="submit" class="btn btn-success mt-3">Xác nhận thanh toán</button>
                    <a href="{{ route('card') }}" class="btn btn-secondary mt-3">Quay lại</a>
                </form>
                @endif

            </div>
        </div>
    </div>
    </div>
    </div>

    @else
    <div class="container mt-5 mb-5">
        <div class="alert alert-warning text-center">
            <strong>Vui lòng đăng nhập để tiếp tục thanh toán.</strong><br>
            <a href="{{ route('login') }}" class="btn btn-primary mt-3">Đăng nhập</a>
        </div>
    </div>
    @endauth

    @include('partials.footer')