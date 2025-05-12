<?php

return [

    /*
    |--------------------------------------------------------------------------
    | VNPAY Config
    |--------------------------------------------------------------------------
    |
    | Đây là các thông tin cấu hình dành cho cổng thanh toán VNPAY.
    | Các giá trị này sẽ được đặt trong file .env để tiện quản lý và bảo mật.
    |
    */

    'tmn_code'     => env('VNPAY_TMN_CODE', 'YOUR_TMN_CODE'),          // Mã website của bạn trên VNPAY
    'hash_secret'  => env('VNPAY_HASH_SECRET', 'YOUR_HASH_SECRET'),    // Chuỗi bí mật dùng để mã hóa
    'url'          => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'), // Link thanh toán
    'return_url'   => env('VNPAY_RETURN_URL', 'https://yourdomain.com/vnpay/return'),         // Link nhận callback
    'api_url'      => env('VNPAY_API_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/merchant.html'), // (tuỳ chọn) API xác thực giao dịch
];
