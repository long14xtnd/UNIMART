<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
    public function show(){

        return view('search.show');
    }
    public function search(Request $request){
        // echo "ok";
      
        $inputSearch = $request['inputSearch'];
        // echo $inputSearch;
        // $keyResult = Product::where('product_title','LIKE','%'.$inputSearch.'%')->get();
        $keyResult = DB::table('products')
        ->where('product_title','LIKE','%'.$inputSearch.'%')
        ->get();
        echo $keyResult;
    }
}
