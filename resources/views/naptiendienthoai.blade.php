
@include('partials.header')
    <div class="description mb-3">
        <div class="title">
            Nạp Tiền Điện Thoại
        </div>
    </div>
    <div class="row" id="form-expandCard_TopUp">
        <div class="col-md-6 ">
            <div class="form-m1 rounded-lg">
                <form action="#" method="POST">
                    <input type="hidden" name="_token" value="1wZdxcAkOIkW8OUkQh70hmaS8Qwtr5bcigO5rokS">
                    <div class="row row10">
                        <div class="col-5 col-sm-4">
                            <label for="" class="col-form-label font-weight-bold">
                                Sản phẩm
                            </label>
                        </div>
                        <div class="col-7 col-sm-8">
                            <select class="form-control select-recharge" id="nhamang" name="key"
                                data-id="form-recharge-0">
                                <option value="">Sản phẩm</option>
                                <option value="viettelttcham" selected>
                                    Viettel trả trước (Nạp chờ)
                                </option>
                                <option value="vietteltscham">
                                    Viettel trả sau (Nạp chờ)
                                </option>
                                <option value="viettelts">
                                    Viettel trả sau (Nạp ngay)
                                </option>
                                <option value="vietteltt">
                                    Viettel trả trước (Nạp ngay)
                                </option>
                                <option value="vinatt">
                                    Vinaphone (Nạp ngay)
                                </option>
                                <option value="vinacham">
                                    Vinaphone (Nạp chờ)
                                </option>
                                <option value="mobitt">
                                    Mobifone (Nạp ngay)
                                </option>
                                <option value="mobicham">
                                    Mobifone (Nạp chờ)
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row row10">
                        <div class="col-5 col-sm-4">
                            <label for="" class="col-form-label font-weight-bold">
                                Chọn gói mua
                            </label>
                        </div>
                        <div class="col-7 col-sm-8">
                            <select class="form-control recharge-price" id="price_185" name="item">
                                <option value="">--- Chọn gói mua---</option>
                                <option value="772" discount="7" price="20000">20,000 đ</option>
                                <option value="773" discount="7" price="50000">50,000 đ</option>
                                <option value="774" discount="7" price="100000">100,000 đ</option>
                                <option value="775" discount="7" price="200000">200,000 đ</option>
                                <option value="776" discount="7" price="500000">500,000 đ</option>
                            </select>
                        </div>
                    </div>
                    <div class="row row10">
                        <div class="col-5 col-sm-4">
                            <label for="" class="col-form-label font-weight-bold">
                                Số điện thoại
                            </label>
                        </div>
                        <div class="col-7 col-sm-8">
                            <input type="text" class="form-control" id="phone" required placeholder="Số điện thoại"
                                name="account[phone]">
                        </div>
                    </div>
                    <div class="row row10">
                        <div class="col-5 col-sm-4">
                            <label for="" class="col-form-label font-weight-bold">
                                Chiết khấu
                            </label>
                        </div>
                        <div class="col-7 col-sm-8">
                            <input type="text" class="form-control" id="chietkhau" placeholder="Chiết khấu" readonly>
                        </div>
                    </div>
                    <div class="row row10">
                        <div class="col-5 col-sm-4">
                            <label for="" class="col-form-label font-weight-bold">
                                Giá
                            </label>
                        </div>
                        <div class="col-7 col-sm-8">
                            <input type="text" class="form-control" id="price" readonly>
                        </div>
                    </div>
                    <div class="row row10">
                        <div class="col-5 col-sm-4">
                            <label for="" class="col-form-label font-weight-bold">
                                Cổng thanh toán
                            </label>
                        </div>
                        <div class="col-7 col-sm-8">
                            <select class="form-control" name="paygate_code" required>
                                <option value="Wallet_VND">SỐ DƯ </option>
                                <option value="Localbank_ACB">Ngân hàng ACB</option>
                            </select>
                        </div>
                    </div>
                    <div class="row row10">
                        <div class="col-sm-8 offset-sm-4 text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-upload"></i>
                                Thanh toán
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-module">
                    <thead>
                        <tr>
                            <th>Viettel trả trước (Nạp chờ)</th>
                            <th class="text-center">Chiết khấu</th>
                            <th class="text-center">Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20,000 đ</td>
                            <td class="text-center">
                                7%
                            </td>
                            <td class="text-center">
                                <span style="text-decoration:line-through; color: red">20,000</span>
                                <strong>18,600</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>50,000 đ</td>
                            <td class="text-center">
                                7%
                            </td>
                            <td class="text-center">
                                <span style="text-decoration:line-through; color: red">50,000</span>
                                <strong>46,500</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>100,000 đ</td>
                            <td class="text-center">
                                7%
                            </td>
                            <td class="text-center">
                                <span style="text-decoration:line-through; color: red">100,000</span>
                                <strong>93,000</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>200,000 đ</td>
                            <td class="text-center">
                                7%
                            </td>
                            <td class="text-center">
                                <span style="text-decoration:line-through; color: red">200,000</span>
                                <strong>186,000</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>500,000 đ</td>
                            <td class="text-center">
                                7%
                            </td>
                            <td class="text-center">
                                <span style="text-decoration:line-through; color: red">500,000</span>
                                <strong>465,000</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="border p-3 rounded-lg mb-4">
                <p><strong>Đơn xử lý chậm</strong></p>
            </div>
        </div>

        <!-- <script type=" text/javascript" src="https://doithe1s.vn/assets/default/plugins/jquery.min.js"></script>
        <script type="text/javascript"
            src="https://doithe1s.vn/assets/default/plugins/select2/js/select2.min.js"></script>
        <script>
            $('.select2').select2();
        </script> -->


    </div>

    <div class="description mb-3 mt-4">
        <div class="sub-title">
            Lịch sử nạp
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-module">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Loại dịch vụ</th>
                    <th>Số tiền nạp</th>
                    <th>Số lượng</th>
                    <th>Thanh toán</th>
                    <th>Tài khoản nhận</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Đã nạp</th>
                    <th class="text-center">Chiết khấu</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="mt-2">
        </div>
    </div>