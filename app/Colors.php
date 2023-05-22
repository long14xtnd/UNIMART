<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    //
    protected $table = 'colors';

    protected $fillable = ['name', 'color_code'];
    function products(){
        return $this->belongsToMany('App\Product');
    }
}
