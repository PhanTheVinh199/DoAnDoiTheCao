<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoNhacungcap;

class DoithecaoNhacungcapController extends Controller
{
    public function index()
    {
        $nhacungcaps = DoithecaoNhacungcap::paginate(10);
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap', compact('nhacungcaps'));
    }

    public function create()
    {
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DoithecaoNhacungcap::createSupplier($request->all(), $request->file('hinh_anh'));

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Thêm nhà cung cấp thành công!');
    }

    public function edit($id)
    {
        $nhacungcap = DoithecaoNhacungcap::findOrFail($id);
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_edit', compact('nhacungcap'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DoithecaoNhacungcap::updateSupplier($id, $request->all(), $request->file('hinh_anh'));

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    public function destroy($id)
    {
        DoithecaoNhacungcap::deleteSupplier($id);

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Xoá nhà cung cấp thành công!');
    }

    public function hide($id)
    {
        DoithecaoNhacungcap::hideSupplier($id);
        return redirect()->back()->with('success', 'Đã ẩn nhà cung cấp!');
    }

    public function show($id)
    {
        DoithecaoNhacungcap::showSupplier($id);
        return redirect()->back()->with('success', 'Đã hiện nhà cung cấp!');
    }
}
