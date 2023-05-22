<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\PostCategory;
use App\Product;
use App\ProductCategory;

class PostController extends Controller
{
    //
    function show(){
        //hiển thị menu responsive
        // $ProductCategorys = ProductCategory::all();
        // $products = Product::all();
        $list_posts = Post::where('status','publish')->with('category')->paginate('10');
        return view('home.post.show',compact('list_posts'));
    }

    function detail(Request $request,$post_slug){
          //hiển thị menu responsive
    //    $slug = $request->post_slug;
    //    return $slug;
    // $products = Product::all();
    //       $ProductCategorys = ProductCategory::all();
        $post = Post::where('status','publish')->where('slug',$post_slug)->take(1)->get();
        foreach($post as $key => $val){
            $post_title = $val->title;
            $post_created_at = $val->created_at;
            $post_content = $val->post_content;
        }
       
        return view('home.post.detail',compact('post' ,'post_title','post_created_at','post_content'));
    }
}
