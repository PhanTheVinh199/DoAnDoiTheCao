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
        // Kiểm tra xem người dùng đã đăng nhập và có quyền admin không
        if (Auth::guard('thanhvien')->check() && Auth::guard('thanhvien')->user()->quyen === 'admin') {
            return $next($request); // Cho phép tiếp tục nếu là admin
        }

        // Nếu không phải admin, chuyển hướng đến trang chủ
        return redirect()->route('index');
    }
}

