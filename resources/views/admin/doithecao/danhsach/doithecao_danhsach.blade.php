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
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="h3 mb-0">Danh Sách Thẻ</h1>
                            <a href="{{ route('admin.doithecao.danhsach.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm Sản Phẩm
                            </a>
                        </div>

                        <div class="btn-group mb-4" role="group" aria-label="Nhà cung cấp">
                            @foreach ($nhacungcap as $item)
                                <button
                                    type="button"
                                    class="btn btn-outline-dark me-2"
                                    id="btn-supplier-{{ $item->id_nhacungcap }}"
                                    onclick="showTable('{{ $item->id_nhacungcap }}')"
                                >
                                    {{ $item->ten }}
                                </button>
                            @endforeach
                        </div>

                        @foreach ($nhacungcap as $index => $item)
                        <div class="table-responsive" style="display: {{ $index == 0 ? 'block' : 'none' }};" id="supplier-{{ $item->id_nhacungcap }}-container">
                            <table class="table table-hover border" id="supplier-{{ $item->id_nhacungcap }}">
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Nhà Cung Cấp</th>
                                        <th width="20%">Mệnh Giá</th>
                                        <th width="15%">Chiết Khấu</th>
                                        <th width="20%">Trạng Thái</th>
                                        <th width="20%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $hasProduct = 0; @endphp
                                    @foreach ($danhsach as $product)
                                        @if ($product->nhacungcap && $product->nhacungcap->id_nhacungcap === $item->id_nhacungcap)
                                            @php $hasProduct++; @endphp
                                            <tr id="row-{{ $product->id_doithecao }}">
                                                <td>{{ $product->id_doithecao }}</td>
                                                <td>{{ $item->ten }}</td>
                                                <td>{{ number_format($product->menh_gia) }} VNĐ</td>
                                                <td>{{ $product->chiet_khau }}%</td>
                                                <td>
                                                    <span class="badge {{ $product->trang_thai == '1' ? 'bg-success' : ($product->trang_thai == '0' ? 'bg-danger' : 'bg-warning') }}">
                                                        {{ $product->trang_thai == '1' ? 'Hoạt động' : ($product->trang_thai == '0' ? 'Đã hủy' : 'Chờ xử lý') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.doithecao.danhsach.edit', $product->id_doithecao) }}" class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteAjax('{{ $product->id_doithecao }}', '{{ $item->ten }}', this)">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @if ($hasProduct === 0)
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Chưa có sản phẩm nào.</td>
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
    function showTable(id) {
    const supplierId = `supplier-${id}`;
    localStorage.setItem('selectedTab', id);

    document.querySelectorAll("div.table-responsive").forEach(div => {
        div.style.display = "none";
    });
    document.querySelectorAll(".btn-group button").forEach(btn => {
        btn.classList.remove("active");
    });

    const container = document.getElementById(supplierId + '-container');
    if(container) container.style.display = 'block';

    const btn = document.getElementById('btn-supplier-' + id);
    if(btn) btn.classList.add('active');
}

    document.addEventListener('DOMContentLoaded', function() {
        const savedTab = localStorage.getItem('selectedTab');
        if(savedTab) {
            showTable(savedTab);
        } else {
            const firstBtn = document.querySelector('.btn-group button');
            if(firstBtn) {
                firstBtn.classList.add('active');
            const id = firstBtn.id.replace('btn-supplier-', '');
            showTable(id);
            }
        }
    });

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
            if(result.isConfirmed) {
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
                    if(!response.ok) throw new Error('Lỗi server');
                    return response.json();
                })
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            toast: true,
                            position: 'top-end',
                            timer: 2500,
                            showConfirmButton: false,
                        });
                        const row = document.getElementById('row-' + id);
                        if(row) row.remove();
                        const tbody = row?.parentElement;
                        if(tbody && tbody.children.length === 0) {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `<td colspan="6" class="text-center">Chưa có sản phẩm</td>`;
                            tbody.appendChild(tr);
                        }
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
