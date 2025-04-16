<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./public/css/style.css">

    <style>
        .bx {
            font-size: 20px;
            padding: 5px;
            color: rgb(255, 245, 245);
        }
    </style>
</head>

<body>

    <!-- Nút mở menu trên mobile -->
    <button id="menuToggle" class="menu-btn" style="margin-left: -15px; margin-top: 7px; font-size: 10px;">
        <i class='bx bx-menu'></i>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="menu-title">Dashboard</div>

        <a href="#menu1" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bx-credit-card'> Mã thẻ cào</i></span> <span>▼</span>
        </a>
        <div id="menu1" class="collapse ps-3">
            <a href="./mathecao_donhang.html">Đơn hàng</a>
            <a href="./mathecao_danhsach.html">Sản phẩm</a>
            <a href="./mathecao_nhacungcap.html">Nhà cung cấp</a>
        </div>

        <a href="#menu2" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bxs-credit-card-alt'> Đổi thẻ cào</i></span> <span>▼</span>
        </a>
        <div id="menu2" class="collapse ps-3">
            <a href="./doithecao_donhang.blade.php">Đơn hàng</a>
            <a href="./doithecao_danhsach.blade.php">Sản phẩm</a>
            <a href="./doithecao_nhacungcap.blade.php">Nhà cung cấp</a>
        </div>

        <a href="#menu4" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bxs-bank'> Ngân hàng</i></span> <span>▼</span>
        </a>
        <div id="menu4" class="collapse ps-3">
            <a href="./nganhang.html">Danh sách Ngân Hàng</a>
            <a href="./nganhang_ruttien.html">Lịch sử rút</a>
            <a href="./nganhang_naptien.html">Lịch sử nạp</a>
        </div>

        <a href="#menu5" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bx-user'> Thành Viên</i></span> <span>▼</span>
        </a>
        <div id="menu5" class="collapse ps-3">
            <a href="./thanhvien.html">Danh Sách</a>
        </div>

        <a href="#menu6" class="d-flex justify-content-between" data-bs-toggle="collapse">
            <span><i class='bx bxs-cog'> Cấu hình</i></span> <span>▼</span>
        </a>
        <div id="menu6" class="collapse ps-3">
            <a href="./caidat_nganhang.html">Cổng Thanh Toán</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main" style="margin-top: 10px; padding: 50px">
        <div class="container">
            <div class="row d-flex">
                <div class="bg-white p-3 rounded shadow">
                    <h1 class="h2 mb-4">Nhà Cung Cấp</h1>
    
                    <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end">
                        <a href="{{ route('admin.doithecao.nhacungcap.add') }}" class="btn btn-primary">Thêm Nhà Cung Cấp</a>
                    </div>
    
                    <table class="table table-bordered">
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
                            @foreach ($nhacungcaps as $nhacungcap)
                                <tr>
                                    <td>{{ $nhacungcap->id_nhacungcap }}</td>
                                    <td>{{ $nhacungcap->ten }}</td>
                                    <td>
                                        @if ($nhacungcap->hinh_anh)
                                            <img src="{{ asset('storage/' . $nhacungcap->hinh_anh) }}" alt="img-the" width="60">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $nhacungcap->created_at }}</td>
                                    <td>
                                        @if ($nhacungcap->trang_thai == 'hoat_dong')
                                            <button type="button" class="btn btn-success">Hoạt Động</button>
                                        @else
                                            <button type="button" class="btn btn-secondary">Đã Ẩn</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.doithecao.nhacungcap.edit', $nhacungcap->id_nhacungcap) }}" class="btn btn-dark">Sửa</a>                        
                                        <form action="{{ route('admin.doithecao.nhacungcap.delete', $nhacungcap->id_nhacungcap) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                Xóa
                                            </button>
                                        </form>
                        
                                        @if ($nhacungcap->trang_thai == 'hoat_dong')
                                            <form action="{{ route('admin.doithecao.nhacungcap.hide', $nhacungcap->id_nhacungcap) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Ẩn</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.doithecao.nhacungcap.show', $nhacungcap->id_nhacungcap) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Hiện</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        
                            @if ($nhacungcaps->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có nhà cung cấp nào.</td>
                                </tr>
                            @endif
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>

</body>

</html>
