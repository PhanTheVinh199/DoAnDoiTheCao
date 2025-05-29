<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThanhVien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
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
        ], [
            'login_input.required' => 'Tài khoản hoặc email là bắt buộc.',
            'mat_khau.required' => 'Mật khẩu là bắt buộc.',
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
            'login_input' => 'Sai tài khoản/email hoặc mật khẩu.'
        ])->with('login', 'Sai tài khoản/email hoặc mật khẩu.');
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Xác nhận các dữ liệu nhập vào
        $request->validate([
            'tai_khoan' => 'required|string|min6|max30|unique:thanhvien,tai_khoan',
            'ho_ten'    => 'required|string|max:100',
            'email'     => 'nullable|email|unique:thanhvien,email', 
            'phone'     => 'nullable|string|max:20',
            'mat_khau' => 'required|string|min:6|max:30|confirmed',
        ], [
            'tai_khoan.required' => 'Tài khoản là bắt buộc.',
            'tai_khoan.unique'   => 'Tài khoản đã tồn tại.',
            'email.required'     => 'Email là bắt buộc.',
            'email.email'        => 'Email không hợp lệ.',
            'email.unique'       => 'Email đã tồn tại.',
        ]);

        // Kiểm tra nếu tài khoản đã tồn tại
        if (ThanhVien::where('tai_khoan', $request->tai_khoan)->exists()) {
            return back()->withErrors(['tai_khoan' => 'Tài khoản đã tồn tại.']);
        }

        // Kiểm tra nếu email đã tồn tại
        if (ThanhVien::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email đã tồn tại.']);
        }

        // Kiểm tra xem có phải là người dùng đầu tiên không để gán quyền admin
        $isFirstUser = ThanhVien::count() === 0;

        // Tạo người dùng mới
        $thanhvien = ThanhVien::create([
            'tai_khoan' => $request->tai_khoan,
            'ho_ten'    => $request->ho_ten,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'mat_khau'  => Hash::make($request->mat_khau),
            'so_du'     => 0,
            'quyen'     => $isFirstUser ? 'admin' : 'user'
        ]);

        // Đăng ký thành công
        return redirect()->route('login')->with('message', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    public function showChangePasswordForm()
    {
        return view('auth.change_password');
    }

    // Xử lý đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|max:30|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required'     => 'Vui lòng nhập mật khẩu mới.',
            'new_password.confirmed'    => 'Mật khẩu xác nhận không khớp.',
            'new_password.min'          => 'Mật khẩu mới phải ít nhất 6 ký tự đến 30.',
        ]);

        $user = Auth::guard('thanhvien')->user();

        if (!Hash::check($request->current_password, $user->mat_khau)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'mat_khau' => Hash::make($request->new_password),
        ]);

        return redirect()->route('index')->with('success', 'Đổi mật khẩu thành công!');
    }
}
