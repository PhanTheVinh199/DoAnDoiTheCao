<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />




    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
    <style>
        .bx {
            font-size: 20px;
            padding: 5px;
            color: rgb(255, 245, 245);
        }
    </style>
</head>

<body>


    <!-- Nút mở menu trên mobile
    <button id="menuToggle" class="menu-btn" style="margin-left: -15px; margin-top: 7px; font-size: 10px;">
        <i class='bx bx-menu'></i>
    </button> -->

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar ">
        <div class="menu-title">Dasboard</div>
        <a href="#menu0" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bx-credit-card'>
                    Trang Chủ
                </i> </span> <span>▼</span>
        </a>
        <div id="menu0" class="collapse ps-3">
            <a href="{{route('admin.index')}}">Thống Kê</a>
        </div>

        <a href="#menu1" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bx-credit-card'>
                    Mã thẻ cào
                </i> </span> <span>▼</span>

        </a>
        <div id="menu1" class="collapse ps-3">
            <a href="{{route('admin.mathecao.donhang.index')}}">Đơn hàng</a>
            <a href="{{route('admin.mathecao.loaima.index')}}">Sản phẩm</a>
            <a href="{{ route('admin.mathecao.nhacungcap.index') }}">Nhà cung cấp</a>
            <!-- <a href="#">Cấu hình</a> -->
        </div>

        <a href="#menu2" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span>
                <i class='bx bxs-credit-card-alt'> Đổi thẻ cào</i>
            </span>
            <span>▼</span>
        </a>
        <div id="menu2" class="collapse ps-3">
            <a href="{{ route('admin.doithecao.donhang.index') }}">Đơn hàng</a>
            <a href="{{ route('admin.doithecao.danhsach.index') }}" ">Sản phẩm</a>
            <a href=" {{ route('admin.doithecao.nhacungcap.index') }}" ">Nhà cung cấp</a>
        </div>



        <a href=" #menu4" class="d-flex justify-content-between" data-bs-toggle="collapse">
                <span><i class='bx bxs-bank'>
                        Ngân hàng
                    </i> </span> <span>▼</span>
            </a>
            <div id="menu4" class="collapse ps-3">

                <a href="{{route('admin.nganhang.index')}}">Danh sách Ngân Hàng</a>
                <a href="{{route('admin.nganhang.ruttien.index')}}">Lịch sử rút</a>
                <a href="{{ route('admin.nganhang.naptien.index') }}">Lịch sử nạp</a> <!-- Add this line -->
            </div>

            <a href="#menu5" class="d-flex justify-content-between" data-bs-toggle="collapse">
                <span><i class='bx bx-user'>
                        Thành Viên
                    </i> </span> <span>▼</span>
            </a>
            <div id="menu5" class="collapse ps-3">
                <a href="{{ route('admin.thanhvien.danhsach') }}">Danh Sách</a>
                <!-- <a href="#">Quản trị viên</a> -->
                <!-- <a href="#">Cấu hình </a> -->
            </div>

            <a href="#menu6" class="d-flex justify-content-between" data-bs-toggle="collapse">
                <span><i class='bx bxs-cog'>Cấu hình</i> </span> <span>▼</span>
            </a>
            <div id="menu6" class="collapse ps-3">

                <a href="{{ route('admin.nganhang.admin.index') }}">Cổng Thanh Toán </a>
                <!-- <a href="#">Hệ Thống </a> -->
            </div>


        </div>


        <!-- Main -->




        <!-- Main -->






        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <script>
            // Xử lý sự kiện mở/tắt sidebar khi nhấn vào nút ☰
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('open');
            });
        </script>
</body>

</html>
