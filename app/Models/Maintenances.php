<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenances extends Model
{
    // บังคับให้ Model นี้ไปใช้ตาราง repairs ที่เรา migrate ไว้
    protected $table = 'maintenances';

    protected $fillable = [
        'asset_id',
        'user_id',
        'description',
        'priority',
        'status',
        'repair_notes'
    ];

    // ความสัมพันธ์: การแจ้งซ่อมนี้เป็นของ Asset ชิ้นไหน
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    // ความสัมพันธ์: ใครเป็นคนแจ้งซ่อม
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
