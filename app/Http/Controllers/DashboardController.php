<?php

namespace App\Http\Controllers;

use App\DetailOrder;
use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active'=>'dashboard']);
            return $next($request);
        });
    }
    function show(){
    
        $orders_complete = Order::where('status','complete')->get();
        $orders_shipping = Order::where('status','shipping')->get();
        $orders_cancel = Order::where('status','cancel')->get();
        //doanh số
        $sales = Order::where('status','complete')->sum('total');
        $detail_orders = DetailOrder::orderby('id','DESC')->with('order','product')->paginate('10');
        // dd($detail_orders);
        
        $orders = Order::orderby('id','DESC')->with('customer','detail_orders')->paginate('10');
       
        return view('admin.dashboard',compact('orders','detail_orders','orders_complete','orders_shipping','orders_cancel','sales'));
    }
    //xoa don hang
    function delete(Request $request,$order_id){
        $order=Order::find($order_id);
        $order->delete();
            return redirect('/dashboard')->with('status','Bạn đã xóa bản ghi thành công');
    }
}
