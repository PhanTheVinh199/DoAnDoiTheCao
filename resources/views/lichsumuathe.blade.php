@include('partials.header')
    <div class="section-gap">
        <div class="container">
            <div class="description mb-3">
                <div class="title">
                    Lịch sử mua thẻ
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-filter mb-4">
                        <div class="form-m1">
                            <form action="#" name="formSearch" method="GET">
                                <div class="row row5 rowmb3">
                                    <div class="col-lg col-md-3 col-6">
                                        <div class="form-theme_item">
                                            <div class="form-theme_item--input">
                                                <input class="form-control" value="" name="order_code"
                                                    placeholder="Mã đơn">
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
                                        <button class="btn btn-primary btn-small text-nowrap m-1 my-md-0" type="submit"
                                            name="submit" value="filter">
                                            <span class="fal fa-search me-1"></span>
                                            Lọc
                                        </button>
                                        <button class="btn h-100 btn-success btn-small text-nowrap m-1 my-md-0"
                                            type="submit" name="submit" value="excel">
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

                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table id="table-rowspan" class="table table-bordered table-module-white">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Sản phẩm</th>
                                        <th>Trạng thái</th>
                                        <th>Số tiền</th>
                                        <th>Ngày tạo</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
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