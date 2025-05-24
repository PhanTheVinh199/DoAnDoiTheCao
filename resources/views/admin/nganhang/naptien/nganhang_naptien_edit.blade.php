<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cập nhật Nạp Tiền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        body { background-color: rgb(107, 114, 128); }
    </style>
</head>
<body class="form">
    <div class="container py-4">
        <div class="bg-white rounded shadow p-4 mx-auto" style="max-width: 600px;">
            <h3 class="mb-4">Cập nhật Nạp Tiền</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif




            <form id="editNapTienForm" data-id="{{ $napTien->id_lichsunap }}" action="{{ route('admin.naptien.update', $napTien->id_lichsunap) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="updated_at" value="{{ $napTien->updated_at->toDateTimeString() }}">

                <div class="mb-3">
                    <label class="form-label">Mã Đơn</label>
                    <input type="text" class="form-control" value="{{ $napTien->ma_don }}" disabled />
                </div>

                <div class="mb-3">
                    <label class="form-label">Tên Đăng Nhập</label>
                    <input type="text" class="form-control" value="{{ optional($napTien->thanhvien)->tai_khoan }}" disabled />
                </div>

                <div class="mb-3">
                    <label class="form-label">Số Tiền Nạp</label>
                    <input type="number" class="form-control" value="{{ $napTien->so_tien_nap }}" readonly />
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội Dung</label>
                    <textarea class="form-control" rows="3" readonly>{{ $napTien->noi_dung }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng Thái</label>
                    <select name="trang_thai" class="form-select" required>
                        <option value="cho_duyet" {{ $napTien->trang_thai == 'cho_duyet' ? 'selected' : '' }}>Chờ Duyệt</option>
                        <option value="da_duyet" {{ $napTien->trang_thai == 'da_duyet' ? 'selected' : '' }}>Đã Duyệt</option>
                        <option value="huy" {{ $napTien->trang_thai == 'huy' ? 'selected' : '' }}>Hủy</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.naptien.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-danger">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const editForm = document.getElementById('editNapTienForm');
  if (!editForm) return;

  editForm.addEventListener('submit', async function (e) {
    e.preventDefault();

    const id = this.dataset.id;
    const updatedAtInput = this.querySelector('input[name="updated_at"]').value;

    try {
      // Kiểm tra tồn tại đơn nạp
      const existsRes = await fetch(`/admin/naptien/check/${id}`);
      const existsData = await existsRes.json();
      if (!existsData.exists) {
        await Swal.fire({
          icon: 'error',
          title: 'Lỗi',
          text: 'Đơn nạp tiền đã bị xóa hoặc không tồn tại.',
          confirmButtonText: 'Đóng'
        });
        window.location.href = '/admin/nganhang/naptien';
        return;
      }

      // Kiểm tra updated_at
      const updatedAtRes = await fetch(`/admin/naptien/updated_at_check/${id}`);
      const updatedAtData = await updatedAtRes.json();
      if (updatedAtData.updated_at !== updatedAtInput) {
        await Swal.fire({
          icon: 'error',
          title: 'Lỗi',
          text: 'Dữ liệu đã được sửa bởi người khác. Vui lòng tải lại trang.',
          confirmButtonText: 'Đóng'
        });
        location.reload();
        return;
      }

      // Nếu ok thì submit form
      this.submit();
    } catch (error) {
      console.error(error);
      Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: 'Có lỗi xảy ra, vui lòng thử lại!',
        confirmButtonText: 'Đóng'
      });
    }
  });
});
</script>

</body>
</html>
