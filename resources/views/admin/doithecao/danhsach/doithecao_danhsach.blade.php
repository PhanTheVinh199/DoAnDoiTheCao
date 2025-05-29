@include('admin.sidebar')

{{-- Alert Messages --}}
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: @json(session('error')),
                timer: 4000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        });
    </script>
@endif

<div class="main">
    <div class="container-fluid px-4 py-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm"  style="width: 1300px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="h3 mb-0">Danh Sách Thẻ</h1>
                            <a href="{{ route('admin.doithecao.danhsach.create') }}"
                               class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm Sản Phẩm
                            </a>
                        </div>

                        {{-- Nhà cung cấp filter buttons --}}
                        <div class="btn-group mb-4">
                            @foreach ($nhacungcap as $item)
                                <button class="btn btn-outline-dark me-2"
                                        onclick="showTable('supplier-{{ $item->id_nhacungcap }}')"
                                        id="btn-supplier-{{ $item->id_nhacungcap }}">
                                    {{ $item->ten }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Product Tables --}}
                        @foreach ($nhacungcap as $index => $item)
                            <div class="table-responsive">
                                <table class="table table-hover border"
                                       id="supplier-{{ $item->id_nhacungcap }}"
                                       style="display: {{ $index == 0 ? 'table' : 'none' }};">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="20%">Sản Phẩm</th>
                                            <th width="20%">Mệnh Giá</th>
                                            <th width="15%">Chiết Khấu</th>
                                            <th width="20%">Trạng Thái</th>
                                            <th width="20%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $hasProduct = false; @endphp
                                        @foreach ($danhsach as $product)
                                            @if ($product->nhacungcap && $product->nhacungcap->ten === $item->ten)
                                                @php $hasProduct = true; @endphp
                                                <tr>
                                                    <td>{{ $product->id_doithecao }}</td>
                                                    <td>{{ $product->nhacungcap->ten }}</td>
                                                    <td>{{ number_format($product->menh_gia, 0, ',', '.') }} VNĐ</td>
                                                    <td>{{ $product->chiet_khau }}%</td>
                                                    <td>
                                                        <span class="badge rounded-pill
                                                            {{ $product->trang_thai == '1' ? 'bg-success' :
                                                               ($product->trang_thai == '0' ? 'bg-danger' : 'bg-warning') }}">
                                                            {{ $product->trang_thai == '1' ? 'Hoạt động' :
                                                               ($product->trang_thai == '0' ? 'Đã hủy' : 'Chờ xử lý') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('admin.doithecao.danhsach.edit', $product->id_doithecao) }}"
                                                               class="btn btn-sm btn-outline-primary me-2">
                                                                <i class="fas fa-edit"></i> Sửa
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDeleteAjax('{{ $product->id_doithecao }}', '{{ $product->nhacungcap->ten }}', this)">
                                                                <i class="fas fa-trash"></i> Xóa
                                                            </button>
                                                        </div>

                                                        <form id="delete-form-{{ $product->id_doithecao }}"
                                                              action="{{ route('admin.doithecao.danhsach.destroy', $product->id_doithecao) }}"
                                                              method="POST"
                                                              style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @if (!$hasProduct)
                                            <tr>
                                                <td colspan="6" class="text-center">Chưa có sản phẩm</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FontAwesome CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<style>
    .btn-group .btn.active {
        background-color: #212529;
        color: white;
    }
    .table {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.875rem;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showTable(network) {
        let tables = document.querySelectorAll("table");
        tables.forEach(table => table.style.display = "none");

        let buttons = document.querySelectorAll("button");
        buttons.forEach(button => button.classList.remove("active"));

        let table = document.getElementById(network);
        if (table) table.style.display = "table";

        let activeButton = document.getElementById('btn-' + network);
        if (activeButton) activeButton.classList.add("active");
    }

    function confirmDeleteAjax(id, name, btn) {
        Swal.fire({
            title: `Bạn có chắc chắn muốn xóa sản phẩm của nhà cung cấp "${name}"?`,
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.disabled = true;

                fetch(`/admin/doithecao/danhsach/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if(!response.ok) {
                        throw new Error('Lỗi server');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            toast: true,
                            position: 'top-end',
                            timer: 2500,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        });

                        // Xóa dòng tương ứng trên table
                        const row = btn.closest('tr');
                        if (row) row.remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: data.message || 'Xảy ra lỗi khi xóa.',
                            toast: true,
                            position: 'top-end',
                            timer: 3500,
                            showConfirmButton: false,
                        });
                        btn.disabled = false;
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Không thể kết nối đến server.',
                        toast: true,
                        position: 'top-end',
                        timer: 3500,
                        showConfirmButton: false,
                    });
                    btn.disabled = false;
                });
            }
        });
    }
</script>
