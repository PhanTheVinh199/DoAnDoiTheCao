# Sử dụng image chính thức của PHP
FROM php:8.2-fpm

# Cài đặt các tiện ích cần thiết như GD, MySQL, và các công cụ khác
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libmcrypt-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    apt-get clean

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Tạo thư mục làm việc cho Laravel
WORKDIR /var/www

# Sao chép các tệp Laravel vào container
COPY . .

# Cài đặt các phụ thuộc PHP qua Composer
RUN composer install

# Cấu hình quyền truy cập cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www/storage && \
    chmod -R 755 /var/www/bootstrap/cache

# Expose cổng cho PHP-FPM
EXPOSE 9000

# Khởi chạy PHP-FPM
CMD ["php-fpm"]
