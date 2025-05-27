<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Auth\ThanhVienUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot()
    {
        Validator::extend('not_blank', function ($attribute, $value, $parameters, $validator) {
        // Loại bỏ tất cả khoảng trắng Unicode (bao gồm full-width, 2 byte ...)
        $clean = trim(preg_replace('/\s+/u', '', $value));
        return $clean !== '';
    }, 'Trường :attribute không được để trống hoặc toàn khoảng trắng.');

        // Đăng ký provider tùy chỉnh cho người dùng
        Auth::provider('thanhvien', function ($app, array $config) {
            return new ThanhVienUserProvider($app['hash'], $config['model']);
        });

        // Thiết lập độ dài tối đa của chuỗi cho các cột varchar
        Schema::defaultStringLength(191);
    }
}
