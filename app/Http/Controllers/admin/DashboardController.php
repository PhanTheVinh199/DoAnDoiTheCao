<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có quyền admin
        if (Auth::guard('thanhvien')->check() && Auth::guard('thanhvien')->user()->quyen === 'admin') {
            return view('admin.index'); 
        }else{
            return redirect()->route('index'); 
        }

       
        return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
    }
}

