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
                    <form action="#" method="POST">
                        <input type="hidden" name="_token" value="1wZdxcAkOIkW8OUkQh70hmaS8Qwtr5bcigO5rokS">
                        <div class="row row10 rowmb5">
                            <div class="col-12">
                                <label for="" class="col-form-label">
                                    Số dư quỹ: <b class="font-weight-bold text-success">0 VND</b>
                                </label>
                                <input name="wallet" type="hidden" value="0078591869">
                            </div>
                        </div>
                        <div class="row row10 rowmb5">
                            <label for="" class="col-form-label col-sm-4 font-weight-bold">
                                Số tiền rút:
                            </label>
                            <div class="col-sm-8">
                                <input name="amount" type="text" class="form-control fnum" id="amount"
                                    placeholder="Số tiền" value="">
                                <span class="text-danger text-small">Tối thiểu 10,000 VND , Tối đa 5,000,000 VND</span>
                            </div>
                        </div>
                        <div class="row row10 rowmb5 align-items-center">
                            <label for="" class="col-form-label col-sm-4 font-weight-bold">
                                Chọn ngân hàng<br>
                                (
                                <a href="#" class="text-danger font-weight-bold">Thêm
                                    ngân hàng</a>
                                )
                            </label>
                            <div class="col-sm-8">
                                <select id="paymentlist" name="bankinfo_id" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="row row10">
                            <div class="col-sm-8 offset-sm-4 text-center text-center">
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

                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-module">
                            <tr>
                                <th style="width: 50%">Cổng thanh toán</th>
                                <th class="text-center">Phí cố định</th>
                                <th class="text-center">Phí %</th>
                                <th class="text-center">Mức rút không phí</th>
                            </tr>
                            <tr>
                                <td>Ngân hàng Vietcombank</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng BIDV</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng VIETINBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng AGRIBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng SACOMBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng DONGABANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng VPBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng TPBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng MBBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng EXIMBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng SEABANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng KIENLONGBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng TECHCOMBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng ABBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng SAIGONBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng VIETBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng MSB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng CIMB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng VAB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng VIB </td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng SCB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng số CAKE</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng IBK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng VRB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng NASB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng bản việt BVBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng bảo việt BVB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng lộc phát LPB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng PVCOMBANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng MBV</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng GPB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng NAMABANK</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng HDB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng OCB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng MHB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng NCB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng số TIMO</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ví Viettel Money</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                            <tr>
                                <td>Ngân hàng ACB</td>
                                <td class="text-center">1,000</td>
                                <td class="text-center">0
                                    %
                                </td>
                                <td class="text-center">
                                    500,000
                                </td>
                            </tr>
                        </table>
                    </div>
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
                                    <option value="Localbank_VIETINBANK">Ngân hàng VIETINBANK</option>
                                    <option value="Localbank_AGRIBANK">Ngân hàng AGRIBANK</option>
                                    <option value="Localbank_SACOMBANK">Ngân hàng SACOMBANK</option>
                                    <option value="Localbank_DONGABANK">Ngân hàng DONGABANK</option>
                                    <option value="Localbank_VPBANK">Ngân hàng VPBANK</option>
                                    <option value="Localbank_TPBANK">Ngân hàng TPBANK</option>
                                    <option value="Localbank_MB">Ngân hàng MBBANK</option>
                                    <option value="Localbank_EXIMBANK">Ngân hàng EXIMBANK</option>
                                    <option value="Localbank_SEABANK">Ngân hàng SEABANK</option>
                                    <option value="Localbank_KIENLONGBANK">Ngân hàng KIENLONGBANK</option>
                                    <option value="Localbank_TECHCOMBANK">Ngân hàng TECHCOMBANK</option>
                                    <option value="Localbank_ABBANK">Ngân hàng ABBANK</option>
                                    <option value="Localbank_SAIGONBANK">Ngân hàng SAIGONBANK</option>
                                    <option value="Localbank_VIETBANK">Ngân hàng VIETBANK</option>
                                    <option value="Localbank_MSB">Ngân hàng MSB</option>
                                    <option value="Localbank_CIMB">Ngân hàng CIMB</option>
                                    <option value="Localbank_VAB">Ngân hàng VAB</option>
                                    <option value="Localbank_VIB">Ngân hàng VIB </option>
                                    <option value="Localbank_SCB">Ngân hàng SCB</option>
                                    <option value="Localbank_CAKE">Ngân hàng số CAKE</option>
                                    <option value="Localbank_IBK">Ngân hàng IBK</option>
                                    <option value="Localbank_VRB">Ngân hàng VRB</option>
                                    <option value="Localbank_NASB">Ngân hàng NASB</option>
                                    <option value="Localbank_VIETCAPITAL">Ngân hàng bản việt BVBANK</option>
                                    <option value="Localbank_BVB">Ngân hàng bảo việt BVB</option>
                                    <option value="Localbank_LPB">Ngân hàng lộc phát LPB</option>
                                    <option value="Localbank_PVCOMBANK">Ngân hàng PVCOMBANK</option>
                                    <option value="Localbank_OCEANBANK">Ngân hàng MBV</option>
                                    <option value="Localbank_GPB">Ngân hàng GPB</option>
                                    <option value="Localbank_NAMABANK">Ngân hàng NAMABANK</option>
                                    <option value="Localbank_HDB">Ngân hàng HDB</option>
                                    <option value="Localbank_OCB">Ngân hàng OCB</option>
                                    <option value="Localbank_MHB">Ngân hàng MHB</option>
                                    <option value="Localbank_NCB">Ngân hàng NCB</option>
                                    <option value="Localbank_TIMO">Ngân hàng số TIMO</option>
                                    <option value="Localbank_VTM">Ví Viettel Money</option>
                                    <option value="Localbank_ACB">Ngân hàng ACB</option>

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
                                <div class="icon-ios"></div>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-6">
                        <div class="form-theme_item">
                            <div class="position-relative">
                                <input class="form-control" value="07-04-2025" name="to_date" type="date">
                                <div class="icon-ios"></div>
                            </div>


                        </div>
                    </div>
                    <div class="col-12 col-md flex-lg-grow-0 d-flex align-items-center px-0">
                        <button class="btn btn-primary btn-small text-nowrap m-1 my-md-0" type="submit" name="submit"
                            value="filter">
                            <span class="fal fa-search me-1"></span>
                            Lọc
                        </button>
                        <button class="btn h-100 btn-success btn-small text-nowrap m-1 my-md-0" type="submit"
                            name="submit" value="excel">
                            <i class="fas fa-file-excel me-0"></i>
                        </button>
                        <a href="#"
                            class="btn btn-danger btn-small text-nowrap m-1 my-md-0">
                            <i class="fa fa-trash-alt me-1"></i>
                            Bỏ lọc
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
                        <th class="text-center">Số tiền</th>
                        <th>Ngân hàng</th>
                        <th>Tên tài khoản</th>
                        <th>Số tài khoản</th>
                        <th class="text-center">Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>

</div>
</body>

</html>