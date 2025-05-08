<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThanhToanController extends Controller
{
    public function index(Request $request)
    {
        return view('pay');
    }

    public function process(Request $request)
    {
        $user = Auth::guard('thanhvien')->user();
        $priceAfterDiscount = (int)$request->input('priceAfterDiscount');
        $quantity = (int)$request->input('quantity');
        $totalAmount = $priceAfterDiscount * $quantity;
        $mathecaoId = (int)$request->input('mathecao_id');

        if ($user->so_du < $totalAmount) {
            return redirect()->back()->with('error', 'Số dư không đủ.');
        }

        DB::beginTransaction();
        try {
            // Trừ số dư
            $user->so_du -= $totalAmount;
            $user->save();

            // Tạo mã đơn (ngẫu nhiên hoặc theo quy tắc)
            $maDon = 'DON' . strtoupper(uniqid());

            // Lưu đơn hàng vào bảng `mathecao_donhang`
            DB::table('mathecao_donhang')->insert([
                'ma_don' => $maDon,
                'mathecao_id' => $mathecaoId,
                'so_luong' => $quantity,
                'thanh_tien' => $totalAmount,
                'thanhvien_id' => $user->id_thanhvien,
                'trang_thai' => 'Chờ xử lý',
                'ngay_tao' => now()
            ]);

            DB::commit();
            return redirect()->back()->with('payment_success', true)->with('ma_don', $maDon);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
