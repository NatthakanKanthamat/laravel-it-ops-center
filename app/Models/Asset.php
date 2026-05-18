<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Asset extends Model
{
    protected $fillable = [
        'asset_tag', 
        'name', 
        'username',
        'category', 
        'purchase_date', 
        'serial_number', 
        'status', 
        'user_id',
        'asset_image',
        'spec_details',
        
        ];


public function maintenances() {
    return $this->hasMany(Maintenances::class);

}

public function user() {
    return $this->belongsTo(User::class, 'user_id');

}

}