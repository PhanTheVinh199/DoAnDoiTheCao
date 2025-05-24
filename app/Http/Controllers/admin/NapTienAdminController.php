<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NapTien;

class NapTienAdminController extends Controller
{
    public function showHistory()
    {
        $dsNapTien = NapTien::getPaginatedHistory(10);
        return view('admin.nganhang.naptien.nganhang_naptien', compact('dsNapTien'));
    }

    public function approve(Request $request, $id)
    {
        try {
            $newStatus = $request->input('trang_thai');
            NapTien::approveTransaction($id, $newStatus);
            return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Trạng thái giao dịch đã được cập nhật.');
        } catch (\Exception $e) {
            return redirect()->route('admin.nganhang.naptien.index')->with('error', $e->getMessage());
        }
    }
}
