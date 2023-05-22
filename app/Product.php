<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['product_title','product_thumb','product_desc','product_content','old_price','new_price','num_product','category_id','color_id','user_id','status'];

    public function category(){
        //1 bài viết chỉ thuộc vào 1 danh mục
        return $this->belongsTo('App\ProductCategory','category_id');
    }
    function colors(){
        return $this->belongsToMany('App\Colors');
    }
    function img_relative_product(){
        return $this->hasMany('App\ImgRelativeProduct');
    }
    public function detail_orders(){
     
        return $this->hasMany('App\DetailOrder');
    }
}
