@include('partials.header')
<div class="section-gap ">
    <div class="container">
        <div class="description mb-3">
            <div class="title">
                Lịch sử đổi thẻ
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Form tìm kiếm mã đơn -->
                <form action="{{ route('lichsudoithe') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm mã đơn"
                            value="{{ request()->input('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fal fa-search"></i>
                            Tìm kiếm
                        </button>
                    </div>
                </form>

                <!-- Bảng lịch sử -->
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Mã Đơn</th>
                                    <th class="text-nowrap text-center">Mã Thẻ</th>
                                    <th class="text-nowrap text-center">Serial</th>
                                    <th class="text-nowrap text-center">Mạng</th>
                                    <th class="text-nowrap text-center">Mệnh Giá</th>
                                    <th class="text-nowrap text-center">Phí</th>
                                    <th class="text-nowrap text-center">Nhận</th>
                                    <th class="text-nowrap text-center">Ngày Tháng</th>
                                    <th class="text-nowrap text-center">Trạng Thái</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($lichsu as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->ma_don }}</td>
                                        <td class="text-center">{{ $order->ma_the }}</td>
                                        <td class="text-center">{{ $order->serial }}</td>
                                        <td class="text-center">
                                            {{ $order->doithecao && $order->doithecao->nhacungcap ? $order->doithecao->nhacungcap->ten : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $order->doithecao ? ($order->doithecao->menh_gia ? number_format($order->doithecao->menh_gia, 0, ',', '.') : 'N/A') : 'N/A' }}
                                            VND
                                        </td>
                                        <td class="text-center">
                                            {{ $order->doithecao ? number_format($order->doithecao->chiet_khau, 0, ',', '.') : 'N/A' }}%
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($order->thanh_tien, 0, ',', '.') }} VND
                                        </td>
                                        <td class="text-center">{{ $order->ngay_tao }}</td>
                                        <td class="text-center">
                                            @if ($order->trang_thai == 'cho_xu_ly')
                                                <button type="button" class="btn btn-warning">Chờ phê duyệt</button>
                                            @elseif($order->trang_thai == 'da_huy')
                                                <button type="button" class="btn btn-danger">Lỗi</button>
                                            @elseif($order->trang_thai == 'hoat_dong')
                                                <button type="button" class="btn btn-success">Thành Công</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($lichsu->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
</div>
                        <div class="d-flex justify-content-end pt-5">
                    {{ $lichsu->links('pagination::bootstrap-4') }}
                </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</body>
</html>
