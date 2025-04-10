@include('partials.header')

        <div class="section-gap">
            <div class="container">
                <div class="description mb-3">
                    <div class="title">
                        Lịch sử đổi thẻ
                    </div>
                    <!-- <p>Hệ thống tự động xóa lịch sử đổi thẻ cũ quá 2 tháng để giảm tải hệ thống!</p> -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-filter mb-4">
                            <div class="form-m1">
                                <form action="https://doithe1s.vn/doithecao/lich-su" name="formSearch" method="GET">
                                    <div class="row row5 rowmb3">
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="form-theme_item--input">
                                                    <input class="form-control" value="" name="code"
                                                        placeholder="Mã nạp">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="form-theme_item--input">
                                                    <input class="form-control" value="" name="serial"
                                                        placeholder="Serial">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="form-theme_item--input">
                                                    <input class="form-control" value="" name="request_id"
                                                        placeholder="Request ID">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="form-theme_item--input">
                                                    <select name="telco" class="form-control">
                                                        <option value="" selected="selected">Chọn mạng</option>

                                                        <option value="VIETTEL">Viettel</option>
                                                        <option value="VINAPHONE">Vinaphone</option>
                                                        <option value="MOBIFONE">Mobifone</option>
                                                        <option value="ZING">Zing</option>
                                                        <option value="VNMOBI">Vietnamobile</option>
                                                        <option value="GARENA">Garena (Duyệt nhanh)</option>
                                                        <option value="GATE">Gate</option>
                                                        <option value="VCOIN">Vcoin</option>
                                                        <option value="APPOTA">Appota</option>
                                                        <option value="SCOIN">Scoin</option>
                                                        <option value="ZINGCHAM">Zing (Duyệt chậm)</option>
                                                        <option value="GARENACHAM">Garena (Duyệt chậm)</option>

                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="form-theme_item--input">
                                                    <select name="status" class="form-control">
                                                        <option value="" selected="selected">Trạng thái</option>

                                                        <option value="1">Thành công</option>
                                                        <option value="2">Sai mệnh giá</option>
                                                        <option value="3">Thất bại</option>
                                                        <option value="4">Bỏ qua</option>
                                                        <option value="99">Chờ xử lý</option>

                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="position-relative">
                                                    <input class="form-control" value="07-04-2025" name="from_date"
                                                        type="date">
                                                    <div class="icon-ios"></div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-lg col-md-3 col-6">
                                            <div class="form-theme_item">
                                                <div class="position-relative">
                                                    <input class="form-control" value="07-04-2025" name="to_date"
                                                        type="date">
                                                    <div class="icon-ios"></div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-12 col-md flex-lg-grow-0 d-flex align-items-center px-0">
                                            <button class="btn btn-primary btn-small text-nowrap m-1 my-md-0"
                                                type="submit" name="submit" value="filter">
                                                <span class="fal fa-search me-1"></span>
                                                Lọc
                                            </button>
                                            <button class="btn h-100 btn-success btn-small text-nowrap m-1 my-md-0"
                                                type="submit" name="submit" value="excel">
                                                <i class="fas fa-file-excel me-0"></i>
                                            </button>
                                            <a href="https://doithe1s.vn/doithecao/lich-su"
                                                class="btn btn-danger btn-small text-nowrap m-1 my-md-0">
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
                                <table class="table table-bordered table-module">
                                    <thead>
                                        <tr class="bg-theme">
                                            <th class="text-nowrap text-center">Trạng thái</th>
                                            <th class="text-nowrap text-center">Mã nạp</th>
                                            <th class="text-nowrap text-center">Serial</th>
                                            <th class="text-nowrap text-center">Mạng</th>
                                            <th class="text-nowrap text-center">Tổng gửi</th>
                                            <th class="text-nowrap text-center">Tổng thực</th>
                                            <th class="text-nowrap text-center">Phí</th>
                                            <th class="text-nowrap text-center">Phạt</th>
                                            <th class="text-nowrap text-center">Nhận</th>
                                            <th class="text-nowrap text-center">Ngày tháng</th>
                                            <th>Request ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="17">
                                                <div class="float-right">
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>