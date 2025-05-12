@include('partials.header')

<div class="container">
    <div class="section-gap">
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <div class="description mb-3">
                    <div class="title text-uppercase">
                        Rút tiền
                    </div>
                </div>
                <div class="form-m1">
                    <form action="{{ route('rut-tien') }}" method="POST">
                        @csrf
                        <div class="row row10 rowmb5">
                            <div class="col-12">
                                <input name="wallet" type="hidden" value="0078591869">
                            </div>
                        </div>
                        <div class="row row10 rowmb5">
                            <label for="amount" class="col-form-label col-sm-4 font-weight-bold">
                                Số tiền rút:
                            </label>
                            <div class="col-sm-8">
                                <input name="amount" type="number" class="form-control" id="amount" placeholder="Số tiền" value="" min="10000" max="5000000" >
                                <span class="text-danger text-small">Tối thiểu 10,000 VND , Tối đa 5,000,000 VND</span>
                            </div>
                        </div>
                        <div class="row row10 rowmb5 align-items-center">
                            <label for="bankinfo_id" class="col-form-label col-sm-4 font-weight-bold">
                                Chọn ngân hàng<br>
                                (<a href="{{ route('add_nganhang_user') }}" class="text-danger font-weight-bold">Thêm ngân hàng</a>)
                            </label>
                            <div class="col-sm-8">
                                <select id="paymentlist" name="bankinfo_id" class="form-control" >
                                    <option value="" selected="selected">Chọn ngân hàng</option>
                                    @foreach(auth()->user()->nganHang as $bank)
                                        <option value="{{ $bank->id_danhsach }}">
                                            {{ $bank->ten_ngan_hang }} - {{ $bank->chu_tai_khoan }} - {{ $bank->so_tai_khoan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row row10">
                            <div class="col-sm-8 offset-sm-4 text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-dollar-sign"></i>
                                    Rút tiền ngay
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-7 mt-4 mt-lg-0">
                <div class="description mb-1">
                    <div class="small-title text-uppercase">
                        Hạn mức và phí:
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-module">
                        <tr>
                            <td style="width: 50%">Tổng hạn mức ngày</td>
                            <th>5,000,000</th>
                        </tr>
                        <tr>
                            <td>Số tiền tối thiểu</td>
                            <th>10,000</th>
                        </tr>
                        <tr>
                            <td>Số tiền tối đa</td>
                            <th>5,000,000</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="description mb-3">
            <div class="sub-title">
                Lịch sử rút tiền
            </div>
        </div>
        <div class="form-m1">
            <form action="#" name="formSearch" method="GET">
                <div class="row row5 rowmb3">
                    <div class="col-lg col-md-3 col-6">
                        <div class="form-theme_item">
                            <div class="form-theme_item--input">
                                <input class="form-control" value="" name="order_code" placeholder="Mã đơn">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-6">
                        <div class="form-theme_item">
                            <div class="form-theme_item--input">
                                <select name="paygate_code" class="form-control">
                                    <option value="" selected="selected">Chọn ngân hàng</option>
                                    <option value="Localbank_VIETCOMBANK">Ngân hàng Vietcombank</option>
                                    <option value="Localbank_BIDV">Ngân hàng BIDV</option>
                                    <!-- Các ngân hàng khác -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-6">
                        <div class="form-theme_item">
                            <div class="form-theme_item--input">
                                <select name="status" class="form-control">
                                    <option value="" selected="selected">Trạng thái</option>
                                    <option value="completed">Hoàn thành</option>
                                    <option value="pending">Chờ xử lý</option>
                                    <option value="canceled">Đã hủy</option>
                                    <option value="none">Chờ xác nhận ⬇️</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-6">
                        <div class="form-theme_item">
                            <div class="position-relative">
                                <input class="form-control" value="07-04-2025" name="from_date" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-6">
                        <div class="form-theme_item">
                            <div class="position-relative">
                                <input class="form-control" value="07-04-2025" name="to_date" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md flex-lg-grow-0 d-flex align-items-center px-0">
                        <button class="btn btn-primary btn-small text-nowrap m-1 my-md-0" type="submit" name="submit" value="filter">
                            <span class="fal fa-search me-1"></span>
                            Lọc
                        </button>
                        <button class="btn h-100 btn-success btn-small text-nowrap m-1 my-md-0" type="submit" name="submit" value="excel">
                            <i class="fas fa-file-excel me-0"></i>
                        </button>
                        <a href="#" class="btn btn-danger btn-small text-nowrap m-1 my-md-0">
                            <i class="fa fa-trash-alt me-1"></i> Bỏ lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-module">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        
                        <th>Ngân hàng</th>
                        <th>Số tài khoản</th>
                        <th>Tên tài khoản</th>
                        
                        <th class="text-center">Số tiền</th>
                        <th class="text-center">Trạng thái</th>
                        <th>Ngày tạo</th>
                        {{-- <th class="text-center">Thao tác</th> --}}
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dsRutTien as $item)
                        <tr>
                            {{-- <td>{{ $item->id_lichsurut }}</td> --}}
                            <td>{{ $item->ma_don }}</td>
                            {{-- <td>{{ $item->thanhvien->tai_khoan }}</td> --}}
                            <td>{{ $item->nganhang->ten_ngan_hang }}</td>
                            <td>{{ $item->nganhang->so_tai_khoan }}</td>
                            <td>{{ $item->nganhang->chu_tai_khoan }}</td>
                            <td>{{ number_format($item->so_tien_rut, 0, ',', '.') }} đ</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @if ($item->trang_thai == 'cho_duyet')
                                    <button type="button" class="btn btn-warning">Chờ Phê Duyệt</button>
                                @elseif($item->trang_thai == 'da_duyet')
                                    <button type="button" class="btn btn-success">Hoạt Động</button>
                                @elseif($item->trang_thai == 'huy')
                                    <button type="button" class="btn btn-danger">Hủy</button>
                                @endif
                            </td>
                            {{-- <td>
                                <a href="{{ route('admin.nganhang.ruttien.edit', $item->id_lichsurut) }}"
                                    class="btn btn-dark d-inline-block mr-2">Sửa</a>
                                <form action="{{ route('admin.nganhang.ruttien.delete', $item->id_lichsurut) }}"
                                    method="POST" class="d-inline-block"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark">Xóa</button>
                                </form>
                            </td> --}}
                        </tr>
                    @empty
                        <!-- Nếu không có dữ liệu, hiển thị thông báo -->
                        <tr>
                            <td colspan="10" class="text-center">Không có dữ liệu </td>
                        </tr>
                    @endforelse
                </tbody>


            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- SweetAlert2 Script -->
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session('success') }}',
            showConfirmButton: true,  // Hiển thị nút OK
            confirmButtonText: 'OK', // Thêm chữ 'OK' vào nút
            confirmButtonColor: '#3085d6', // Màu sắc của nút OK (tuỳ chọn)
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session('error') }}',
            showConfirmButton: true,  // Hiển thị nút OK
            confirmButtonText: 'OK', // Thêm chữ 'OK' vào nút
            confirmButtonColor: '#d33', // Màu sắc của nút OK (tuỳ chọn)
        });
    </script>
@endif


</body>
</html>
