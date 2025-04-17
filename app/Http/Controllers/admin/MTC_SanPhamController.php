<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_NhaCungCap;
use App\Models\MaThe_SanPham;

class MTC_SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dsSanPham = MaThe_SanPham::orderBy('ngay_tao', 'desc')->paginate(10);
        $dsNhaCungCap = MaThe_NhaCungCap::all();
        return view('admin.mathecao.loaima.mathecao_danhsach', compact('dsSanPham','dsNhaCungCap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dsNhaCungCap = MaThe_NhaCungCap::all(); // Lấy tất cả nhà cung cấp
        return view('admin.mathecao.loaima.mathecao_danhsach_add', compact('dsNhaCungCap'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nhacungcap_id' => 'required|exists:mathecao_nhacungcap,id_nhacungcap',
            'menh_gia' => 'required|numeric|min:1000',
            'chiet_khau' => 'required|numeric|min:0|max:100',
        ]);
    
        MaThe_SanPham::create([
            'nhacungcap_id' => $request->nhacungcap_id,
            'menh_gia' => $request->menh_gia,
            'chiet_khau' => $request->chiet_khau,
        ]);
    
        return redirect()->route('admin.mathecao.loaima.index')->with('success', 'Thêm thẻ cào thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dsSanPham = MaThe_SanPham::findOrFail($id);
        $dsNhaCungCap = MaThe_NhaCungCap::all();
        return view('admin.mathecao.loaima.mathecao_danhsach_edit', compact('dsSanPham','dsNhaCungCap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'menh_gia' => 'required|numeric|min:1000',
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|in:Hoạt động,Ẩn',
            
        ]);
    
        $dsSanPham = MaThe_SanPham::findOrFail($id);
        $dsSanPham->update([
            'menh_gia' => $request->menh_gia,
            'chiet_khau' => $request->chiet_khau,
            'trang_thai' => $request->trang_thai,
        ]);
    
        return redirect()->route('admin.mathecao.loaima.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sanpham = MaThe_SanPham::findOrFail($id);

        // Xóa ảnh nếu có
        if ($sanpham->hinhanh && file_exists(public_path($sanpham->hinhanh))) {
            unlink(public_path($sanpham->hinhanh));
        }
    
        // Xóa dữ liệu
        $sanpham->delete();
    
        return redirect()->route('admin.mathecao.loaima.index')->with('success', 'Xóa thành công!');
    }
}
