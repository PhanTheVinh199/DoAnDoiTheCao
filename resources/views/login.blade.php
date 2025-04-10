<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/style_Login_register.css')}}">

</head>

<body>
    <form class="formlogin-container" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="title">Đăng Nhập</div>
        <div class="form-login">

            <input type="text" name="username" id="username" placeholder="Tên tài khoản" required><br>

            <input type="password" id="password" placeholder="Nhập mật khẩu" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i id="eye-icon" class="fa-solid fa-eye"></i>
            </span><br>
            <input type="checkbox" name="" id=""><label for="">Lưu Mật Khẩu</label>
            <a class="quenmk" href="#">Quên mật khẩu ?</a><br>
            <input class="submit" type="submit" value="Đăng Nhập"><br>
            <a href="{{route('register')}}">Bạn chưa có tài khoản?<span class="dk">Đăng ký</span></a>
        </div>
    </form>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>