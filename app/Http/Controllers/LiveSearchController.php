<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LiveSearchController extends Controller
{
    //
    public function index()
    {
    
        $products = DB::table('products')->get();
        // return view('searchAjax.index', compact('products'));
        return view('home.inc.header', compact('products'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $products = DB::table('products')->where([
                ['product_title', 'LIKE', '%' . $request->search . '%'],
                ['status','publish']
            ])
            ->orWhere('new_price',$request->search)
            ->limit(8)
            ->get();
            if ($products) {
                foreach ($products as $key => $product) {
                    $output .='<li class="clearfix">
                    <a href='.route('product.detail',Str::slug($product->product_title)) .' class="clearfix" style="display:block">
                        <div class="thumb fl-left">
                            <img src='.url($product->product_thumb) .' >
                        </div>
                         <div class="info fl-left">
                            <p class="product_name"> ' . $product->product_title . '</p>
                             <p class="product_price">'.number_format($product->new_price, 0, '' ,'.') .'đ</p>
                            </div> 
                        </a>
                </li>';
                }
            }
            return Response($output);
        }else{
            
            
        $products  = DB::table('products')->where([
            ['product_title', 'LIKE', '%' . $request->s . '%'],
            ['status','publish']
        ])
        ->orWhere('new_price',$request->s)
        ->get();
        // dd( $products);
        return view('home.search.show',compact('products'));
        }
    }
    //tim kiem
    // public function getSearch(Request $request){
    //     $ProductCategorys = ProductCategory::all();
 
    //     $products  = Product::where('product_title', 'LIKE', '%' . $request->s . '%')
    //                         ->orWhere('new_price',$request->s)
    //                         ->get();
    //     return view('home.search.show',compact('products','ProductCategorys'));
    // }
}
