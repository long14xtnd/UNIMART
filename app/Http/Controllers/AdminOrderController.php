<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DetailOrder;
use App\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{   
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active'=>'order']);
            return $next($request);
        });
    }
    function list(Request $request){
        $status = $request->input('status');

        $list_act=[
            'shipping'=>'Đang xử lý',
            'complete'=>'Hoàn thành',
            'cancel'=>'Đã hủy',
            'delete'=>'Xóa đơn hàng'
        ];

        if($status){
            if($status == 'shipping'){
                $list_act=[
                    
                    'complete'=>'Hoàn thành',
                    'cancel'=>'Đã hủy',
                    'delete'=>'Xóa đơn hàng'
                ];
                $orders = Order::orderby('id','DESC')->where('status', 'shipping')->paginate(10);
            }elseif($status == 'complete'){
                $list_act=[
                    'shipping'=>'Đang xử lý',
                   
                    'cancel'=>'Đã hủy',
                    'delete'=>'Xóa đơn hàng'
                ];
                $orders = Order::orderby('id','DESC')->where('status', 'complete')->paginate(10);
            }elseif($status == 'cancel'){
                $list_act=[
                    'shipping'=>'Đang xử lý',
                    'complete'=>'Hoàn thành',
                 
                    'delete'=>'Xóa đơn hàng'
                ];
                $orders = Order::orderby('id','DESC')->where('status', 'cancel')->paginate(10);
            }
        }else{
            $keyword = "";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }
            $orders = Order::orderby('id','DESC')->where('order_code','LIKE',"%{$keyword}%")->paginate(10);
        }





        // $keyword=" ";
        // if($request->input('keyword')){
        //     $keyword = $request->input('keyword');
        //     $orders = Order::orderby('id','DESC')->with('customer','detail_orders')->where('order_code','LIKE',"%{$keyword}%")
        //                                                                             // ->orWhere($order_search->customer->fullname,'LIKE',"%{$keyword}%")
        //                                                                             ->paginate('10');
        // }else{
        //     $orders = Order::orderby('id','DESC')->with('customer','detail_orders')->paginate('10');
        // }

              
        
      

        $count_order_shipping=Order::where('status','shipping')->count();
        $count_order_complete=Order::where('status','complete')->count();
        $count_order_cancel=Order::where('status','cancel')->count();
        $count=[$count_order_shipping,$count_order_complete, $count_order_cancel];

        // $orders = Order::orderby('id','DESC')->with('customer','detail_orders')->paginate('10');
        return view('admin.order.list',compact('orders','count','list_act'));
    }
     //Thao tác trên nhiều bản ghi
     function action(Request $request){
        
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            
            
                $act=$request->input('act');
                        if($act=="shipping"){
                            foreach($list_check as $id){
                                Order::where('id',$id)->update(['status'=>'shipping']);
                            }
                            return redirect('admin/order/list')->with('status','Đưa bản ghi về trạng thái đang xử lý thành công');
                        }
                       

                     
                        if($act=="complete"){
                            foreach($list_check as $id){
                                Order::where('id',$id)->update(['status'=>'complete']);
                            }
                            return redirect('admin/order/list')->with('status','Đưa bản ghi về trạng thái hoàn thành thành công');
                        }
                       
                        if($act=="cancel"){
                            foreach($list_check as $id){
                                Order::where('id',$id)->update(['status'=>'cancel']);
                            }
                            return redirect('admin/order/list')->with('status','Đưa bản ghi về trạng thái đã hủy thành công');
                        }
                        if($act=="delete"){
                            foreach($list_check as $id){
                                Order::where('id',$id)->delete();;
                                return redirect('/admin/order/list')->with('status','Bạn đã xóa bản ghi thành công');
                            }
                        }
            
        }else{
            return redirect('admin/order/list')->with('status','Bạn cần chọn bản ghi để thao tác');
        }
    }

    // function action(Request $request){
    //     $action = $request->input('act');
    //     dd($action);
    //     $list_check = $request->input('list_check');

    //     if($action && $list_check){
    //         if($action == 'delete'){
    //             Order::destroy($list_check);
    //             return redirect('admin/order/list')->with('status', 'Chuyển đơn đặt hàng vào thùng rác thành công!');
    //         }elseif($action == 'restore'){
    //             Order::withTrashed()
    //             ->whereIn('id', $list_check)
    //             ->restore();
    //             return redirect('admin/order/list')->with('status', 'Bạn đã khôi phục đơn đặt hàng thành công!');
    //         }else{
    //             Order::withTrashed()
    //             ->whereIn('id', $list_check)
    //             ->forceDelete();
    //             return redirect('admin/order/list')->with('status', 'Bạn đã xóa vĩnh viễn đơn đặt hàng thành công!');
    //         }
    //     }else{
    //         return redirect('admin/order/list')->with('warning', 'Hãy chọn đơn đặt hàng và hành động cần thực hiện!');
    //     }
    // }
    //chi tiết đơn hàng
    function detail($id){
        $order = Order::find($id);
        $sum_qty = DetailOrder::where('order_id',$id)->sum('qty');
        $detail_orders = DetailOrder::where('order_id',$id)->with('order','product')->get();
        return view('admin.order.detail',compact('detail_orders','order','sum_qty'));
    }
     //xoa don hang
     function delete(Request $request,$order_id){
        $order=Order::find($order_id);
        $order->delete();
            return redirect('/admin/order/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
    //cập nhật đơn hàng
    function edit($order_id){
        $order = Order::find($order_id);
        
        return view('admin.order.edit',compact('order'));
    }
    function update(Request $request,$order_id){
        $request->validate([
            'phone'=>'required',
            'address'=>'required'
            
        ],
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            'file'=>':attribute phải ở dạng fiel',
            'image'=>':attribute phải ở dạng ảnh .jpg,.png'
            
        ],
        [
            'phone'=>'Số điện thoại',
            'address'=>'Địa chỉ'
            
        ]
        );
        $customer_id = Order::find($order_id)->customer_id;
        // dd($customer_id);
        Customer::where('id',$customer_id)->update([
            'phone'=>$request->input('phone'),
            'address'=>$request->input('address')
           ]);
           Order::where('id',$order_id)->update([
            'status'=>$request->input('status')
           ]);
        //    //chuyển hướng đến trang admin/page/list
           return redirect('/admin/order/list')->with('status','Cập nhật thông tin thành công');
    }
}
