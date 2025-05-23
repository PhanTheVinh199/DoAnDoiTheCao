@include('admin.sidebar')

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="main" style="margin-top: 10px; padding: 50px">
    <div class="container">
        <div class="row d-flex">
            <div class="bg-white p-3 rounded shadow">
                <h1 class="h2 mb-4">Danh Sách Thẻ</h1>

                <!-- Nút thêm sản phẩm -->
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('admin.doithecao.danhsach.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus mr-1"></i> Thêm Sản Phẩm
                    </a>
                </div>

                <!-- Nút chọn nhà cung cấp -->
                <div class="mb-3" id="supplier-buttons">
                    @foreach ($nhacungcap as $item)
                        <button class="btn btn-dark supplier-btn mb-1 {{ $loop->first ? 'active' : '' }}"
                                data-id="nhacungcap-{{ $item->id_nhacungcap }}">
                            {{ $item->ten }}
                        </button>
                    @endforeach
                </div>

                <!-- Bảng sản phẩm theo nhà cung cấp -->
                @foreach ($nhacungcap as $index => $item)
                    <div class="table-responsive supplier-table"
                         id="nhacungcap-{{ $item->id_nhacungcap }}"
                         style="display: {{ $index == 0 ? 'block' : 'none' }};">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nhà Cung Cấp</th>
                                    <th>Mệnh Giá</th>
                                    <th>Chiết Khấu</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $hasProduct = false; @endphp
                                @foreach ($danhsach as $product)
                                    @if ($product->nhacungcap && $product->nhacungcap->id_nhacungcap === $item->id_nhacungcap)
                                        @php $hasProduct = true; @endphp
                                        <tr>
                                            <td>{{ $product->id_doithecao }}</td>
                                            <td>{{ e($product->nhacungcap->ten) }}</td>
                                            <td>{{ number_format($product->menh_gia, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $product->chiet_khau }}%</td>
                                            <td>
                                                <span class="badge bg-{{ $product->trang_thai == 1 ? 'success' : ($product->trang_thai == 2 ? 'warning' : 'secondary') }}">
                                                    {{ $product->trang_thai == 1 ? 'Hoạt động' : ($product->trang_thai == 2 ? 'Chờ xử lý' : 'Đã hủy') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.doithecao.danhsach.edit', $product->id_doithecao) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </a>
                                                    <form action="{{ route('admin.doithecao.danhsach.destroy', $product->id_doithecao) }}"
                                                          method="POST"
                                                          class="d-inline delete-form"
                                                          data-id="{{ $product->id_doithecao }}"
                                                          data-name="{{ e($product->nhacungcap->ten) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger delete-btn">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
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

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quản lý tabs nhà cung cấp
    const supplierButtons = document.querySelectorAll('.supplier-btn');
    supplierButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.dataset.id;

            document.querySelectorAll('.supplier-table').forEach(table => {
                table.style.display = 'none';
            });

            document.querySelectorAll('.supplier-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById(targetId).style.display = 'block';
            this.classList.add('active');
        });
    });

    // Xử lý xóa với kiểm tra concurrent
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteMessage = document.getElementById('deleteMessage');
    const confirmDelete = document.getElementById('confirmDelete');
    let currentForm = null;

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            currentForm = this;
            const productName = this.dataset.name;
            deleteMessage.textContent = `Bạn có chắc muốn xóa sản phẩm "${productName}"?`;
            deleteModal.show();
        });
    });

    confirmDelete.addEventListener('click', async function() {
        if (!currentForm) return;

        const deleteBtn = currentForm.querySelector('.delete-btn');
        const productId = currentForm.dataset.id;

        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

        try {
            // Fixed route with proper parameter
            const checkUrl = "{{ route('admin.doithecao.danhsach.check', ':id') }}".replace(':id', productId);
            const response = await fetch(checkUrl);
            const data = await response.json();

            if (!data.exists) {
                deleteModal.hide();
                alert('Sản phẩm này đã bị xóa bởi người dùng khác!');
                location.reload();
                return;
            }

            currentForm.submit();

        } catch (error) {
            console.error('Error:', error);
            deleteModal.hide();
            alert('Có lỗi xảy ra, vui lòng thử lại!');
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i> Xóa';
        }
    });
});
</script>
