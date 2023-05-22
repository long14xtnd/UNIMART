<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //
    protected $table = 'product_category';

    protected $fillable = ['title', 'slug','parent_id','user_id'];
    // public function product(){
    //     //1 danh mục có thể có nhiều bài post
    //     return $this->hasMany('App\Product');
    // }
    public function product(){
        //1 danh mục có thể có nhiều bài post
        return $this->hasMany('App\Product');
    }
}
