<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDanhsach;
use Illuminate\Support\Facades\DB;

class DoithecaoDanhsachController extends Controller
{
    public function index(Request $request)
{
    $page = $request->query('page', 1);

    // Kiểm tra page phải là số và lớn hơn 0
    if (!ctype_digit((string)$page) || (int)$page <= 0) {
        return redirect()->route('admin.doithecao.danhsach.index')
            ->with('error', 'Trang bạn yêu cầu không tồn tại hoặc không hợp lệ.');
    }

    // Lấy tổng số trang (vd 10 item/trang)
    $perPage = 10;
    $totalItems = DoithecaoDanhsach::count();
    $maxPage = ceil($totalItems / $perPage);

    if ((int)$page > $maxPage && $totalItems > 0) {
        return redirect()->route('admin.doithecao.danhsach.index')
            ->with('error', 'Trang bạn yêu cầu vượt quá số trang hiện có.');
    }

    $danhsach = DoithecaoDanhsach::with('nhacungcap')
        ->paginate($perPage);

    $nhacungcap = DoithecaoDanhsach::getAllSuppliers();

    // Fix: Pass both variables to the view
    return view('admin.doithecao.danhsach.doithecao_danhsach', compact('danhsach', 'nhacungcap'));
}


    public function create()
    {
        $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();
        return view('admin.doithecao.danhsach.doithecao_danhsach_add', compact('nhacungcaps'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nhacungcap_id' => 'required|exists:doithecao_nhacungcap,id_nhacungcap',
        'menh_gia' => ['required', 'string', function($attribute, $value, $fail) {
            $valueHalfWidth = mb_convert_kana($value, 'n');
            if (!is_numeric($valueHalfWidth)) {
                $fail('Trường '.$attribute.' phải là số hợp lệ.');
            }
        }],
        'chiet_khau' => 'required|numeric|min:0|max:100',
        'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly', // validation ảnh
    ]);

    // Chuyển số full-width sang half-width
    $validated['menh_gia'] = mb_convert_kana($validated['menh_gia'], 'n');

    // Kiểm tra trùng lặp (nhà cung cấp + mệnh giá)
    $exists = DoithecaoDanhsach::where('nhacungcap_id', $validated['nhacungcap_id'])
        ->where('menh_gia', $validated['menh_gia'])
        ->exists();

    if ($exists) {
        return redirect()->back()->withInput()->withErrors(['duplicate' => 'Sản phẩm đã tồn tại với nhà cung cấp và mệnh giá này.']);
    }

    // Xử lý upload ảnh nếu có
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    DoithecaoDanhsach::createProduct($validated);

    return redirect()->route('admin.doithecao.danhsach.index')->with('success', 'Thêm sản phẩm thành công!');
}


    public function edit($id)
    {
        if (!ctype_digit($id)) {
        return redirect()->route('admin.doithecao.danhsach.index')
            ->with('error', 'ID không hợp lệ.');
    }

    $sanpham = DoithecaoDanhsach::find($id);
    if (!$sanpham) {
        return redirect()->route('admin.doithecao.danhsach.index')
            ->with('error', 'Sản phẩm không tồn tại.');
    }

    $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();
    return view('admin.doithecao.danhsach.doithecao_danhsach_edit', compact('sanpham', 'nhacungcaps'));

    }

    public function update(Request $request, $id)
    {
        $product = DoithecaoDanhsach::find($id);
        if (!$product) {
            return redirect()->route('admin.doithecao.danhsach.index')
                ->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        $validated = $request->validate([
            'nhacungcap_id' => 'required|exists:doithecao_nhacungcap,id_nhacungcap',
            'menh_gia' => 'required|numeric|min:0',
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
            'updated_at' => 'required',
        ]);

        // concurrency check
        $currentUpdatedAt = $product->updated_at ? $product->updated_at->toDateTimeString() : null;
        if ($validated['updated_at'] !== $currentUpdatedAt) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['concurrency' => 'Sản phẩm đã được cập nhật từ tab khác. Vui lòng tải lại trang trước khi sửa.']);
        }

        // Loại bỏ updated_at khỏi dữ liệu update
        $dataToUpdate = $validated;
        unset($dataToUpdate['updated_at']);

        DoithecaoDanhsach::updateProduct($id, $dataToUpdate);

        return redirect()->route('admin.doithecao.danhsach.index')->with('success', 'Cập nhật thành công!');
    }

    public function checkExists($id)
    {
        $exists = DoithecaoDanhsach::where('id_doithecao', $id)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function destroy(Request $request, $id)
{
    if (!$request->isMethod('delete')) {
        return response()->json([
            'success' => false,
            'message' => 'Phương thức xóa không hợp lệ.'
        ]);
    }

    DB::beginTransaction();
    try {
        $product = DoithecaoDanhsach::lockForUpdate()->find($id);

        if (!$product) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại hoặc đã bị xóa.'
            ]);
        }

        $product->delete();
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sản phẩm thành công.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Lỗi xóa sản phẩm ID ' . $id . ': ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi xóa sản phẩm.'
        ]);
    }
}

}
