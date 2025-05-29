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
    $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();

    $danhsach = DoithecaoDanhsach::with('nhacungcap')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.doithecao.danhsach.doithecao_danhsach', [
        'danhsach' => $danhsach,
        'nhacungcap' => $nhacungcaps,
        'currentNccId' => $nhacungcaps->first()->id_nhacungcap ?? null,
    ]);
}

    public function create()
    {
        $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();
        return view('admin.doithecao.danhsach.doithecao_danhsach_add', compact('nhacungcaps'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'menh_gia' => mb_convert_kana($request->menh_gia, 'n'),
        ]);

        $messages = [
            'nhacungcap_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'nhacungcap_id.exists' => 'Nhà cung cấp không hợp lệ.',
            'menh_gia.required' => 'Vui lòng nhập mệnh giá.',
            'menh_gia.max' => 'Mệnh giá không quá 10 triệu VND.',
            'chiet_khau.required' => 'Vui lòng nhập chiết khấu.',
            'chiet_khau.numeric' => 'Chiết khấu phải là số.',
            'chiet_khau.min' => 'Chiết khấu phải từ 0 trở lên.',
            'chiet_khau.max' => 'Chiết khấu không được vượt quá 100.',
            'trang_thai.required' => 'Vui lòng chọn trạng thái.',
            'trang_thai.in' => 'Trạng thái không hợp lệ.',
        ];

        $validated = $request->validate([
            'nhacungcap_id' => 'required|exists:doithecao_nhacungcap,id_nhacungcap',
            'menh_gia' => ['required', 'string', function ($attribute, $value, $fail) {
                $valueHalfWidth = mb_convert_kana($value, 'n');
                if (!is_numeric($valueHalfWidth)) {
                    $fail('Trường ' . $attribute . ' phải là số hợp lệ.');
                }
            }],
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|integer|in:0,1,2',
        ], $messages);

        $validated['menh_gia'] = mb_convert_kana($validated['menh_gia'], 'n');

        $exists = DoithecaoDanhsach::where('nhacungcap_id', $validated['nhacungcap_id'])
            ->where('menh_gia', $validated['menh_gia'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->withErrors([
                'duplicate' => 'Sản phẩm đã tồn tại với nhà cung cấp và mệnh giá này.'
            ]);
        }

        try {
            DoithecaoDanhsach::createProduct($validated);

            \Log::info('Tạo sản phẩm thành công:', $validated);

            return redirect()->route('admin.doithecao.danhsach.index', ['nhacungcap_id' => $validated['nhacungcap_id']])
                ->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi thêm sản phẩm: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'error' => 'Có lỗi xảy ra khi thêm sản phẩm. Vui lòng thử lại.'
            ]);
        }
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
            'menh_gia' => 'required|numeric|min:10000|max:10000000',
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|numeric|in:0,1,2',
            'updated_at' => 'required',
        ]);

        $currentUpdatedAt = $product->updated_at ? $product->updated_at->toDateTimeString() : null;
        if ($validated['updated_at'] !== $currentUpdatedAt) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['concurrency' => 'Sản phẩm đã được cập nhật từ tab khác. Vui lòng tải lại trang trước khi sửa.']);
        }

        unset($validated['updated_at']);

        DoithecaoDanhsach::updateProduct($id, $validated);

        return redirect()->route('admin.doithecao.danhsach.index', ['nhacungcap_id' => $validated['nhacungcap_id']])
            ->with('success', 'Cập nhật thành công!');
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
