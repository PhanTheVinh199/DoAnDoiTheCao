<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoNhacungcap;

class DoithecaoNhacungcapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nhacungcaps = DoithecaoNhacungcap::all();
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap', compact('nhacungcaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->only('ten');

        if ($request->hasFile('hinh_anh')) {
            $image = $request->file('hinh_anh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads', $imageName); // lưu vào storage/app/public/uploads
            $data['hinh_anh'] =   $imageName;
        }

        DoithecaoNhacungcap::create($data);

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Thêm nhà cung cấp thành công!');
    }

    public function edit($id)
    {
        $nhacungcap = DoiTheCaoNhacungcap::findOrFail($id);
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_edit', compact('nhacungcap'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $nhacungcap = DoiTheCaoNhaCungCap::findOrFail($id);
    
        if ($request->hasFile('hinh_anh')) {
            $imagePath = $request->file('hinh_anh')->store('logos', 'public');
            $nhacungcap->hinh_anh = $imagePath;
        }
    
        $nhacungcap->ten = $validatedData['ten'];
        $nhacungcap->save();
    
        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $nhacungcap = DoithecaoNhacungcap::findOrFail($id);
        $nhacungcap->delete();

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Xoá nhà cung cấp thành công!');
    }

    public function hide($id)
    {   
        $nhacungcap = DoithecaoNhacungcap::findOrFail($id);
        $nhacungcap->trang_thai = 'an';
        $nhacungcap->save();

        return redirect()->back()->with('success', 'Đã ẩn nhà cung cấp!');
    }

    public function show($id)
    {
        $nhacungcap = DoithecaoNhacungcap::findOrFail($id);
        $nhacungcap->trang_thai = 'hoat_dong';
        $nhacungcap->save();

        return redirect()->back()->with('success', 'Đã hiện nhà cung cấp!');
    }
}
