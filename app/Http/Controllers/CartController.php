<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    //
    public function show(){
        return view('home.cart.show');
    }

    public function add(Request $request, $id){
        // Cart::destroy();
        $product = Product::find($id);
        if($request->input('num-order')){
            $qty = $request->input('num-order');
        } else{
            $qty = 1;
        }
        // return $product->product_thumb;
        Cart::add(
            ['id' => $product->id,
             'name' => $product->product_title,
             'qty' => $qty, 
             'price' => $product->new_price,
             'options' => ['thumbnail' =>  $product->product_thumb, 'max_qty' => $product->num_product]
              
        ]);
        // return redirect('gio-hang.html');
        return redirect('/');
    }

    public function remove($rowId){

        Cart::remove($rowId);
        return redirect('gio-hang.html');
    }

    public function destroy(){

        Cart::destroy();
        return redirect('gio-hang.html');
    }
    public function update(Request $request){
        $rowId = $request->get('rowId');
        $qty = $request->get('qty');
        Cart::update($rowId, $qty);
        $sub_total = Cart::get($rowId)->subtotal;
        $total = Cart::total(0, 0, '.');
        $count_cart = Cart::count();
        $data = [
            'sub_total' => number_format($sub_total, 0,'','.').'đ',
            'total'=> $total.'đ',
            'count_cart' => $count_cart,
            'qty' => $qty
        ];
        // return response()->json($data);
         return json_encode($data);

       
    }
}
