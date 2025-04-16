<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        .bx { font-size: 20px; padding: 5px; color: rgb(255, 245, 245); }
    </style>
</head>
<body>
    <!-- Nút mở menu trên mobile -->
    <button id="menuToggle" class="menu-btn" style="margin-left: -15px; margin-top: 7px; font-size: 10px;">
        <i class='bx bx-menu'></i>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar ">
        <div class="menu-title">Dasboard</div>
        <a href="#menu1" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bx-credit-card'> Mã thẻ cào </i></span> <span>▼</span>
        </a>
        <div id="menu1" class="collapse ps-3">
            <a href="#">Đơn hàng</a>
            <a href="#">Sản phẩm</a>
            <a href="{{ route('admin.doithecao.nhacungcap.index') }}">Nhà cung cấp</a>
        </div>
        <a href="#menu2" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bxs-credit-card-alt'> Đổi thẻ cào </i></span> <span>▼</span>
        </a>
        <div id="menu2" class="collapse ps-3">
            <a href="{{ route('admin.doithecao.donhang.index') }}" class="{{ request()->routeIs('admin.doithecao.donhang.index') ? 'active' : '' }}">Đơn hàng</a>
            <a href="{{ route('admin.doithecao.danhsach.index') }}">Sản phẩm</a>
            <a href="{{ route('admin.doithecao.nhacungcap.index') }}">Nhà cung cấp</a>
        </div>
        <a href="#menu4" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bxs-bank'> Ngân hàng </i></span> <span>▼</span>
        </a>
        <div id="menu4" class="collapse ps-3">
            <a href="#">Danh sách Ngân Hàng</a>
            <a href="#">Lịch sử rút</a>
            <a href="#">Lịch sử nạp</a>
        </div>
        <a href="#menu5" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bx-user'> Thành Viên </i></span> <span>▼</span>
        </a>
        <div id="menu5" class="collapse ps-3">
            <a href="#">Danh Sách</a>
        </div>
        <a href="#menu6" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bxs-cog'>Cấu hình</i></span> <span>▼</span>
        </a>
        <div id="menu6" class="collapse ps-3">
            <a href="#">Cổng Thanh Toán</a>
        </div>
    </div>

    <div class="main" style="margin-top: 10px; padding: 30px">
        <div class="container">
            <div class="row d-flex">
                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Đơn bán thẻ</h1>
                    <!-- Phần tìm kiếm -->
                    <div class="d-flex flex-wrap gap-2 mb-4" style="margin-left: 900px;">
                        <form action="{{ route('admin.doithecao.donhang.index') }}" method="GET" class="d-flex">
                            <input type="text" name="ma_don" placeholder="Mã Đơn" class="form-control w-auto" value="{{ request('ma_don') }}">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Mã Đơn</th>
                                <th>Sản Phẩm</th>
                                <th>Mã Thẻ</th>
                                <th>Seri</th>
                                <th>Mệnh giá</th>
                                <th>Số lượng</th>
                                <th>Chiếc khấu</th>
                                <th>Thành tiền</th>
                                <th>Khách Hàng</th>
                                <th>Ngày tạo</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donhang as $order)
                                <tr>
                                    <td>{{ $order->id_dondoithe }}</td>
                                    <td>{{ $order->ma_don }}</td>
                                    <td>{{ $order->doithecao->ten_san_pham }}</td>
                                    <td>{{ $order->ma_the }}</td>
                                    <td>{{ $order->serial }}</td>
                                    <td>{{ number_format($order->thanh_tien, 0, ',', '.') }}</td>
                                    <td>{{ $order->so_luong }}</td>
                                    <td>{{ $order->trang_thai }}</td>
                                    <td>{{ number_format($order->thanh_tien, 0, ',', '.') }}</td>
                                    <td>{{ $order->khach_hang }}</td>
                                    <td>{{ $order->ngay_tao }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success">{{ $order->trang_thai }}</button>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.doithecao.donhang.edit', $order->id_dondoithe) }}" class="btn btn-dark">Sửa</a>
                                        <form action="{{ route('admin.doithecao.donhang.destroy', $order->id_dondoithe) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>
</html>