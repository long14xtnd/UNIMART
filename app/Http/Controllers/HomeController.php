<?php

namespace App\Http\Controllers;

use App\Page;
use App\Post;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        

        $product_cats = ProductCategory::where('parent_id', '=', 0)->get();
       
        $cats = ProductCategory::all();
        $products  = Product::where('status','publish')->get();
        $product_feature = Product::where('status','publish')->orderBy('id', 'desc')->limit(8)->get();
        // dd($list_product_cat);
        return view('home',compact('products','product_cats','cats','product_feature'));
    }
   
    //hàm hiển thị danh mục theo điểu đệ quy reponsive
    public function sidebar_product_respon(){
        return view('index');
    }

   public function huong_dan_mua_hang_online(){
       $tutorial = Page::find(10);
       return view('home.page.huong_dan_mua_hang_online',compact('tutorial'));
   }
  function data_tree($data,$parent_id = 0,$level=0){
   $result = [];
   foreach($data as $item){
      if($item['parent_id']==$parent_id){
         $item['level']=$level;
         $result[]=$item;
        
         //ở đây sa
         $child = data_tree($data,$item['id'],$level+1);
         $result=array_merge($result,$child);
      }

   }
   return $result;
}
}
