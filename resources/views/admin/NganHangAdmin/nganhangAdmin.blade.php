@include('admin.sidebar')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    /* Notification styles */
    #notification-container {
        min-width: 300px;
        max-width: 500px;
    }

    #notification-container .alert {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        animation: slideInDown 0.5s ease forwards;
    }

    .alert-success {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
    }

    .alert-danger {
        background: linear-gradient(45deg, #dc3545, #f86077);
        border: none;
        color: white;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Delete confirmation modal styles */
    .modal-content {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        animation: modalFadeIn 0.3s ease-out;
    }
</style>

<div class="container" style="margin-top: 10px; padding: 30px">
    <div class="row d-flex">
        <div class="bg-white p-3 rounded shadow">
            <h1>Danh Sách Ngân Hàng Admin</h1>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <a href="{{ route('admin.nganhang.admin.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm Ngân Hàng Admin
                </a>
            </div>

            <form method="GET" action="{{ route('admin.nganhang.admin.index') }}" class="mb-3 d-flex">
                <input type="text" name="search" placeholder="Tìm kiếm..." class="form-control me-2" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
            </form>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên ngân hàng</th>
                        <th>Số tài khoản</th>
                        <th>Chủ tài khoản</th>
                        <th>Trạng thái</th>
                        <th>Admin liên kết</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banks as $bank)
                    <tr id="bank-row-{{ $bank->id_danhsach }}">
                        <td>{{ $bank->id_danhsach }}</td>
                        <td>{{ $bank->ten_ngan_hang }}</td>
                        <td>{{ $bank->so_tai_khoan }}</td>
                        <td>{{ $bank->chu_tai_khoan }}</td>
                        <td>
                            <span class="badge {{ $bank->trang_thai == 'hoat_dong' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $bank->trang_thai)) }}
                            </span>
                        </td>
                        <td>{{ $bank->thanhvien->tai_khoan ?? 'N/A' }}</td>
                        <td>
                            <form action="{{ route('admin.nganhang.admin.delete', $bank->id_danhsach) }}"
                                  method="POST"
                                  class="d-inline delete-form"
                                  data-id="{{ $bank->id_danhsach }}"
                                  data-name="{{ $bank->ten_ngan_hang }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có ngân hàng admin nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end pt-5">
                {{ $banks->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>

<!-- jQuery & SweetAlert2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('.delete-btn').click(function(e) {
        e.preventDefault();

        var $form = $(this).closest('form');
        var bankId = $form.data('id');
        var bankName = $form.data('name');
        var deleteUrl = $form.attr('action');

        Swal.fire({
            title: `Bạn có chắc muốn xóa ngân hàng "${bankName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Có, xóa ngay!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Xóa thành công!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Xóa dòng tương ứng trong bảng mà không reload trang
                        $('#bank-row-' + bankId).fadeOut(800, function() {
                            $(this).remove();
                            // Nếu hết bản ghi trong bảng, thêm row thông báo
                            if ($('tbody tr').length == 0) {
                                $('tbody').append('<tr><td colspan="7" class="text-center">Không có ngân hàng admin nào.</td></tr>');
                            }
                        });
                    },
                    error: function(xhr) {
    let errorMessage = 'Có lỗi xảy ra khi xóa.';
    if (xhr.status === 404) {
        errorMessage = 'Ngân hàng này đã bị xóa trước đó hoặc không tồn tại.';
    } else if (xhr.responseJSON && xhr.responseJSON.message) {
        errorMessage = xhr.responseJSON.message;
    }
    Swal.fire({
        icon: 'error',
        title: 'Lỗi!',
        text: errorMessage,
        confirmButtonText: 'OK'
    }).then(() => {
        // Reload lại trang khi nhấn OK để reset trạng thái
        location.reload();
    });
}
                });
            }
        });
    });
});
</script>
