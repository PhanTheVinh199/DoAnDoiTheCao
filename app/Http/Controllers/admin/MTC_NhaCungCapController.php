<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_NhaCungCap;

class MTC_NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dsNhaCungCap = MaThe_NhaCungCap::orderBy('ngay_tao', 'desc')->paginate(10);
        
        return view('admin.mathecao.nhacungcap.mathecao_nhacungcap', compact('dsNhaCungCap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mathecao.nhacungcap.mathecao_nhacungcap_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'hinhanh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý lưu ảnh
        if ($request->hasFile('hinhanh')) {
            $image = $request->file('hinhanh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $imgPath = 'uploads/' . $imageName;
        } else {
            $imgPath = null;
        }

        // Lưu vào DB
        MaThe_NhaCungCap::create([
            'ten' => $request->ten,
            'hinhanh' => $imgPath
        ]);

        return redirect()->route('admin.mathecao.nhacungcap.index')->with('success', 'Thêm thành công!');
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
        $ncc = MaThe_NhaCungCap::findOrFail($id);
        return view('admin.mathecao.nhacungcap.mathecao_nhacungcap_edit', compact('ncc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $ncc = MaThe_NhaCungCap::findOrFail($id);

        // Nếu người dùng upload ảnh mới
        if ($request->hasFile('hinhanh')) {
            $image = $request->file('hinhanh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $imgPath = 'uploads/' . $imageName;

            //Nếu có ảnh cũ thì bạn có thể xóa bằng cách:
            if ($ncc->hinhanh && file_exists(public_path($ncc->hinhanh))) {
                unlink(public_path($ncc->hinhanh));
            }

            $ncc->hinhanh = $imgPath;
        }

        $ncc->ten = $request->ten;
        $ncc->save();

        return redirect()->route('admin.mathecao.nhacungcap.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ncc = MaThe_NhaCungCap::findOrFail($id);

    // Xóa ảnh nếu có
    if ($ncc->hinhanh && file_exists(public_path($ncc->hinhanh))) {
        unlink(public_path($ncc->hinhanh));
    }

    // Xóa dữ liệu
    $ncc->delete();

    return redirect()->route('admin.mathecao.nhacungcap.index')->with('success', 'Xóa thành công!');
    }
}
