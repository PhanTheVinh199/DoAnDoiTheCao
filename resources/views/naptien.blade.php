@include('partials.header')


<style>
    .form-m1 input,
    .form-m1 select {
        font-size: 1.15rem;
        padding: 0.75rem 1rem;
    }

    .btn-lg {
        font-size: 1.25rem;
        padding: 0.8rem;
    }

    .table-lg td,
    .table-lg th {
        padding: 1rem 1.25rem;
        font-size: 1.05rem;
    }

    .description .title,
    .description .small-title,
    .description .sub-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .table th {
        background-color: #f8f9fa;
    }

    .alert {
        margin-top: 20px;
    }
</style>
<div class="container">
    <div class="section-gap">
        <div class="row g-4 mb-5">
            <!-- Tạo yêu cầu nạp quỹ -->
            <div class="col-lg-7">
                <div class="description mb-3">
                    <div class="title">Tạo yêu cầu nạp quỹ</div>
                </div>
                <div class="form-m1">
                    <form action="{{ route('naptien.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="col-form-label">
                                Số dư quỹ: <b class="font-weight-bold text-success">{{ number_format(Auth::guard('thanhvien')->user()->so_du) }} VND</b>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="col-form-label fw-bold">Số tiền nạp:</label>
                            <input name="net_amount" type="number" class="form-control fnum" placeholder="Số tiền nạp"
                                value="{{ old('net_amount') }}" required min="{{ $soTienToiThieu }}" max="{{ $soTienToiDa }}">
                            <small class="text-danger">Tối thiểu {{ number_format($soTienToiThieu) }} VND , Tối đa {{ number_format($soTienToiDa) }} VND</small>
                        </div>

                        <div class="mb-4">
    <label class="col-form-label fw-bold">Cổng thanh toán:</label>
    <select class="form-control" name="paygate_code" required>
        @forelse($banks as $bank)
            <option value="{{ $bank->id }}">
                {{ $bank->ten_ngan_hang }} - {{ $bank->so_tai_khoan }} ({{ $bank->chu_tai_khoan }})
            </option>
        @empty
            <option value="">Bạn chưa thêm ngân hàng nào</option>
        @endforelse
    </select>
</div>

                        <div class="text-end">
                            <input type="hidden" name="hanMucNgay" value="{{ $hanMucNgay }}">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-dollar-sign"></i> Nạp tiền ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hạn mức và phí -->
            <div class="col-lg-5">
                <div class="description mb-3">
                    <div class="small-title">Hạn mức và phí:</div>
                </div>
                @if(isset($hanMucNgay) && $hanMucNgay > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-module table-lg">
                        <tr>
                            <td>Tổng hạn mức ngày</td>
                            <th>{{ number_format($hanMucNgay) }} VND</th>
                        </tr>
                        <tr>
                            <td>Số tiền tối thiểu</td>
                            <th>{{ number_format($soTienToiThieu) }} VND</th>
                        </tr>
                        <tr>
                            <td>Số tiền tối đa</td>
                            <th>{{ number_format($soTienToiDa) }} VND</th>
                        </tr>
                    </table>
                </div>
                @endif

                <div class="mt-4">
                    <table class="table table-bordered table-striped table-module table-lg">
                        <thead>
                            <tr>
                                <th>Cổng thanh toán</th>
                                <th class="text-center">Phí cố định</th>
                                <th class="text-center">Phí %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banks as $bank)
                            <tr>
                                <td>{{ $bank->ten_ngan_hang }}</td>
                                <td class="text-center">0</td> <!-- Giả sử phí cố định là 0 -->
                                <td class="text-center">{{ $bank->phi }}%</td> <!-- Đổi 'phí %' thành 'phi' -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Lịch sử nạp tiền -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="description mb-3">
                    <div class="sub-title"><i class="fas fa-history"></i> Lịch sử nạp tiền</div>
                </div>

                <!-- Thông báo lỗi hoặc thành công -->
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-module table-lg">
                        <thead>
                            <tr>
                                <th><i class="fas fa-file-invoice"></i> Mã đơn</th>
                                <th class="text-center"><i class="fas fa-piggy-bank"></i> Nạp vào quỹ</th>
                                <th class="text-center"><i class="fas fa-money-bill-wave"></i> Số tiền</th>
                                <th><i class="fas fa-university"></i> Cổng thanh toán</th>
                                <th><i class="fas fa-calendar-alt"></i> Ngày tạo</th>
                                <th class="text-center"><i class="fas fa-info-circle"></i> Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->ma_don ?? 'N/A' }}</td>
                                <td class="text-center">{{ number_format($transaction->so_tien_nap, 2) }} VND</td>
                                <td class="text-center">{{ number_format($transaction->so_tien_nap) }}</td>
                                <td>{{ $transaction->noi_dung }}</td>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">{{ $transaction->trang_thai }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không có giao dịch nạp tiền nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>