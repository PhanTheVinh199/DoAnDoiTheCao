<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThanhToanController extends Controller
{
    // Hiển thị trang thanh toán, kèm kiểm tra dữ liệu query string
    public function index(Request $request)
    {
        $provider = $request->query('provider');
        $price = (int) $request->query('price');
        $discount = (float) $request->query('discount');
        $quantity = (int) $request->query('quantity');
        $priceAfterDiscount = (int) $request->query('priceAfterDiscount');
        $nhaCungCapId = (int) $request->query('nhaCungCapId');
        $idMatheCao = (int) $request->query('idMatheCao');

        $sanPham = DB::table('mathecao_danhsach')->where('id_mathecao', $idMatheCao)->first();
        if (!$sanPham) {
            return redirect()->route('card')->with('error', 'Dữ liệu không tồn tại.');
        }

        $nhaCungCap = DB::table('mathecao_nhacungcap')->where('id_nhacungcap', $nhaCungCapId)->first();
        if (!$nhaCungCap) {
            return redirect()->route('card')->with('error', 'Dữ liệu không tồn tại.');
        }

        if ($price <= 0 || $quantity <= 0 || $priceAfterDiscount <= 0) {
            return redirect()->route('card')->with('error', 'Dữ liệu không hợp lệ.');
        }

        $expectedPriceAfterDiscount = round($price - ($price * $discount / 100));
        if ($expectedPriceAfterDiscount != $priceAfterDiscount) {
            return redirect()->route('card')->with('error', 'Dữ liệu không hợp lệ.');
        }

        return view('pay', compact('provider', 'price', 'discount', 'quantity', 'priceAfterDiscount', 'nhaCungCap', 'sanPham'));
    }

    public function process(Request $request)
    {
        $user = Auth::guard('thanhvien')->user();

        $request->validate([
            'priceAfterDiscount' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'mathecao_id' => 'required|exists:mathecao_danhsach,id_mathecao',
            'email' => 'required|email',
        ], [
            'mathecao_id.exists' => 'Dữ liệu không tồn tại.',
        ]);

        $priceAfterDiscount = (int) $request->input('priceAfterDiscount');
        $quantity = (int) $request->input('quantity');
        $mathecaoId = (int) $request->input('mathecao_id');
        $totalAmount = $priceAfterDiscount * $quantity;

        $sanPham = DB::table('mathecao_danhsach')->where('id_mathecao', $mathecaoId)->first();
        if (!$sanPham) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại.');
        }

        if ($priceAfterDiscount <= 0 || $quantity <= 0 || $totalAmount <= 0) {
            return redirect()->back()->with('error', 'Dữ liệu không hợp lệ.');
        }

        if ($user->so_du < $totalAmount) {
            return redirect()->back()->with('error', 'Số dư không đủ.');
        }

        DB::beginTransaction();
        try {
            $user->so_du -= $totalAmount;
            $user->save();

            $maDon = 'DON' . strtoupper(uniqid());

            DB::table('mathecao_donhang')->insert([
                'ma_don' => $maDon,
                'mathecao_id' => $mathecaoId,
                'so_luong' => $quantity,
                'thanh_tien' => $totalAmount,
                'thanhvien_id' => $user->id_thanhvien,
                'trang_thai' => 'cho_xu_ly',
                'ngay_tao' => now(),
                'ngay_cap_nhat' => now()
            ]);

            DB::commit();

            return redirect()->route('card')->with('payment_success', true)->with('ma_don', $maDon);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
