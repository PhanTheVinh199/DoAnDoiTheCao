<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style_Login_register.css') }}">

</head>

<body>
    <form class="formlogin-container" method="POST" action="{{ route('login.submit') }}">
    @csrf
    <div class="title">Đăng Nhập</div>
    <div class="form-login">

        <input type="text" name="login_input" id="username" placeholder="Email hoặc Tài khoản" required><br>

        <input type="password" name="mat_khau" id="password" placeholder="Nhập mật khẩu" required>
        <span class="toggle-password" onclick="togglePassword()">
            <i id="eye-icon" class="fa-solid fa-eye"></i>
        </span><br>
        
        @error('mat_khau')
            <div class="error-message" style="color: red; font-size: 14px;">{{ $message }}</div>
        @enderror
        <br>
        
        @error('login_input')
            <div class="error-message" style="color: red; font-size: 14px;">{{ $message }}</div>
        @enderror

        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Lưu mật khẩu</label>
        <a class="quenmk" href="#">Quên mật khẩu ?</a><br>

        <input class="submit" type="submit" value="Đăng Nhập" style="cursor: pointer;"><br>

        <a href="{{ route('register') }}">Bạn chưa có tài khoản?<span class="dk">Đăng ký</span></a>
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
