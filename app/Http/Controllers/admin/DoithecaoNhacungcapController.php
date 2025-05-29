<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoNhacungcap;

class DoithecaoNhacungcapController extends Controller
{
    public function index(Request $request)
    {
        $query = DoithecaoNhacungcap::query();

        $page = $request->query('page', 1);

        if (!ctype_digit(strval($page)) || intval($page) < 1) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Tham số trang không hợp lệ.');
        }

        $perPage = 10;
        $nhacungcaps = $query->paginate($perPage);

        // Kiểm tra nếu page request vượt max page
        $lastPage = $nhacungcaps->lastPage();
        if (intval($page) > $lastPage && $lastPage > 0) {
            return redirect()->route('admin.doithecao.nhacungcap.index', ['page' => $lastPage])
                ->with('error', 'Trang bạn yêu cầu vượt quá số trang tối đa.');
        }

        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap', compact('nhacungcaps'));
    }

    public function create()
    {
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => [
                'required',
                'string',
                'max:255',
                'unique:doithecao_nhacungcap,ten',
                function ($attribute, $value, $fail) {
                    if (trim(preg_replace('/\s+/u', '', $value)) === '') {
                        $fail('Trường ' . $attribute . ' không được để khoảng trắng hoặc trống.');
                    }
                },
            ],
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trang_thai' => 'required|in:hoat_dong,an',
        ], [
            'ten.required' => 'Tên nhà cung cấp không được để trống.',
            'ten.max' => 'Tên nhà cung cấp không được dài quá 255 ký tự.',
            'ten.unique' => 'Tên nhà cung cấp đã tồn tại, vui lòng chọn tên khác.',
            'hinh_anh.image' => 'File tải lên phải là hình ảnh.',
            'hinh_anh.mimes' => 'Ảnh chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, svg.',
            'hinh_anh.max' => 'Kích thước ảnh tối đa 2MB.',
            'trang_thai.in' => 'Trạng thái không hợp lệ.',
        ]);

        $tenClean = strip_tags($validated['ten']);

        $nhacungcap = new DoithecaoNhacungcap();
        $nhacungcap->ten = $tenClean;
        $nhacungcap->trang_thai = $validated['trang_thai'];

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $filename);

            $nhacungcap->hinh_anh = 'uploads/' . $filename;
        }

        $nhacungcap->save();

        return redirect()->route('admin.doithecao.nhacungcap.index')
            ->with('success', 'Thêm nhà cung cấp thành công!');
    }

    public function edit($id)
    {
        if (!ctype_digit($id) || intval($id) < 1) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'ID không hợp lệ hoặc không tìm thấy nhà cung cấp.');
        }

        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Không tìm thấy nhà cung cấp.');
        }

        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_edit', compact('nhacungcap'));
    }

    public function update(Request $request, $id)
    {
        if (!ctype_digit(strval($id)) || intval($id) < 1) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'ID không hợp lệ hoặc không tìm thấy nhà cung cấp.');
        }

        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Không tìm thấy nhà cung cấp.');
        }

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'ten' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('doithecao_nhacungcap', 'ten')->ignore($id, 'id_nhacungcap'),
                function ($attribute, $value, $fail) {
                    if (trim(preg_replace('/\s+/u', '', $value)) === '') {
                        $fail('Trường ' . $attribute . ' không được để khoảng trắng hoặc trống.');
                    }
                },
            ],
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trang_thai' => 'required|in:hoat_dong,an',
            'updated_at' => 'nullable|string',
        ], [
            'ten.required' => 'Tên nhà cung cấp không được để trống.',
            'ten.max' => 'Tên nhà cung cấp không được dài quá 255 ký tự.',
            'ten.unique' => 'Tên nhà cung cấp đã tồn tại.',
            'hinh_anh.image' => 'File tải lên phải là hình ảnh.',
            'hinh_anh.mimes' => 'Ảnh chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, svg.',
            'hinh_anh.max' => 'Kích thước ảnh tối đa 2MB.',
            'trang_thai.in' => 'Trạng thái không hợp lệ.',
            'updated_at.required' => 'Dữ liệu không hợp lệ, vui lòng tải lại trang.',
        ]);

        // Kiểm tra concurrency updated_at
        $updatedAtInput = $request->input('updated_at');
        $updatedAtDB = $nhacungcap->updated_at ? $nhacungcap->updated_at->toDateTimeString() : null;

        if ($updatedAtInput && $updatedAtInput !== $updatedAtDB) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Dữ liệu đã được cập nhật bởi người khác. Vui lòng tải lại trang trước khi cập nhật.');
        }

        // Cập nhật dữ liệu
        $nhacungcap->ten = strip_tags($validated['ten']);
        $nhacungcap->trang_thai = $validated['trang_thai'];

        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($nhacungcap->hinh_anh) {
                $oldImagePath = public_path($nhacungcap->hinh_anh);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            $file = $request->file('hinh_anh');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $filename);

            $nhacungcap->hinh_anh = 'uploads/' . $filename;
        }
        // Nếu không upload file mới, giữ nguyên ảnh cũ

        $nhacungcap->save();

        return redirect()->route('admin.doithecao.nhacungcap.index')
            ->with('success', 'Cập nhật nhà cung cấp thành công!');
    }


    public function destroy(Request $request, $id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);

        if (!$nhacungcap) {
            return response()->json([
                'success' => false,
                'message' => 'Nhà cung cấp không tồn tại hoặc đã bị xóa.',
            ], 404);
        }

        $updatedAtDB = $nhacungcap->updated_at ? $nhacungcap->updated_at->toDateTimeString() : null;

        if ($request->has('updated_at') && $request->updated_at != $updatedAtDB) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đã bị thay đổi trước đó. Vui lòng tải lại trang.',
            ], 409);
        }

        try {
            $nhacungcap->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa nhà cung cấp thành công!',
            ]);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi xóa nhà cung cấp ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa nhà cung cấp.',
            ], 500);
        }
    }


    public function checkExists($id)
    {
        $exists = DoithecaoNhacungcap::where('id', $id)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function checkUpdatedAt($id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);

        if (!$nhacungcap) {
            return response()->json(['exists' => false]);
        }

        $updatedAt = $nhacungcap->updated_at ? $nhacungcap->updated_at->toDateTimeString() : null;

        return response()->json([
            'exists' => true,
            'updated_at' => $updatedAt,
        ]);
    }

    public function hide($id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp không tồn tại hoặc đã bị xóa.');
        }
        $nhacungcap->trang_thai = 'an';
        $nhacungcap->save();

        return redirect()->back()->with('success', 'Đã ẩn nhà cung cấp!');
    }

    public function show($id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp không tồn tại hoặc đã bị xóa.');
        }
        $nhacungcap->trang_thai = 'hoat_dong';
        $nhacungcap->save();

        return redirect()->back()->with('success', 'Đã hiện nhà cung cấp!');
    }

    // Kiểm tra trùng tên nhà cung cấp (có thể loại trừ ID hiện tại khi cập nhật)
    public function checkName(Request $request)
    {
        $ten = $request->query('ten');
        $excludeId = $request->query('exclude_id'); // id để loại trừ khi update

        $query = DoithecaoNhacungcap::where('ten', $ten);

        if ($excludeId) {
            $query->where('id_nhacungcap', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}
