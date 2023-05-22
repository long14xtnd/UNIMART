<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImgRelativeProduct extends Model
{
    //
    protected $table = 'tbl_img_relative_product';

    protected $fillable = ['img_relative_thumb','product_id'];
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
