<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        @keyframes highlightEffect {
            0% {
                left: -300px;
                opacity: 0.4;
            }

            50% {
                left: 100%;
                opacity: 0.8;
            }

            100% {
                left: 100%;
                opacity: 0;
            }
        }

        .header-logo {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        .header-logo::before {
            content: "";
            position: absolute;
            left: -300px;
            top: 0;
            width: 50px;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.7) 50%, rgba(255, 255, 255, 0) 100%);
            transform: skewX(-20deg);
            animation: highlightEffect 4s ease-in-out infinite;
        }

        .btn-theme_secondary {
            position: relative;
            display: inline-block;
            overflow: hidden;
            background-color: #28a745;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .balance-btn {
            background-color: #28a745;
            /* Màu xanh lá */
            color: #fff;
        }

        .account-btn {
            background-color: #f1f1f1;
            /* Màu trắng xám */
            color: #333;
        }

        .logout-btn {
            background-color: #dc3545;
            /* Màu đỏ */
            color: #fff;
        }
        .balance-btn:hover {
            background-color: #218838;
        }

        .account-btn:hover {
            background-color: #e2e2e2;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

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
                <li class="d-lg-none d-inline-block navigation-logo text-center">
                    <a href="#">
                        <img src="public/images/logoKinggcrab.jpeg" height="40px" class="img-fluid" alt="logoKinggcrab">
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="{{ route('index') }}">
                        Đổi thẻ cào
                    </a>
                </li>

                <li class="d-inline-block ">
                <a href="{{ route('card') }}">Mua Thẻ Cào </a>
                </li>
                <li class="d-inline-block ">
                    <a href="{{ route('ruttien') }}">
                        RÚT TIỀN
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="{{ route('naptien') }}">
                        NẠP TIỀN
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="naptiendienthoai.html">
                        NẠP ĐIỆN THOẠI
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="#">
                        bảo mật
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="#">
                        KẾT NỐI API
                    </a>
                </li>
                <li class="d-inline-block  hasSub ">
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
            <div class="header-loggedin">
                <a href="#" class="btn btn-small btn-account balance-btn">
                    <i class="fas fa-wallet"></i> Số dư: {{ Auth::guard('thanhvien')->user()->so_du }} VND
                </a>
                <a href="#" class="btn btn-small btn-account account-btn" style="margin-left: 10px;">
                    <i class="fas fa-user"></i> {{ Auth::guard('thanhvien')->user()->tai_khoan }}
                </a>
                <a href="{{ route('logout') }}" class="btn btn-small btn-logout logout-btn" style="margin-left: 10px;">
                    <i class="fa fa-sign-out-alt"></i> Đăng xuất
                </a>
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

</html>