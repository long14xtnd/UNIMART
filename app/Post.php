<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
         'title', 'post_content','status','user_id','slug','category_id','post_thumb'
    ];
    public function category(){
        //1 bài viết chỉ thuộc vào 1 danh mục
        return $this->belongsTo('App\PostCategory','category_id');
    }
}
