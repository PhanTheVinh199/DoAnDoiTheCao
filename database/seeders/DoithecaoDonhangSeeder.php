<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\DoithecaoDanhsach; // Thêm dòng này để sử dụng model Eloquent

class DoithecaoDonhangSeeder extends Seeder
{
    public function run()
    {
        // Giả sử bạn có các nhà cung cấp (nhacungcap_id) và sản phẩm (doithecao_id) có sẵn trong cơ sở dữ liệu
        $doithecao_ids = [1, 2, 3, 4, 5]; // Ví dụ về các sản phẩm
        $thanhvien_ids = [1, 2, 3, 4, 5]; // Ví dụ về các thành viên

        for ($i = 1; $i <= 10; $i++) {
            // Lấy một sản phẩm và một thành viên ngẫu nhiên
            $doithecao_id = $doithecao_ids[array_rand($doithecao_ids)];
            $thanhvien_id = $thanhvien_ids[array_rand($thanhvien_ids)];

            // Lấy thông tin sản phẩm từ bảng doithecao_danhsach qua Eloquent model
            $doithecao = DoithecaoDanhsach::find($doithecao_id);

            // Nếu không tìm thấy sản phẩm, bỏ qua
            if ($doithecao) {
                $ten_san_pham = $doithecao->ten_san_pham;
                $menh_gia = $doithecao->menh_gia;
                $chiet_khau = $doithecao->chiet_khau;

                // Tính thành tiền
                $so_luong = rand(1, 5); // Số lượng thẻ
                $thanh_tien = $menh_gia * $so_luong; // Thành tiền = Mệnh giá * Số lượng
                $thanh_tien_chiet_khau = $thanh_tien - ($thanh_tien * ($chiet_khau / 100)); // Áp dụng chiết khấu

                // Tạo mã thẻ và serial ngẫu nhiên với 12 chữ số
                $ma_the = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT); // Mã thẻ 12 số
                $serial = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT); // Serial 12 số

                // Tạo dữ liệu đơn hàng
                DB::table('doithecao_donhang')->insert([
                    'ma_don' => 'DTC-' . Str::random(10), // Tạo mã đơn ngẫu nhiên
                    'ma_the' => $ma_the, // Mã thẻ là 12 số
                    'serial' => $serial, // Serial là 12 số
                    'doithecao_id' => $doithecao_id,
                    'so_luong' => $so_luong,
                    'thanh_tien' => $thanh_tien_chiet_khau, // Thành tiền sau chiết khấu
                    'thanhvien_id' => $thanhvien_id,
                    'ngay_tao' => Carbon::now(),
                    'trang_thai' => 'cho_xu_ly', // Trạng thái mặc định
                ]);
            }
        }
    }
}
