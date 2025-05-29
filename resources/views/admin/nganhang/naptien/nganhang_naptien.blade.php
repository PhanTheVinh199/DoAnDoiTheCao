@include('admin.sidebar')

<!-- CSS và các link ... -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    .status-badge {
        padding: 0.5em 1em;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .status-badge.cho_duyet {
        background: linear-gradient(45deg, #ffc107, #ffdb4d);
        color: #000;
        border: none;
    }

    .status-badge.da_duyet {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        border: none;
    }

    .status-badge.huy {
        background: linear-gradient(45deg, #dc3545, #f86077);
        color: white;
        border: none;
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 2.5rem;
        border-radius: 20px;
    }

    .search-box .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 mb-0">Lịch sử Nạp</h1>
                    <div class="search-box" style="width: 300px;">
                        <form action="{{ route('admin.nganhang.naptien.index') }}" method="GET">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="ma_don" placeholder="Tìm kiếm mã đơn..." class="form-control" value="{{ request()->input('ma_don') }}">
                        </form>
                    </div>
                </div>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã Đơn</th>
                            <th>Tên Đăng Nhập</th>
                            <th>Số Tiền Nạp</th>
                            <th>Nội Dung</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dsNapTien as $item)
                            <tr>
                                <td>{{ $item->id_lichsunap }}</td>
                                <td>{{ $item->ma_don }}</td>
                                <td>{{ optional($item->thanhvien)->tai_khoan }}</td>
                                <td>{{ number_format($item->so_tien_nap, 0, ',', '.') }} đ</td>
                                <td>{{ $item->noi_dung }}</td>
                                <td>{{ $item->ngay_tao }}</td>
                                <td>
                                    @if ($item->trang_thai == 'cho_duyet')
                                        <span class="status-badge cho_duyet">
                                            <i class="fas fa-clock me-1"></i> Chờ Phê Duyệt
                                        </span>
                                    @elseif($item->trang_thai == 'da_duyet')
                                        <span class="status-badge da_duyet">
                                            <i class="fas fa-check me-1"></i> Đã Duyệt
                                        </span>
                                    @elseif($item->trang_thai == 'huy')
                                        <span class="status-badge huy">
                                            <i class="fas fa-times me-1"></i> Đã Hủy
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.nganhang.naptien.edit', $item->id_lichsunap) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.nganhang.naptien.delete', $item->id_lichsunap) }}" method="POST" class="d-inline delete-form" data-id="{{ $item->id_lichsunap }}" data-madon="{{ $item->ma_don }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" {{ $item->trang_thai === 'da_duyet' ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end pt-3">
                    {{ $dsNapTien->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Xác nhận xóa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 4rem;"></i>
                </div>
                <p id="confirmMessage" class="h5 mb-3"></p>
                <p class="text-muted">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy
                </button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">
                    <i class="fas fa-trash-alt me-2"></i>Xóa
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
  const confirmMessage = document.getElementById('confirmMessage');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  let currentForm = null;

  // Xử lý xác nhận xóa
  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      currentForm = this;
      const id = this.dataset.id;
      const maDon = this.dataset.madon;

      try {
        const response = await fetch(`/admin/nganhang/naptien/check/${id}`);
        const data = await response.json();

        if (!data.exists) {
          await Swal.fire({
            title: 'Lỗi!',
            text: 'Đơn nạp này đã bị xóa hoặc không tồn tại!',
            icon: 'error',
            confirmButtonText: 'Đóng'
          });
          location.reload();
          return;
        }

        confirmMessage.innerHTML = `Bạn có chắc chắn muốn xóa đơn nạp<br><strong class="text-danger">"${maDon}"</strong>?`;
        confirmModal.show();

      } catch (error) {
        console.error(error);
        Swal.fire({
          title: 'Lỗi!',
          text: 'Có lỗi xảy ra, vui lòng thử lại!',
          icon: 'error',
          confirmButtonText: 'Đóng'
        });
      }
    });
  });

  confirmDeleteBtn.addEventListener('click', function () {
    if (!currentForm) return;
    currentForm.submit();
  });

  // Xử lý form sửa với id="editNapTienForm"
  const editForm = document.querySelector('#editNapTienForm');
  if (editForm) {
    editForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      const id = this.dataset.id;
      const updatedAt = this.querySelector('input[name="updated_at"]').value;

      try {
        let resExist = await fetch(`/admin/nganhang/naptien/check/${id}`);
        let dataExist = await resExist.json();
        if (!dataExist.exists) {
          await Swal.fire({
            title: 'Lỗi!',
            text: 'Đơn nạp này đã bị xóa hoặc không còn tồn tại, vui lòng tải lại trang!',
            icon: 'error',
            confirmButtonText: 'Đóng'
          });
          window.location.href = '/admin/nganhang/naptien';
          return;
        }

        let resUpdated = await fetch(`/admin/nganhang/naptien/updated_at_check/${id}`);
        let dataUpdated = await resUpdated.json();

        if (dataUpdated.updated_at !== updatedAt) {
          await Swal.fire({
            title: 'Lỗi!',
            text: 'Dữ liệu đã được sửa bởi người khác. Vui lòng tải lại trang để cập nhật dữ liệu mới nhất!',
            icon: 'error',
            confirmButtonText: 'Đóng'
          });
          location.reload();
          return;
        }

        this.submit();

      } catch (error) {
        console.error(error);
        Swal.fire({
          title: 'Lỗi!',
          text: 'Có lỗi xảy ra, vui lòng thử lại!',
          icon: 'error',
          confirmButtonText: 'Đóng'
        });
      }
    });
  }

  // Hiển thị thông báo flash session bằng SweetAlert2
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Thành công',
      text: "{{ session('success') }}",
      timer: 2500,
      timerProgressBar: true,
      showConfirmButton: false,
      position: 'center'
    });
  @endif

  @if(session('error'))
    Swal.fire({
      icon: 'error',
      title: 'Lỗi',
      text: "{{ session('error') }}",
      timer: 3500,
      timerProgressBar: true,
      showConfirmButton: true,
      position: 'center'
    });
  @endif

  @if($errors->any())
    let errorMessages = '';
    @foreach ($errors->all() as $error)
      errorMessages += "{{ $error }}<br/>";
    @endforeach

    Swal.fire({
      icon: 'error',
      title: 'Lỗi',
      html: errorMessages,
      showConfirmButton: true,
      position: 'center'
    });
  @endif
});
</script>
