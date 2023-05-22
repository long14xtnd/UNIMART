<?php

namespace App\Http\Controllers;

use App\DetailOrder;
use App\ImgRelativeProduct;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    //cat
    function cat(Request $request,$cat_name)
    {
        $productCats = ProductCategory::all();
        foreach($productCats as $cat){
            if(Str::slug($cat->title) == $cat_name){
                $product_cat_id = $cat->id;
            }
        }
        $product_cat = ProductCategory::find($product_cat_id);
        $query = [];

        $price = $request->get('r-price');
        if ($price == 0) {
            $query[] = ['new_price', '>', 0];
        }elseif($price == 1){
            $query[] = ['new_price', '<', 500000];
        }elseif($price == 2){
            $query[] = ['new_price', '>=', 500000];
            $query[] = ['new_price', '<', 1000000];
        }elseif($price == 3){
            $query[] = ['new_price', '>=', 1000000];
            $query[] = ['new_price', '<', 5000000];
        }elseif($price == 4){
            $query[] = ['new_price', '>=', 5000000];
            $query[] = ['new_price', '<', 10000000];
        }elseif($price == 5){
            $query[] = ['new_price', '>=', 10000000];
        }

        $brand = $request->get('r-brand');
        if($brand != 'all'){
            $query[] = ['product_title', 'like', '%'.$brand.'%'];
        }

        //Order by arrange
        if($request->orderby==1){
            $products = Product::where($query)->orderBy('product_title', 'ASC')->get();
            //  dd($products);
        }elseif($request->orderby==2){
            $products = Product::where($query)->orderBy('product_title', 'DESC')->get();
        }elseif($request->orderby==3){
            $products = Product::where($query)->orderBy('new_price', 'DESC')->get();
        }elseif($request->orderby==4){
            $products = Product::where($query)->orderBy('new_price', 'ASC')->get();
            // dd($products);
        }else{
            $products = Product::where($query)->orderBy('id', 'DESC')->get();
            // dd($products);
        }

        // Get product by cat
        $cats_child = data_tree($productCats, $product_cat_id, 0);
        $cats_child[] = $product_cat;
        $products_by_cat = array();
        foreach ($products as $product) {
            foreach ($cats_child as $cat) {
                if($product['category_id'] == $cat['id']){
                    $products_by_cat[] = $product;
                }
            }
        }
        //pagination
        // $num_per_page = 8;
        // if($request->page){
        //     $page_num = $request->page;
        // } else{
        //     $page_num = 1;
        // }
        // $start = ($page_num - 1) * $num_per_page;
        // $list_product_by_page = array_slice($products_by_cat, $start, $num_per_page);

        // $products_by_cat = new LengthAwarePaginator($products_by_cat, count($products_by_cat), $num_per_page);
        // $products_by_cat->setPath('');
        $list_brands = ProductCategory::where('parent_id', $product_cat_id)->get();
        return view('home.product.product_by_cat',compact('products_by_cat','product_cat','products','list_brands') );
    }

    public function search_result(){

        $products = Product::all();
        return view('home.search.show',compact('products'));
    }
    public function search(Request $request){
        $output = '';
        $products = Product::where('product_title','LIKE','%'.$request->keyword.'%')->get();
        foreach ($products as $product){
            $output .= '<tr>
                    <td>'.$product->product_title.'</td>
                    <td>'.$product->num_product.'</td>
        </tr>';
        }
        return response()->json($output);
        // echo "alo";
    //   return view('home.search.test');
    }
    public function show(Request $request){
       
            $product_cats = ProductCategory::where('parent_id', '=', 0)->get();
            $cats = ProductCategory::all();
            $products = Product::orderBy('id', 'desc')->get();
            $products_by_cat =[];
            foreach ($product_cats as $cat) {
                $cats_child = data_tree($cats, $cat['id'], 0);
                $cats_child[] = $cat;
                $cat_child_id = [];
                foreach ($cats_child as $cat) {
                    $cat_child_id[] = $cat['id'];
                }

                if ($request->orderby==1) {
                    $products_by_cat[$cat['id']] = Product::whereIn('category_id', $cat_child_id)->orderBy('product_title', 'ASC')->get();
                } elseif ($request->orderby==2) {
                    $products_by_cat[$cat['id']] = Product::whereIn('category_id', $cat_child_id)->orderBy('product_title', 'DESC')->get();
                } elseif ($request->orderby==3) {
                    $products_by_cat[$cat['id']] = Product::whereIn('category_id', $cat_child_id)->orderBy('new_price', 'DESC')->get();
                } elseif ($request->orderby==4) {
                    $products_by_cat[$cat['id']] = Product::whereIn('category_id', $cat_child_id)->orderBy('new_price', 'ASC')->get();
                } else {
                    $products_by_cat[$cat['id']] = Product::whereIn('category_id', $cat_child_id)->orderBy('id', 'DESC')->get();
                }
            }
        return view('home.product.show',compact('product_cats', 'products_by_cat', 'products'));
    }
    public function detail(Request $request,$product_title){
        $products_selling = Product::where('old_price','>','10000000')->limit(8);
        $ProductCategorys = ProductCategory::all();
        // $slug = $request->product_title;
        // // $product=Str::slug($slug);
        // return $slug;
        $products = Product::all();
        foreach($products as $product){
            if(Str::slug($product->product_title)==$product_title){
                $id = $product->id;
            }
        }
        $product = Product::find($id);
        $img_relative_products = ImgRelativeProduct::where('product_id',$id)->get();
        $cate_id = $product->category_id;

        $products_with_cat = Product::where('category_id',$cate_id)->limit(6)->get();
        // 
        return view('home.product.detail',compact('ProductCategorys','product','img_relative_products','products_with_cat','products','products_selling'));
    }
    
}

function data_tree($data,$parent_id = 0,$level=0){
    $result = [];
    foreach($data as $item){
       if($item['parent_id']==$parent_id){
          $item['level']=$level;
          $result[]=$item;
          $child = data_tree($data,$item['id'],$level+1);
          $result=array_merge($result,$child);
       }
 
    }
    return $result;
 }
