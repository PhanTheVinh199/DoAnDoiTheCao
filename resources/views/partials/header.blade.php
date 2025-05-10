<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon_32x32.png') }}" type="image/png">
    <title>Kho Thẻ King Grab</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('font-awesome/font/fontawesome-webfont.eot') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css">
    <style>
        :root {
            --primary-color: #28a745;
            --primary-hover: #0066ff;
            --primary-rgb: 1, 36, 103;
        }

        .header-logo {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        /* Thêm dropdown cho người dùng */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px 0;
            min-width: 200px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dropdown:hover {
            background-color: aqua;
        }

        .dropdown:hover .dropdown-menu {
            display: block;

        }

        .dropdown-item {
            padding: 8px 16px;
            text-decoration: none;
            color: #333;
            display: block;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <header id="header-m1" class="header-m1 header-sort">
        <nav class="container d-flex align-items-center flex-lg-wrap">
            <div class="header-hamburger">
                <span></span>
            </div>
            <a class="header-logo" href="">
                <img src="{{ asset('images/logoKinggcrab.jpeg') }}" alt="logoKinggcrab" class="float-start" width="150px" height="100px">
            </a>
            <div class="header-navigation">
                <ul class="list-unstyled mb-0">
                    <li class="d-inline-block">
                        <a href="{{ route('index') }}">
                            Đổi thẻ cào
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="{{ route('card') }}">Mua Thẻ Cào </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="{{ route('ruttien') }}">
                            RÚT TIỀN
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="{{ route('naptien') }}">
                            NẠP TIỀN
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="naptiendienthoai.html">
                            NẠP ĐIỆN THOẠI
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="#">
                            bảo mật
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="#">
                            KẾT NỐI API
                        </a>
                    </li>
                    <li class="d-inline-block hasSub">
                        <a href="#">
                            LỊCH SỬ
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="list-unstyled mb-0">
                            <li class="d-block">
                                <a href="{{ route('lichsudoithe') }}">LỊCH SỬ ĐỔI THẺ</a>
                            </li>
                            <li class="d-block">
                                <a href="{{ route('lichsumuathe') }}">LỊCH SỬ MUA THẺ</a>
                            </li>
                            <li class="d-block">
                                <a href="{{ route('lichsusodu') }}">LỊCH SỬ SỐ DƯ</a>
                            </li>
                        </ul>
                        <span class="sub-icon">+</span>
                    </li>
                </ul>
            </div>
            <div class="header-user">
                @if(Auth::guard('thanhvien')->check())
                {{-- Nếu người dùng đã đăng nhập --}}
                <a href="#" class="btn btn-small btn-account balance-btn" style="background-color: #28a745; color: white;">
                    <i class="fas fa-wallet"></i> Số dư: {{ Auth::guard('thanhvien')->user()->so_du }} VND
                </a>
                <div class="dropdown">
                    <a href="#" class="btn btn-small btn-account account-btn" style="margin-left: 10px;">
                        <i class="fas fa-user"></i> {{ Auth::guard('thanhvien')->user()->tai_khoan }}<i class="fas fa-caret-down"></i>
                    </a>

                    <div class="dropdown-menu">
                        @if(Auth::guard('thanhvien')->user()->quyen === 'admin')
                        <a href="{{ route('admin.index') }}" class="dropdown-item">Quản Lý admin</a>
                        @endif
                        <a href="{{ route('logout') }}" class="dropdown-item" id="logout-link">Đăng xuất</a>

                    </div>
                </div>
            </div>
            @else
            {{-- Nếu người dùng chưa đăng nhập --}}
            <div class="header-nologin">
                <a href="{{ route('register') }}" class="btn btn-small btn-register">
                    <i class="fas fa-user"></i> Đăng ký
                </a>
                <a href="{{ route('login') }}" class="btn btn-small btn-login">
                    <i class="fas fa-lock"></i> Đăng nhập
                </a>
            </div>
            @endif
            </div>

            <div class="header-usermb">
                @if(Auth::guard('thanhvien')->check())
                {{-- Mobile khi người dùng đã đăng nhập --}}
                <button type="button" class="btn" id="call-userMB">
                    <i class="fas fa-user">Tài khoản</i>
                </button>
                <div class="header-usermb_list">
                    <ul class="list-unstyled mb-0">
                        <li class="d-inline-block text-center header-usermb_list__logo">
                            <a href="">
                                <img src="https://doithe1s.vn/storage/userfiles/files/doithe1s2019.png" height="40px" alt="Logo">
                            </a>
                        </li>
                        <li class="d-inline-block">
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out-alt"></i> <strong>Đăng xuất</strong>
                            </a>
                        </li>
                    </ul>
                </div>
                @else
                {{-- Mobile khi người dùng chưa đăng nhập --}}
                <button type="button" class="btn" id="call-userMB">
                    <i class="fas fa-user"></i> Tài khoản
                </button>
                <div class="header-usermb_list">
                    <ul class="list-unstyled mb-0">
                        <li class="d-inline-block text-center header-usermb_list__logo">
                            <a href="">
                                <img src="https://doithe1s.vn/storage/userfiles/files/doithe1s2019.png" height="40px" alt="Logo">
                            </a>
                        </li>
                        <li class="d-inline-block">
                            <a href="{{ route('register') }}">
                                <i class="fa fa-angle-right"></i> <strong>Đăng ký</strong>
                            </a>
                        </li>
                        <li class="d-inline-block">
                            <a href="{{ route('login') }}">
                                <i class="fa fa-angle-right"></i> <strong>Đăng nhập</strong>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </nav>
    </header>
    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định (truyền hướng đến route)

            // Hiển thị hộp thoại xác nhận
            if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
                // Nếu người dùng chọn "OK", thực hiện đăng xuất
                window.location.href = `{{ route('logout') }}`;
            }
        });
    </script>
</body>

</html>