@include('partials.header')

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Xác nhận thanh toán</h4>
                </div>
                <div class="card-body">

                    <!-- Thêm dòng thông báo trước khi thanh toán -->
                    <div class="alert alert-info mb-4">
                        <strong>Chú ý:</strong> Bạn sắp thực hiện thanh toán. Hãy kiểm tra thông tin thanh toán trước khi xác nhận.
                    </div>

                    <!-- Hiển thị thông tin tài khoản và số dư -->
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th>Tên tài khoản</th>
                            <td>{{ Auth::user()->tai_khoan }}</td>
                        </tr>
                        <tr>
                            <th>Số dư hiện tại</th>
                            <td>{{ number_format(Auth::user()->so_du) }} VNĐ</td>
                        </tr>
                        <tr>
                            <th>Số dư sau giao dịch</th>
                            <td>
                                @php
                                    $totalAmount = request('priceAfterDiscount') * request('quantity');
                                    $remainingBalance = Auth::user()->so_du - $totalAmount;
                                @endphp
                                {{ number_format($remainingBalance) }} VNĐ
                            </td>
                        </tr>
                    </table>

                    <!-- Thông tin thanh toán -->
                    <p><strong>Nhà cung cấp:</strong> {{ request('provider') }}</p>
                    <p><strong>Mệnh giá:</strong> {{ number_format(request('price')) }} VNĐ</p>
                    <p><strong>Chiết khấu:</strong> {{ request('discount') }}%</p>
                    <p><strong>Số lượng:</strong> {{ request('quantity') }}</p>
                    <p><strong>Giá sau chiết khấu:</strong> {{ number_format(request('priceAfterDiscount')) }} VNĐ</p>
                    <p><strong>Tổng cộng:</strong> {{ number_format(request('priceAfterDiscount') * request('quantity')) }} VNĐ</p>

                    <hr>

                    <!-- Kiểm tra số dư sau giao dịch và hiển thị thông báo nếu số dư không đủ -->
                    @if($remainingBalance < 0)
                        <div class="alert alert-danger mb-4">
                            <strong>Lỗi:</strong> Số dư không đủ để thực hiện giao dịch. Vui lòng nạp thêm tiền vào tài khoản của bạn.
                        </div>
                        <!-- Khóa nút thanh toán -->
                        <button class="btn btn-success mt-3" disabled>Xác nhận thanh toán</button>
                        <a href="/card" class="btn btn-secondary mt-3">Quay lại</a>
                    @else
                        <form action="{{ route('process.payment') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email nhận mã thẻ:</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required placeholder="example@gmail.com">
                            </div>

                            {{-- Ẩn các dữ liệu cần thiết để gửi sang server --}}
                            <input type="hidden" name="provider" value="{{ request('provider') }}">
                            <input type="hidden" name="price" value="{{ request('price') }}">
                            <input type="hidden" name="discount" value="{{ request('discount') }}">
                            <input type="hidden" name="quantity" value="{{ request('quantity') }}">
                            <input type="hidden" name="priceAfterDiscount" value="{{ request('priceAfterDiscount') }}">

                            <button type="submit" class="btn btn-success mt-3">Xác nhận thanh toán</button>
                            <a href="/card" class="btn btn-secondary mt-3">Quay lại</a>
                        </form>
                    @endif

                    <!-- Dòng thông báo sau khi thanh toán -->
                    @if(session('payment_success'))
                        <div class="alert alert-success mt-4">
                            <strong>Thành công!</strong> Thanh toán của bạn đã được xác nhận. Số dư còn lại: 
                            {{ number_format(Auth::user()->so_du - (request('priceAfterDiscount') * request('quantity'))) }} VNĐ.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
