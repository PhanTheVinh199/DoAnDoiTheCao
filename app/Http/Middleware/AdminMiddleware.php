<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có quyền admin
        if (Auth::guard('thanhvien')->check() && Auth::guard('thanhvien')->user()->quyen === 'admin') {
            return $next($request); // Nếu có quyền admin, cho phép truy cập tiếp
        }

        // Nếu không có quyền admin, chuyển hướng về trang chủ hoặc trang khác
        return redirect()->route('index')->with('error', 'Bạn không có quyền truy cập trang này.');
    }
}

