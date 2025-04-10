@include('partials.header')
    <div class="section-gap">
        <div class="row">

            <div class="col-md-6">
                <div class="description mb-3">
                    <div class="title">
                        Tạo yêu cầu nạp quỹ
                    </div>
                </div>
                <div class="form-m1">
                    <form action="#" method="POST">
                        <input type="hidden" name="_token" value="1wZdxcAkOIkW8OUkQh70hmaS8Qwtr5bcigO5rokS">
                        <div class="row row10">
                            <div class="col-12">
                                <label for="" class="col-form-label">
                                    Số dư quỹ: <b class="font-weight-bold text-success">0 VND</b>
                                </label>
                            </div>
                        </div>
                        <div class="row row10">
                            <div class="col-5 col-sm-4">
                                <label for="" class="col-form-label font-weight-bold">
                                    Số tiền nạp:
                                </label>
                            </div>
                            <div class="col-7 col-sm-8">
                                <input name="net_amount" type="text" class="form-control fnum" id="net_amount"
                                    placeholder="Số tiền nạp" value="">
                                <input name="wallet" type="hidden" value="0078591869">
                                <span class="text-danger text-small"> Tối thiểu 1 VND , Tối đa 1 VND </span>
                            </div>
                        </div>
                        <div class="row row10">
                            <div class="col-5 col-sm-4">
                                <label for="" class="col-form-label font-weight-bold">
                                    Cổng thanh toán:
                                </label>
                            </div>
                            <div class="col-7 col-sm-8">
                                <select class="form-control" name="paygate_code" required>
                                    <option value="Localbank_ACB">Ngân hàng ACB</option>
                                </select>
                            </div>
                        </div>
                        <div class="row row10">
                            <div class="col-sm-8 offset-sm-4 text-center text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-dollar-sign"></i>
                                    Nạp tiền ngay
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-md-6 mt-4 mt-lg-0">
                <div class="description mb-1">
                    <div class="small-title">
                        Hạn mức và phí:
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-module">
                        <tr>
                            <td>Tổng hạn mức ngày</td>
                            <th>1 VND</th>
                        </tr>
                        <tr>
                            <td>Số tiền tối thiểu</td>
                            <th>1 VND</th>
                        </tr>
                        <tr>
                            <td>Số tiền tối đa</td>
                            <th>1 VND</th>
                        </tr>
                    </table>
                </div>
                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-module">
                            <tr>
                                <th>Cổng thanh toán</th>
                                <th class="text-center">Phí cố định</th>
                                <th class="text-center">Phí %</th>
                            </tr>
                            <tr>
                                <td>Ngân hàng ACB</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0%</td>
                            </tr>
                            <tr>
                                <td>Ngân Hàng ACB NN</td>
                                <td class="text-center">0</td>
                                <td class="text-center">0.1%</td>
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
                Lịch sử nạp tiền
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-module">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th class="text-center">Nạp vào quỹ</th>
                        <th class="text-center">Số tiền</th>
                        <th>Cổng thanh toán</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>