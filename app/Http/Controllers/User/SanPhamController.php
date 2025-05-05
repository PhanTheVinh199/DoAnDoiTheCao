<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_NhaCungCap;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $dsNhaCungCap = MaThe_NhaCungCap::all();
        return view('card', compact('dsNhaCungCap'));
    }
}


