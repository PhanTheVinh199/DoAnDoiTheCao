<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kho Thẻ King Grab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
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
            0% { left: -300px; opacity: 0.4; }
            50% { left: 100%; opacity: 0.8; }
            100% { left: 100%; opacity: 0; }
        }

        .header-logo { position: relative; display: inline-block; overflow: hidden; }

        .header-logo::before {
            content: "";
            position: absolute;
            left: -300px;
            top: 0;
            width: 50px;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0) 100%);
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
    </style>
</head>

<body>
    <header id="header-m1" class="header-m1 header-sort">
        <nav class="container d-flex align-items-center flex-lg-wrap">
            <div class="header-hamburger"><span></span></div>
            <a class="header-logo" href="">
                <img src="{{ asset('images/logoKinggcrab.jpeg') }}" alt="logoKinggcrab" width="150" height="100">
            </a>
            <div class="header-navigation">
                <ul class="list-unstyled mb-0">
                    <li class="d-lg-none d-inline-block navigation-logo text-center">
                        <a href="#"><img src="public/images/logoKinggcrab.jpeg" height="40" class="img-fluid" alt="logo"></a>
                    </li>
                    <li class="d-inline-block"><a href="{{route('index')}}">Đổi thẻ cào</a></li>
                    <li class="d-inline-block"><a href="{{route('card')}}">Mua thẻ Cào</a></li>
                    <li class="d-inline-block"><a href="{{route('ruttien')}}">RÚT TIỀN</a></li>
                    <li class="d-inline-block"><a href="{{route('naptien.form')}}">NẠP TIỀN</a></li>
                    <li class="d-inline-block"><a href="{{route('naptiendienthoai')}}">NẠP ĐIỆN THOẠI</a></li>
                    <li class="d-inline-block"><a href="#">bảo mật</a></li>
                    <li class="d-inline-block"><a href="#">KẾT NỐI API</a></li>
                    <li class="d-inline-block hasSub">
                        <a href="#">LỊCH SỬ <i class="fas fa-caret-down"></i></a>
                        <ul class="list-unstyled mb-0">
                            <li><a href="{{route('lichsudoithe')}}">LỊCH SỬ ĐỔI THẺ</a></li>
                            <li><a href="{{route('lichsumuathe')}}">LỊCH SỬ MUA THẺ</a></li>
                            <li><a href="{{route('lichsusodu')}}">LỊCH SỬ SỐ DƯ</a></li>
                        </ul>
                        <span class="sub-icon">+</span>
                    </li>
                </ul>
            </div>
            <div class="header-user">
                @if(Auth::guard('thanhvien')->check())
                    <div class="header-loggedin">
                        <a href="#" class="btn btn-small btn-account"><i class="fas fa-user"></i> Tài khoản</a>
                        <a href="{{ route('logout') }}" class="btn btn-small btn-logout" style="margin-left: 10px;"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a>
                    </div>
                @else
                    <div class="header-nologin">
                        <a href="{{ route('register') }}" class="btn btn-small btn-register"><i class="fas fa-user"></i> Đăng ký</a>
                        <a href="{{ route('login') }}" class="btn btn-small btn-login"><i class="fas fa-lock"></i> Đăng nhập</a>
                    </div>
                @endif
            </div>
        </nav>
    </header>

    {{-- Nội dung trang --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Footer (nếu có) --}}
    {{-- @include('partials.footer') --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
