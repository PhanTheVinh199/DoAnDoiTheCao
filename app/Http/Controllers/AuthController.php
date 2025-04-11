<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThanhVien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('thanhvien')->check()) {
            return redirect()->route('index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_input' => 'required|string',
            'mat_khau' => 'required|string',
        ]);

        // Xác định người dùng nhập email hay tài khoản
        $login_type = filter_var($request->login_input, FILTER_VALIDATE_EMAIL) ? 'email' : 'tai_khoan';

        // Tìm user tương ứng
        $user = ThanhVien::where($login_type, $request->login_input)->first();

        // Kiểm tra user tồn tại và mật khẩu đúng
        if ($user && Hash::check($request->mat_khau, $user->mat_khau)) {
            Auth::guard('thanhvien')->login($user); // Đăng nhập thủ công
            $request->session()->regenerate();

            return redirect()->route('index')->with('success', 'Đăng nhập thành công!');
        }

        // Nếu sai
        return back()->withErrors([
            'login' => 'Sai tài khoản/email hoặc mật khẩu.',
        ]);
    }
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'tai_khoan' => 'required|string|max:50|unique:thanhvien,tai_khoan',
            'ho_ten'    => 'required|string|max:100',
            'email'     => 'nullable|email',
            'phone'     => 'nullable|string|max:20',
            'mat_khau' => 'required|string|min:6|confirmed',
        ]);

        $thanhvien = ThanhVien::create([
            'tai_khoan' => $request->tai_khoan,
            'ho_ten'    => $request->ho_ten,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'mat_khau'  => Hash::make($request->mat_khau),
            'so_du'     => 0,
            'quyen'     => 'user'
        ]);


        return redirect()->route('login')->with('message', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}

// Route::middleware('auth:thanhvien')->group(function () {
//     Route::view('/naptien', 'naptien')->name('naptien');
//     Route::view('/ruttien', 'ruttien')->name('ruttien');
// });