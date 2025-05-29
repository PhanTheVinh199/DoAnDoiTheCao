<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use App\Models\NganHang;
use App\Models\RutTien;
use App\Models\NapTien;

class NganhangController extends Controller
{
    // Hiển thị danh sách ngân hàng, hỗ trợ tìm kiếm
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dsNganHang = NganHang::getBanks($search, 5);
        $query = NganHang::orderBy('created_at', 'desc');

        $page = $request->query('page');

        if (!is_null($page)) {
            if (!ctype_digit($page) || $page < 1 || $page > $dsNganHang->lastPage()) {
                return redirect()->route('admin.nganhang.index')
                    ->with('error', 'Trang không hợp lệ!');
            }
        }
        return view('admin.nganhang.danhsach.nganhang', compact('dsNganHang'));
    }

    // Xóa ngân hàng theo id
    public function delete_nganhang($id)
    {
        try {
            NganHang::deleteBank($id);
            return redirect()->route('admin.nganhang.index')->with('success', 'Đã xóa ngân hàng thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.index')->with('error', 'Ngân hàng không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.nganhang.index')->with('error', 'Lỗi khi xóa ngân hàng.');
        }
    }

    // Danh sách lịch sử rút tiền có tìm kiếm
    public function ruttien(Request $request)
    {
        $search = $request->input('search');
        $dsRutTien = NganHang::getRutTiens($search, 5);
        $query = NganHang::orderBy('created_at', 'desc');

        $page = $request->query('page');

        if (!is_null($page)) {
            if (!ctype_digit($page) || $page < 1 || $page > $dsRutTien->lastPage()) {
                return redirect()->route('admin.nganhang.ruttien.index')
                    ->with('error', 'Trang không hợp lệ!');
            }
        }
        return view('admin.nganhang.ruttien.nganhang_ruttien', compact('dsRutTien'));
    }

    // Xóa lịch sử rút tiền theo id
    public function destroyRutTien($id)
    {
         try {
            NganHang::deleteRutTien($id);
            return redirect()->route('admin.nganhang.ruttien.index')->with('success', 'Đã xóa lịch sử rút tiền thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lịch sử rút tiền không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lỗi khi xóa lịch sử rút tiền.');
        }
    }

    // Form sửa lịch sử rút tiền
    public function editRutTien($id)
    {
        try {
            $rutTien = RutTien::findOrFail($id);
            return view('admin.nganhang.ruttien.nganhang_ruttien_edit', compact('rutTien'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lịch sử rút tiền không tồn tại hoặc đã bị xóa.');
        }
    }

    // Cập nhật lịch sử rút tiền (có kiểm tra optimistic locking)
    public function updateRutTien(Request $request, $id)
    {
        $data = $request->validate([
            'trang_thai' => 'required|in:cho_duyet,da_duyet,huy',
            'updated_at' => 'nullable',
        ]);

        try {
            $rutTien = RutTien::findOrFail($id);

            if ($request->has('updated_at')) {
                $formUpdatedAt = Carbon::parse($request->input('updated_at'));
                $dbUpdatedAt = $rutTien->updated_at;

                if (!$dbUpdatedAt->equalTo($formUpdatedAt)) {
                    return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Dữ liệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang.');
                }
            }

            $rutTien->trang_thai = $data['trang_thai'];
            $rutTien->save();

            return redirect()->route('admin.nganhang.ruttien.index')->with('success', 'Cập nhật thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lịch sử rút tiền không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
        }
    }

    // Danh sách lịch sử nạp tiền có tìm kiếm
    public function naptien(Request $request)
    {
        $search = $request->input('ma_don');
        $dsNapTien = NganHang::getNapTiens($search, 5);
        $query = NganHang::orderBy('created_at', 'desc');

        $page = $request->query('page');

        if (!is_null($page)) {
            if (!ctype_digit($page) || $page < 1 || $page > $dsNapTien->lastPage()) {
                return redirect()->route('admin.nganhang.naptien.index')
                    ->with('error', 'Trang không hợp lệ!');
            }
        }
        return view('admin.nganhang.naptien.nganhang_naptien', compact('dsNapTien'));
    }

    // Xóa lịch sử nạp tiền theo id, check trạng thái và transaction
    public function destroyNapTien($id)
    {
        DB::beginTransaction();
        try {
            $napTien = NapTien::lockForUpdate()->find($id);

            if (!$napTien) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Đơn nạp không tồn tại hoặc đã bị xóa.');
            }

            if ($napTien->trang_thai === 'da_duyet') {
                DB::rollBack();
                return redirect()->back()->with('error', 'Không thể xóa giao dịch đã duyệt.');
            }

            $napTien->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Xóa đơn nạp thành công.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đơn nạp không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi xóa đơn nạp: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa đơn nạp.');
        }
    }

    // Form sửa đơn nạp tiền
    public function editNapTien($id)
    {
        try {
            $napTien = NapTien::findOrFail($id);
            return view('admin.nganhang.naptien.nganhang_naptien_edit', compact('napTien'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.naptien.index')->with('error', 'Đơn nạp tiền không tồn tại hoặc đã bị xóa.');
        }
    }

    // Cập nhật đơn nạp tiền (có kiểm tra optimistic locking)
    public function updateNapTien(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $napTien = NapTien::lockForUpdate()->find($id);
            if (!$napTien) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Đơn nạp tiền không tồn tại hoặc đã bị xóa.');
            }

            // Kiểm tra optimistic locking với updated_at
            if ($request->input('updated_at') !== $napTien->updated_at->toDateTimeString()) {
                DB::rollBack();
                return redirect()->back()->withErrors('Dữ liệu đã được thay đổi bởi người khác. Vui lòng tải lại trang để cập nhật dữ liệu mới nhất.');
            }

            $validated = $request->validate([
                'so_tien_nap' => 'required|numeric',
                'noi_dung' => 'nullable|string',
                'trang_thai' => 'required|in:cho_duyet,da_duyet,huy',
            ]);

            // Giữ ma_don cố định từ bản ghi hiện tại hoặc tạo mới UUID nếu không có
            $validated['ma_don'] = $napTien->ma_don ?? $request->ma_don ?? \Illuminate\Support\Str::uuid();

            $napTien->update($validated);

            DB::commit();

            return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Cập nhật thành công');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đơn nạp không tồn tại hoặc đã bị xóa');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi cập nhật đơn nạp: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi khi cập nhật đơn nạp.');
        }
    }

    // Hiển thị form tạo ngân hàng
    public function create()
    {
        $banks = NganHang::all();
        return view('admin.nganhang.caidat_nganhang.caidat_nganhang', compact('banks'));
    }

    // Thêm ngân hàng mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_thanhvien' => 'required|string',
            'ten_ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:100',
            'chu_tai_khoan' => 'required|string|max:100',
            'trang_thai' => 'nullable|boolean',
        ]);

        try {
            NganHang::createBank($validated);
            return redirect()->route('admin.nganhang.index')->with('success', 'Thêm ngân hàng thành công!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    // API kiểm tra tồn tại đơn nạp tiền (dùng cho Ajax)
    public function checkNapTienExists($id)
    {
        try {
            $exists = NapTien::where('id_lichsunap', $id)->exists();
            return response()->json(['exists' => $exists]);
        } catch (\Exception $e) {
            \Log::error('Error checking deposit existence: ' . $e->getMessage());
            return response()->json(['exists' => false]);
        }
    }

    // API kiểm tra updated_at (dùng cho optimistic locking)
    public function checkUpdatedAt($id)
    {
        $napTien = NapTien::find($id);
        if (!$napTien) {
            return response()->json(['updated_at' => null]);
        }
        return response()->json(['updated_at' => $napTien->updated_at->toDateTimeString()]);
    }
}

