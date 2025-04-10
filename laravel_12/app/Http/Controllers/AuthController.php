<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // // Ví dụ kiểm tra tài khoản (giả định cứng)
        // $username = $request->input('username');
        // $password = $request->input('password');

        // if ($username === 'admin' && $password === '123') {
        //     // Đăng nhập thành công → chuyển về trang chủ
        //     return redirect()->route('index');
        // }

        // // Sai tài khoản → quay lại với thông báo
        // return back()->with('error', 'Sai tài khoản hoặc mật khẩu!');

        // Chưa xử lý gì hết, chỉ chuyển về trang chủ
        return redirect()->route('index');
    }
    public function register(Request $request)
    {
        // Bước này bạn có thể xử lý lưu dữ liệu nếu muốn
        // Giờ chỉ cần redirect qua trang login

        return redirect()->route('login');
    }
}
