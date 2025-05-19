<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NapTien;

class NapTienController extends Controller
{
    public function showForm()
    {
        if (!Auth::guard('thanhvien')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
        }

        $user = Auth::guard('thanhvien')->user();

        $transactions = NapTien::getPaginatedHistory($user->id_thanhvien);

        $banks = \App\Models\NganhangAdmin::where('trang_thai', 'hoat_dong')->get();

        $hanMucNgay = 100000000;
        $soTienToiThieu = 10000;
        $soTienToiDa = 10000000;

        return view('naptien', compact('hanMucNgay', 'soTienToiThieu', 'soTienToiDa', 'banks', 'transactions'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('thanhvien')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
        }

        $user = Auth::guard('thanhvien')->user();

        $data = $request->validate([
            'net_amount' => 'required|numeric|min:10000|max:10000000',
            'paygate_code' => 'required|string|exists:nganhang,id_danhsach',
        ]);

        $data['thanhvien_id'] = $user->id_thanhvien;
        $data['so_tien_nap'] = $data['net_amount'];
        unset($data['net_amount']);
        $data['han_muc_ngay'] = 100000000;

        try {
            $order = NapTien::createDeposit($data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('order.show', ['id' => $order->id_lichsunap]);
    }

    public function showHistory()
    {
        $user = Auth::guard('thanhvien')->user();
        $transactions = NapTien::getPaginatedHistory($user->id_thanhvien);
        return view('lichsunap', compact('transactions'));
    }
}
