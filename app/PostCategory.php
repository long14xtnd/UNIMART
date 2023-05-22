<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    //
    protected $table = 'post_category';

    protected $fillable = ['name', 'slug','parent_id','user_id'];
    public function post(){
        //1 danh mục có thể có nhiều bài post
        return $this->hasMany('App\Post');
    }
}
