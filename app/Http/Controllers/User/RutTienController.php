<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RutTien;
use App\Models\NganHang;
use Illuminate\Http\Request;

class RutTienController extends Controller
{
    public function showRutTienForm()
    {
        $user = auth()->user();
        $banks = $user->nganHang;
        return view('user.add_nganhang_user', compact('banks'));
    }

    public function showRutTienHistory()
    {
        $user = auth()->user();
        $dsRutTien = RutTien::getUserRutTienHistory($user->id_thanhvien);
        return view('ruttien', compact('dsRutTien'));
    }

    public function showAddBankForm()
    {
        return view('add_nganhang_user');
    }

    public function addBank(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'ten_ngan_hang' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:125',
            'so_tai_khoan' => 'required|numeric',
            'chu_tai_khoan' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
        ]);

        RutTien::addUserBank($user->id_thanhvien, $validated);

        return redirect()->route('ruttien')->with('success', 'Ngân hàng đã được thêm thành công.');
    }

    public function processRutTien(Request $request)
    {
        $user = auth()->user();
        $amount = $request->input('amount');
        $bankId = $request->input('bankinfo_id');

        try {
            RutTien::processRutTien($user, $bankId, $amount);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('ruttien')->with('success', 'Rút tiền thành công. Số dư hiện tại của bạn là ' . number_format($user->so_du) . ' VND.');
    }
}
