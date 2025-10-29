<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    // protected $table = 'provinces';
    protected $fillable = [
        'province_code',
        'name',
        'short_name',
        'code',
        'place_type',
        'country'
    ];

    public function wards()
    {
        return $this->hasMany(Ward::class, 'province_code', 'province_code');
    }
}
