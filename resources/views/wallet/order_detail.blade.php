@include('partials.header')
<div class="container text-white">
    <div class="card bg-dark p-4">
        <h3 class="text-danger border-bottom pb-2">ĐƠN HÀNG #{{ $order->ma_don }}</h3>
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Mã đơn #:</strong> {{ $order->ma_don }}</p>
                <p><strong>Số tiền:</strong> {{ number_format($order->so_tien_nap, 2) }} VND</p>
                <p><strong>Trạng thái:</strong> 
                    @if($order->trang_thai == 'cho_duyet')
                        <span class="badge bg-warning text-dark">Chưa duyệt</span>
                    @elseif($order->trang_thai == 'da_duyet')
                        <span class="badge bg-success">Hoàn thành</span>
                    @else
                        <span class="badge bg-danger">Đã hủy</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <h4 class="text-danger border-bottom pb-2 mt-4">THÔNG TIN THANH TOÁN</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Ngân hàng:</strong> {{ $order->nganhang->ten_ngan_hang ?? 'Chưa có thông tin' }}</p>
                <p><strong>Số tài khoản:</strong> {{ $order->nganhang->so_tai_khoan ?? 'Chưa có thông tin' }}</p>
                <p><strong>Tên tài khoản:</strong> {{ $order->nganhang->chu_tai_khoan ?? 'Chưa có thông tin' }}</p>
                <p><strong>Số tiền:</strong> {{ number_format($order->so_tien_nap, 2) }} VND</p>
                <p><strong>Nội dung thanh toán:</strong> {{ $order->transfer_note ?? 'Chưa có thông tin' }}</p>
            </div>
            <div class="col-md-6 text-center">
                @if($order->qr_code_filename)
                    <img src="{{ asset('storage/qrcodes/' . $order->qr_code_filename) }}" alt="QR Code" class="img-fluid" style="max-width: 250px;">
                @else
                    <p>Không có mã QR.</p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            @if($order->trang_thai == 'da_duyet' && !$order->da_xac_nhan)
                <form action="{{ route('order.confirm', ['id' => $order->id_lichsunap]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Xác nhận đã nhận tiền</button>
                </form>
            @elseif($order->trang_thai == 'cho_duyet')
                <div class="alert alert-warning">
                    Vui lòng chờ admin duyệt giao dịch
                </div>
            @elseif($order->da_xac_nhan)
                <div class="alert alert-success">
                    Giao dịch đã được xác nhận
                </div>
            @endif
        </div>

        <!-- Nút Trở lại -->
        <div class="mt-3">
            <a href="{{ route('naptien.form') }}" class="btn btn-secondary">Trở lại</a>
        </div>
    </div>

    <div class="card bg-dark mt-4">
        <div class="card-body">
            <h4 class="text-danger border-bottom pb-2">TRẠNG THÁI GIAO DỊCH</h4>
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0"><strong>Trạng thái hiện tại:</strong></p>
                        <p class="mb-0">
                            @if($order->trang_thai == 'da_duyet')
                                <span class="badge bg-success">Đã duyệt - Số dư đã được cộng</span>
                            @elseif($order->trang_thai == 'cho_duyet')
                                <span class="badge bg-warning text-dark">Đang chờ duyệt</span>
                            @else
                                <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="mb-0"><strong>Số dư hiện tại:</strong></p>
                        <p class="mb-0 text-success">{{ number_format(Auth::guard('thanhvien')->user()->so_du) }} VND</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

