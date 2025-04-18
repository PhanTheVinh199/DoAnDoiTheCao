<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kho Thẻ King Grab</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('font-awesome/font/fontawesome-webfont.eot')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
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
            transition: transform 0.3sease, box-shadow 0.3sease;
        }
    </style>
</head>
<header id="header-m1" class="header-m1 header-sort">
    <nav class="container d-flex align-items-center flex-lg-wrap">
        <div class="header-hamburger">
            <span></span>
        </div>
        <a class="header-logo" href="">
            <img src="<?php echo e(asset('images/logoKinggcrab.jpeg')); ?>" alt="logoKinggcrab" class="float-start" width="150px" height="100px">
        </a>
        <div class="header-navigation">
            <ul class="list-unstyled mb-0">
                <li class="d-lg-none d-inline-block navigation-logo text-center">
                    <a href="#">
                        <img src="public/images/logoKinggcrab.jpeg" height="40px" class="img-fluid"
                            alt="logoKinggcrab">
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="<?php echo e(route('index')); ?>">
                        Đổi thẻ cào
                    </a>
                </li>

                <li class="d-inline-block ">
                    <a href="<?php echo e(route('card')); ?>">
                        Mua thẻ Cào
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="<?php echo e(route('ruttien')); ?>">
                        RÚT TIỀN
                    </a>
                </li>
                <li class="d-inline-block ">
                    <a href="<?php echo e(route('naptien')); ?>">
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
                            <a href="<?php echo e(route('lichsudoithe')); ?>">LỊCH SỬ ĐỔI THẺ</a>
                        </li>
                        <li class="d-block">
                            <a href="<?php echo e(route('lichsumuathe')); ?>">LỊCH SỬ MUA THẺ</a>
                        </li>
                        <li class="d-block">
                            <a href="<?php echo e(route('lichsusodu')); ?>">LỊCH SỬ SỐ DƯ</a>
                        </li>
                    </ul>
                    <span class="sub-icon">+</span>
                </li>
            </ul>
        </div>
        <div class="header-user">
            <div class="header-nologin">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-small btn-register">
                    <i class="fas fa-user"></i> Đăng ký
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-small btn-login">
                    <i class="fas fa-lock"></i> Đăng nhập
                </a>
            </div>
        </div>
        <div class="header-usermb">
            <button type="button" class="btn" id="call-userMB"><i class="fas fa-user"></i>Tài khoản</button>
            <div class="header-usermb_list">
                <ul class="list-unstyled mb-0">
                    <li class="d-inline-block text-center header-usermb_list__logo">
                        <a href="">
                            <img src="https://doithe1s.vn/storage/userfiles/files/doithe1s2019.png" height="40px"
                                alt=" - Đổi Thẻ Cào Thành Tiền Mặt Tự Động Chiết Khấu Tốt Nhất Việt Nam">
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="register.html">
                            <i class="fa fa-angle-right"></i> <strong>Đăng ký</strong>
                        </a>
                    </li>
                    <li class="d-inline-block">
                        <a href="login.html">
                            <i class="fa fa-angle-right"></i> <strong>Đăng nhập</strong>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header><?php /**PATH K:\doanbe2\doanbe2_ver3\Code_git\DoAnDoiTheCao\laravel_12\resources\views/partials/header.blade.php ENDPATH**/ ?>