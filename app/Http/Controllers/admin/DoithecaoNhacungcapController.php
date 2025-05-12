<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoNhacungcap;
use Illuminate\Support\Facades\File;

class DoithecaoNhacungcapController extends Controller
{
    protected $uploadPath = 'uploads/nhacungcap';  // Đường dẫn lưu ảnh

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

        $data = [
            'ten' => $request->ten,
            'trang_thai' => 'hoat_dong'
        ];

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Tạo thư mục nếu chưa tồn tại
            if (!File::exists(public_path($this->uploadPath))) {
                File::makeDirectory(public_path($this->uploadPath), 0777, true);
            }

            // Di chuyển file vào thư mục uploads
            $file->move(public_path($this->uploadPath), $fileName);

            // Lưu đường dẫn tương đối vào database
            $data['hinh_anh'] = $this->uploadPath . '/' . $fileName;
        }

        DoithecaoNhacungcap::create($data);

        return redirect()->route('admin.doithecao.nhacungcap.index')
            ->with('success', 'Thêm nhà cung cấp thành công!');
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

        $nhacungcap = DoithecaoNhacungcap::findOrFail($id);

        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu có
            if ($nhacungcap->hinh_anh && File::exists(public_path($nhacungcap->hinh_anh))) {
                File::delete(public_path($nhacungcap->hinh_anh));
            }

            // Lưu ảnh mới
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Tạo thư mục nếu chưa tồn tại
            if (!File::exists(public_path($this->uploadPath))) {
                File::makeDirectory(public_path($this->uploadPath), 0777, true);
            }

            // Di chuyển file vào thư mục uploads
            $file->move(public_path($this->uploadPath), $fileName);

            // Cập nhật đường dẫn mới
            $nhacungcap->hinh_anh = $this->uploadPath . '/' . $fileName;
        }

        $nhacungcap->ten = $request->ten;
        $nhacungcap->save();

        return redirect()->route('admin.doithecao.nhacungcap.index')
            ->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    public function destroy($id)
    {
        $nhacungcap = DoithecaoNhacungcap::findOrFail($id);

        // Xóa file ảnh khi xóa record
        if ($nhacungcap->hinh_anh && File::exists(public_path($nhacungcap->hinh_anh))) {
            File::delete(public_path($nhacungcap->hinh_anh));
        }

        $nhacungcap->delete();

        return redirect()->route('admin.doithecao.nhacungcap.index')
            ->with('success', 'Xoá nhà cung cấp thành công!');
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
