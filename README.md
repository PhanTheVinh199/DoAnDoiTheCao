# 🔁 Hệ Thống Đổi Thẻ Cào Laravel

Website hỗ trợ mua, bán, nạp, rút tiền và đổi thẻ cào điện thoại nhanh chóng.  
Phát triển bằng Laravel, hướng đến trải nghiệm đơn giản, an toàn và tiện lợi.

---

## ⚙️ Tính năng nổi bật

- 🔁 Đổi thẻ cào (Mobifone, Viettel, Vinaphone,...)
- 🛒 Mua thẻ cào điện thoại
- 💰 Nạp tiền vào tài khoản
- 💳 Rút tiền về ngân hàng hoặc ví điện tử
- 👤 Đăng ký / Đăng nhập và quản lý tài khoản người dùng
- 📊 Xem lịch sử giao dịch chi tiết
- 🔐 Hệ thống bảo mật và phân quyền người dùng

---

## 🧱 Công nghệ sử dụng

- ⚙️ Laravel 11+
- 💾 MySQL / MariaDB
- 💻 Blade Template + Bootstrap (hoặc Tailwind)
- 🛡️ Xác thực Laravel Auth (hoặc Laravel Breeze/Fortify)

---

## 🛠️ Hướng dẫn cài đặt

```bash
# Clone repository
git clone https://github.com/PhanTheVinh199/DoAnDoiTheCao.git
cd DoAnDoiTheCao

# Cài đặt các thư viện PHP
composer install

# Tạo file .env và cấu hình
cp .env.example .env
php artisan key:generate

# Cập nhật thông tin DB trong .env rồi chạy:
php artisan migrate --seed

# Chạy server
php artisan serve

```
---

## 👨‍💻 Nhóm phát triển
- Phan Thế Vĩnh 
- Nguyễn Thanh Tự 
- Nguyễn Văn Bảo
