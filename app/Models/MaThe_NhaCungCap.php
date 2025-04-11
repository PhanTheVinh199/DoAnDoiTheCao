<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaThe_NhaCungCap extends Model
{
    protected $table = 'mathecao_nhacungcap'; // Đổi đúng tên bảng nếu cần

    public $timestamps = false;
    
    protected $primaryKey = 'id_nhacungcap';

    protected $fillable = ['ten', 'hinhanh'];
}