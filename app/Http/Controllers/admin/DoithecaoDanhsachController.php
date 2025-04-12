<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDanhsach;
use App\Models\DoithecaoNhacungcap;

class DoithecaoDanhsachController extends Controller
{
    public function index()
    {
        
        $danhsach = DoithecaoDanhsach::with('nhacungcap')->get();
        return view('admin.doithecao.danhsach.doithecao_danhsach', compact('danhsach'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        $nhacungcaps = DoithecaoNhacungcap::all();
        return view('admin.doithecao.danhsach.doithecao_danhsach_add', compact('nhacungcaps'));
    }

    // Xử lý thêm mới
    public function store(Request $request)
{
    $request->validate([
        'nhacungcap_id' => 'required',
        'menh_gia'      => 'required|numeric',
        'chiet_khau'    => 'required|numeric',
        'trang_thai'    => 'required|in:hoat_dong,da_huy,cho_xu_ly',
    ]);

    $statusMap = [
        'hoat_dong'   => 1,
        'da_huy'      => 0,
        'cho_xu_ly'   => 2,
    ];

    $data = [
        'nhacungcap_id' => $request->nhacungcap_id,
        'menh_gia'      => $request->menh_gia,
        'chiet_khau'    => $request->chiet_khau,
        'trang_thai'    => $statusMap[$request->trang_thai] ?? 0,
    ];

    DoithecaoDanhsach::create($data);

    return redirect()
        ->route('admin.doithecao.danhsach.index')
        ->with('success', 'Thêm sản phẩm thành công!');
}

    // Hiển thị form sửa
    public function edit($id)
    {
        $sanpham = DoithecaoDanhsach::findOrFail($id);
        $nhacungcaps = DoithecaoNhacungcap::all();

        return view('admin.doithecao.danhsach.doithecao_danhsach_edit', compact('sanpham', 'nhacungcaps'));
    }

    // Xử lý cập nhật
    public function update(Request $request, $id)
{
    $request->validate([
        'nhacungcap_id' => 'required',
        'menh_gia'      => 'required|numeric',
        'chiet_khau'    => 'required|numeric',
        'trang_thai'    => 'required|in:hoat_dong,da_huy,cho_xu_ly',
    ]);

    $statusMap = [
        'hoat_dong'   => 1,
        'da_huy'      => 0,
        'cho_xu_ly'   => 2,
    ];

    $data = [
        'nhacungcap_id' => $request->nhacungcap_id,
        'menh_gia'      => $request->menh_gia,
        'chiet_khau'    => $request->chiet_khau,
        'trang_thai'    => $statusMap[$request->trang_thai] ?? 0,
    ];

    $sanpham = DoithecaoDanhsach::findOrFail($id);
    $sanpham->update($data);

    return redirect()
        ->route('admin.doithecao.danhsach.index')
        ->with('success', 'Cập nhật thành công!');
}

    // Xóa sản phẩm
    public function destroy($id)
    {
        $sanpham = DoithecaoDanhsach::findOrFail($id);
        $sanpham->delete();

        return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
    }

    
}
