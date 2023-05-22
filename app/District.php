<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //  
    protected $table = 'districts';
    public function province()
    {
        return $this->belongsTo(Province::class, config('vietnam-maps.columns.province_id'), 'id');
    }
    
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
