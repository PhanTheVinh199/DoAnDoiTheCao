@include('partials.header')

<style>
    /* Custom styles cho SweetAlert2 modal popup */
    .swal2-popup {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border-radius: 14px !important;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.25);
        font-size: 1.1rem;
    }
    .swal2-title {
        font-weight: 700 !important;
        font-size: 1.4rem !important;
        color: #222;
    }
    .swal2-html-container {
        color: #444;
        font-size: 1rem;
        margin-top: 10px;
    }
    .swal2-confirm {
        background-color: #3085d6 !important;
        font-weight: 600 !important;
        font-size: 1.05rem !important;
        border-radius: 8px !important;
        padding: 10px 25px !important;
        box-shadow: 0 4px 15px rgba(48, 133, 214, 0.5);
        transition: background-color 0.3s ease;
    }
    .swal2-confirm:hover {
        background-color: #2569c2 !important;
    }

    /* Toast style */
    .swal2-toast {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        padding: 0.8em 1.2em !important;
        font-size: 1rem !important;
        color: #fff !important;
        backdrop-filter: blur(10px);
        display: flex !important;
        align-items: center !important;
    }
    .swal2-toast .swal2-title {
        font-weight: 600 !important;
        font-size: 1.15rem !important;
        margin: 0 !important;
        line-height: 1.2 !important;
    }
    .swal2-toast .swal2-icon {
        width: 36px !important;
        height: 36px !important;
        margin-right: 0.8em !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
        flex-shrink: 0 !important;
    }
    /* Màu nền toast */
    .swal2-toast-success {
        background: linear-gradient(135deg, #4caf50, #388e3c) !important;
    }
    .swal2-toast-error {
        background: linear-gradient(135deg, #e53935, #b71c1c) !important;
    }
    .swal2-toast-info {
        background: linear-gradient(135deg, #2196f3, #1565c0) !important;
    }
</style>

<div class="container text-white">
    <div class="card bg-dark p-4">
        <h3 class="text-danger border-bottom pb-2">ĐƠN HÀNG #{{ $order->ma_don }}</h3>
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Mã đơn #:</strong> {{ $order->ma_don }}</p>
                <p><strong>Số tiền:</strong> {{ number_format($order->so_tien_nap, 2) }} VND</p>
                <p><strong>Trạng thái:</strong>
                    @if($order->trang_thai == 'cho_duyet')
                        <span class="badge bg-warning text-dark">Chưa duyệt</span>
                    @elseif($order->trang_thai == 'da_duyet')
                        <span class="badge bg-success">Hoàn thành</span>
                    @else
                        <span class="badge bg-danger">Đã hủy</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <h4 class="text-danger border-bottom pb-2 mt-4">THÔNG TIN THANH TOÁN</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Ngân hàng:</strong> {{ $order->nganhang->ten_ngan_hang ?? 'Chưa có thông tin' }}</p>
                <p><strong>Số tài khoản:</strong> {{ $order->nganhang->so_tai_khoan ?? 'Chưa có thông tin' }}</p>
                <p><strong>Tên tài khoản:</strong> {{ $order->nganhang->chu_tai_khoan ?? 'Chưa có thông tin' }}</p>
                <p><strong>Số tiền:</strong> {{ number_format($order->so_tien_nap, 2) }} VND</p>
                <p><strong>Nội dung thanh toán:</strong> {{ $order->transfer_note ?? 'Chưa có thông tin' }}</p>
            </div>
            <div class="col-md-6 text-center">
                @if($order->qr_code_filename)
                    <img src="{{ asset('storage/qrcodes/' . $order->qr_code_filename) }}" alt="QR Code" class="img-fluid" style="max-width: 250px;">
                @else
                    <p>Không có mã QR.</p>
                @endif
            </div>
        </div>


        <div class="mt-3">
            <a href="{{ route('naptien.form') }}" class="btn btn-secondary">Trở lại</a>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ToastConfig = {
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    };

    @if (session('success'))
        Swal.fire({
            ...ToastConfig,
            icon: 'success',
            title: 'Thành công',
            html: @json(session('success'))
        });
    @elseif (session('error'))
        Swal.fire({
            toast: false, // hiển thị modal popup giữa màn hình
            icon: 'error',
            title: 'Lỗi',
            html: @json(session('error')),
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: true,
            focusConfirm: true
        });
    @elseif (session('info'))
        Swal.fire({
            toast: false,
            icon: 'info',
            title: 'Thông báo',
            html: @json(session('info')),
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: true,
            focusConfirm: true
        });
    @endif
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
