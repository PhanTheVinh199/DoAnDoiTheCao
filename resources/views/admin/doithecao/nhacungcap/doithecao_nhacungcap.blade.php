<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhà Cung Cấp</title>

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Enhanced CSS Styles */
        .table {
            --bs-table-hover-bg: rgba(0, 0, 0, 0.02);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .delete-btn:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

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

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s ease-out;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: scale(0.95);
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .table img {
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .table img:hover {
            transform: scale(1.1);
        }

        .badge {
            padding: 0.5em 1em;
            border-radius: 30px;
            font-weight: 500;
        }

        .pagination {
            gap: 5px;
        }

        .page-link {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Animation keyframes */
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

        #confirmDeleteBtn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        #confirmDeleteBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        #confirmDeleteBtn:active {
            transform: translateY(0);
        }

        .btn-close-white {
            filter: brightness(0) invert(1);
        }

        .modal-header.bg-danger {
            background: linear-gradient(45deg, #dc3545, #ff4d5a);
        }

        .fas.fa-trash-alt {
            animation: wobble 1s infinite;
            display: inline-block;
        }

        @keyframes wobble {
            0%, 100% { transform: rotate(0); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }
    </style>
</head>
<body>
@include('admin.sidebar')

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow w-100">
                <h1 class="h2 mb-4">Nhà Cung Cấp</h1>

                <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end" style="max-width: 1100px">
                    <a href="{{ route('admin.doithecao.nhacungcap.add') }}" class="btn btn-primary">Thêm Nhà Cung Cấp</a>
                </div>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Sản Phẩm</th>
                            <th>Hình Ảnh</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nhacungcaps as $nhacungcap)
                        <tr>
                            <td>{{ $nhacungcap->id_nhacungcap }}</td>
                            <td>{{ $nhacungcap->ten }}</td>
                            <td>
                                @if ($nhacungcap->hinh_anh)
                                <!-- BUG: Missing error handling for broken images -->
                                <img src="{{ asset($nhacungcap->hinh_anh) }}" alt="img" width="60">
                                @else
                                <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>
                                <!-- BUG: No timezone handling -->
                                {{ \Carbon\Carbon::parse($nhacungcap->ngay_tao)->format('d/m/Y') }}
                                <!-- FIX: Add timezone -->
                                {{ \Carbon\Carbon::parse($nhacungcap->ngay_tao)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                            </td>
                            <td>
                                @if ($nhacungcap->trang_thai == 'hoat_dong')
                                <span class="badge bg-success">Hoạt Động</span>
                                @else
                                <span class="badge bg-secondary">Đã Ẩn</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.doithecao.nhacungcap.edit', $nhacungcap->id_nhacungcap) }}" class="btn btn-sm btn-dark">Sửa</a>

                                <form action="{{ route('admin.doithecao.nhacungcap.destroy', $nhacungcap->id_nhacungcap) }}"
                                      method="POST"
                                      class="d-inline delete-form"
                                      data-id="{{ $nhacungcap->id_nhacungcap }}"
                                      data-name="{{ $nhacungcap->ten }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Chưa có nhà cung cấp nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end pt-3">
                    {{ $nhacungcaps->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm -->
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

<!-- Add this right after your opening <body> tag -->
<div id="notification-container" class="position-fixed top-50 start-50 translate-middle" style="z-index: 1060; display: none;">
    <div class="alert alert-dismissible fade show" role="alert">
        <span id="notification-message"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    let currentForm = null;

    // Enhanced notification function
    function showNotification(message, type = 'danger') {
        Swal.fire({
            text: message,
            icon: type === 'danger' ? 'error' : 'success',
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }

    // Handle delete form submission
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            currentForm = this;

            const id = this.dataset.id;
            const name = this.dataset.name;
            const btn = this.querySelector('.delete-btn');

            try {
                const checkUrl = `{{ url('admin/doithecao/nhacungcap/check') }}/${id}`;
                const response = await fetch(checkUrl);

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (!data.exists) {
                    Swal.fire({
                        title: 'Đã xóa!',
                        text: 'Nhà cung cấp này đã bị xóa bởi người dùng khác!',
                        icon: 'info',
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        location.reload();
                    });
                    return;
                }

                // Show enhanced confirmation modal
                confirmMessage.innerHTML = `Bạn có chắc chắn muốn xóa nhà cung cấp<br><strong class="text-danger">"${name}"</strong>?`;
                confirmModal.show();

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra, vui lòng thử lại!',
                    icon: 'error',
                    confirmButtonText: 'Đóng',
                    confirmButtonColor: '#3085d6'
                });
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-trash"></i> Xóa';
            }
        });
    });

    // Handle confirm delete button click
    confirmDeleteBtn.addEventListener('click', async function() {
        if (!currentForm) return;

        const btn = currentForm.querySelector('.delete-btn');
        const id = currentForm.dataset.id;

        try {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

            // Double check before final deletion
            const checkUrl = `{{ url('admin/doithecao/nhacungcap/check') }}/${id}`;
            const response = await fetch(checkUrl);

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (!data.exists) {
                confirmModal.hide();
                showNotification('Nhà cung cấp này đã bị xóa bởi người dùng khác!', 'danger');
                location.reload();
                return;
            }

            // Proceed with deletion
            currentForm.submit();

        } catch (error) {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'danger');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-trash"></i> Xóa';
            confirmModal.hide();
        }
    });
});
</script>
</body>
</html>
