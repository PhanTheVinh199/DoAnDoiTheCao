<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/style_Login_register.css')}}">
</head>

<body>
    <form class="register-container" action="{{route('register.submit')}}" method="post">
        @csrf
        <div class="title">Đăng Ký</div>
        <input type="text" name="tai_khoan" id="tai_khoan" placeholder="Tên Đăng Nhập" required
            pattern="^[a-zA-Z0-9 ]{6,30}$">
        @error('tai_khoan')
        <span style="color: red; font-size: 15px;">{{ $message }}</span>
        @enderror
        <span id="error_message" style="color: red; font-size: 15px;"></span>
        <span id="correct_message" style="color: green; font-size: 15px;"></span><br>

        <input type="text" name="ho_ten" id="ho_ten" placeholder="Họ và Tên" required
            pattern="^[A-Za-zÀ-Ỹà-ỹ\s]{6,30}$">
        <span id="error_fullname" style="color: red; font-size: 15px;"></span>
        <span id="correct_fullname" style="color: green; font-size: 15px;"></span><br>

        <input type="tel" name="phone" id="phone" placeholder="Số Điện Thoại" required
            pattern="^0[0-9]{8,10}$">
        <span id="error_phoneNumber" style="color: red; font-size: 15px;"></span>
        <span id="correct_phoneNumber" style="color: green; font-size: 15px;"></span><br>

        <input type="email" name="email" id="email" placeholder="email" required
            pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
        @error('email')
        <span style="color: red; font-size: 15px;">{{ $message }}</span>
        @enderror
        <span id="error_email" style="color: red; font-size: 15px;"></span>
        <span id="correct_email" style="color: green; font-size: 15px;"></span><br>

        <input type="password" name="mat_khau" id="mat_khau" placeholder="Tạo mật khẩu" autocomplete="off" required
            pattern="^[a-zA-Z0-9!@#$%^&*]{6,}$">
        <span id="error_password" style="color: red; font-size: 15px;"></span>
        <span id="correct_password" style="color: green; font-size: 15px;"></span><br>

        <input type="password" name="mat_khau_confirmation" id="RePassword" placeholder="Nhập lại mật khẩu" autocomplete="off" required>
        <span id="error_repassword" style="color: red; font-size: 15px;"></span><br>

        <input class="submit" type="submit" value="Đăng ký">

        <a href="{{route('login')}}">Bạn đã có tài khoản?<span class="dk">Quay lại </span></a>
    </form>










    <script>
        document.getElementById("tai_khoan").addEventListener("input", function() {
            let regex = /^[a-zA-Z0-9 ]{6,30}$/; // = new RegExp ("^[a-zA-Z ]{6,30}$")
            let inputValue = this.value;
            let error_message = document.getElementById("error_message");
            let correct_message = document.getElementById("correct_message");

            if (inputValue.length < 6) {
                error_message.textContent = "❌ Tên quá ngắn! Vui lòng nhập ít nhất 6 ký tự.";
                correct_message.textContent = "";
            } else if (inputValue.length > 30) {
                error_message.textContent = "❌ Tên quá dài! Chỉ được tối đa 30 ký tự.";
                correct_message.textContent = "";
            } else if (!regex.test(inputValue)) {
                error_message.textContent = "❌ Tên chỉ được chứa chữ cái, số và khoảng trắng.";
                correct_message.textContent = "";
            } else {
                error_message.textContent = "";
                correct_message.textContent = "✅ Tên đăng nhập hợp lệ!";
            }
        })

        document.getElementById("ho_ten").addEventListener("input", function() {
            let regex = /^[A-Za-zÀ-Ỹà-ỹ\s]{6,30}$/;
            let inputValue = this.value;
            let error_message = document.getElementById("error_fullname");
            let correct_message = document.getElementById("correct_fullname");

            if (!regex.test(inputValue)) {
                error_message.textContent = " ❌ Tên Không hợp lệ.";
                correct_message.textContent = "";
            } else {
                error_message.textContent = "";
                correct_message.textContent = "✅ Họ tên hợp lệ!";
            }
        })

        document.getElementById("phone").addEventListener("input", function() {
            let regex = /^0[0-9]{8,10}$/;
            let inputValue = this.value;
            let error_message = document.getElementById("error_phoneNumber");
            let correct_message = document.getElementById("correct_phoneNumber");

            if (!regex.test(inputValue)) {
                error_message.textContent = " ❌Số điện thoại không hợp lệ.";
                correct_message.textContent = "";
            } else {
                error_message.textContent = "";
                correct_message.textContent = "✅ Số điện thoại hợp lệ!";
            }
        })

        document.getElementById("email").addEventListener("input", function() {
            let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            let inputValue = this.value;
            let error_message = document.getElementById("error_email");
            let correct_message = document.getElementById("correct_email");

            if (!regex.test(inputValue)) {
                error_message.textContent = " ❌ Email không đúng định dạng!";
                correct_message.textContent = "";
            } else {
                error_message.textContent = "";
                correct_message.textContent = "✅Email hợp lệ!";
            }
        })

        document.getElementById("mat_khau").addEventListener("input", function() {
            let regex = /^[a-zA-Z0-9!@#$%^&*]{6,}$/;
            let inputValue = this.value;
            let error_message = document.getElementById("error_password");
            let correct_message = document.getElementById("correct_password");

            if (!regex.test(inputValue)) {
                error_message.textContent = " ❌ Tối Thiểu 6 ký tự";
                correct_message.textContent = "";
            } else {
                error_message.textContent = "";
                correct_message.textContent = "✅ hợp lệ!";
            }
        })

        document.querySelector("form").addEventListener("submit", function(event) {
            let password = document.getElementById("mat_khau").value;
            let rePassword = document.getElementById("RePassword").value;
            let error_message = document.getElementById("error_repassword");

            if (rePassword.trim() !== password.trim()) {
                error_message.textContent = "❌ Mật khẩu nhập lại không trùng khớp!";
                event.preventDefault(); // Chặn form gửi đi
            } else {
                error_message.textContent = ""; // Xóa thông báo lỗi nếu trùng khớp
            }
        });
    </script>
</body>

</html>