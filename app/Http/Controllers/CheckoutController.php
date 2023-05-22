<?php

namespace App\Http\Controllers;
use App\Mail\SendMail;
use App\Customer;
use App\DetailOrder;
use App\Order;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Ward;
use DB;
class CheckoutController extends Controller
{
    public function show(Request $request){
        // $products = Product::all();
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        // $ProductCategorys = ProductCategory::all();

        return view('home.checkout.show',compact('provinces','districts','wards'));
    }
    function store(Request $request){
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email'=>'required|email',
            'province'=>'required',
            'district'=>'required',
            'ward'=>'required',
            'phone'=>'required',
            'address'=>'required'
            
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            'file'=>':attribute phải ở dạng fiel',
            'image'=>':attribute phải ở dạng ảnh .jpg,.png'
            
        ],
        [
            'fullname' => 'Họ và tên',
            'email'=>'Email',
            'province'=>'Tỉnh/Thành phố',
            'district'=>'Quận/Huyện',
            'ward'=>'Xã/Phường/Thị trấn',
            'phone'=>'Số điện thoại',
            'address'=>'Địa chỉ'
            
        ]
        );
        // dd($request);
        $wards = Ward::all();
        foreach($wards as $ward){
            if($ward['id']==$request->input('ward')){
                $ward_name = $ward['name'];
            }
        }
       
        $districts = District::all();
        foreach($districts as $district){
            if($district['id']==$request->input('district')){
                $district_name = $district['name'];
            }
        }
        $provinces = Province::all();
        foreach($provinces as $province){
            if($province['id']==$request->input('province')){
                $province_name = $province['name'];
            }
        }
        //thêm dl bảng khách hàng
        $customer=Customer::create([
            'fullname'=>$request->input('fullname'),
            'email'=>$request->input('email'),
            // 'address'=>Ward::find($id)->name()->ge
           
            'address' => $request->input('address').','. $ward_name.','. $district_name.','.$province_name,
            'phone'=>$request->input('phone'),
            'note'=>$request->input('note'),
            
        ]);
         //thêm dl bảng hóa đơn
         
         $order=Order::create([
            'customer_id'=>$customer->id,
            'order_code'=>'UNI'.crc32($request->input('phone')),
      
            // 'address'=>Ward::find($id)->name()->ge
          
            'date_order' =>date("d/m/Y"),
            'total'=>  str_replace( ',', '', Cart::subtotal()),
            'payment'=>$request->input('payment-method'),
            'note'=>$request->input('note'),
            'status'=>'shipping'
            
        ]);
        //thêm dl bảng chi tiết hóa đơn
        foreach(Cart::content() as $key=>$value){
            
            $detail_order=DetailOrder::create([
                'product_id'=>$value->id,
                'order_id'=>$order->id,
                'qty' =>$value->qty,
                'price'=>$value->subtotal,
               
                
            ]);
        }
        $data = [
            'fullname' => $request->input('fullname'),
            'address' =>  $request->input('address').','. $ward_name.','. $district_name.','.$province_name,
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'order_code'=>'UNI'.crc32($request->input('phone')),
            'date_order' =>date("d/m/Y H:i:s"),
        ];
        Mail::to($request->input('email'))->send(new SendMail($data));
        Cart::destroy();
        return redirect('thanks')->with('status','Đặt hàng thành công'); 
    }
    public function buynow($id){
        // $provinces = Province::all();
        // $districts = District::all();
        // $wards = Ward::all();
        $ProductCategorys = ProductCategory::all();
     
        $product = Product::find($id);
        // return $product->product_thumb;
        Cart::add(
            ['id' => $product->id,
             'name' => $product->product_title,
             'qty' => 1, 
             'price' => $product->new_price,
             'options' => ['thumbnail' =>  $product->product_thumb, 'max_qty' => $product->num_product]
              
        ]);
        return redirect('thanh-toan.html');
        // return view('home.checkout.show',compact('ProductCategorys','provinces','districts','wards'));
        
    }
    //select_district
    public function select_district($province_id){
        
        echo json_encode(District::where('province_id', $province_id)->get());
    }
    //select_ward
    public function select_ward($district_id){
        
        echo json_encode(Ward::where('district_id', $district_id)->get());
    }

    // public function GetSubCatAgainstMainCatEdit($id){
        
    //     echo json_encode(District::where('province_id', $id)->get());
    // }
    public function thanks(Request $request){
  
        return view('home.checkout.thanks');
    }
   
}
