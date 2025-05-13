<?php

namespace App\Http\Controllers\Admin;

use App\Models\NapTien;
use App\Models\ThanhVien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NapTienAdminController extends Controller
{
    // Hiển thị tất cả các giao dịch nạp tiền
    public function showHistory()
    {
        // Lấy tất cả các giao dịch nạp tiền từ database, sắp xếp theo thời gian tạo mới nhất
        $transactions = NapTien::latest()->paginate(10); // Sử dụng phân trang để giảm tải
        return view('admin.naptien', compact('transactions'));
    }

    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $transaction = NapTien::find($id);
            
            if (!$transaction) {
                return redirect()->back()->with('error', 'Giao dịch không tồn tại.');
            }

            // Check if transaction is already approved
            if ($transaction->trang_thai === 'da_duyet') {
                return redirect()->back()->with('error', 'Giao dịch đã được duyệt trước đó.');
            }

            // Update transaction status
            $transaction->trang_thai = 'da_duyet';
            $transaction->save();

            // Update user balance
            $user = ThanhVien::find($transaction->thanhvien_id);
            if (!$user) {
                throw new \Exception('Không tìm thấy thông tin người dùng');
            }

            $user->so_du += $transaction->so_tien_nap;
            $user->save();

            DB::commit();
            
            return redirect()->route('admin.naptien.index')
                ->with('success', 'Giao dịch đã được duyệt và số dư đã được cập nhật.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi duyệt nạp tiền: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi duyệt giao dịch.');
        }
    }
}
