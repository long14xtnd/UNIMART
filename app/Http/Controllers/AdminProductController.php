<?php

namespace App\Http\Controllers;

use App\Colors;
use App\ImgRelativeProduct;
use App\Product;
use App\ProductCategory;
use App\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active'=>'product']);
            return $next($request);
        });
    }
    function list(Request $request){
        // $products = Product::all();

        // return view('admin.product.list_product',compact('products'));

        //tách nhau cho dễ nhìn
        $products = Product::with('category')->paginate('10');
        $ProductCategory = ProductCategory::all();
        $option = $request->input('option');
        $list_act=[
         'delete'=>'Xóa tạm thời',
         'publish'=>'Công khai',
         'pending'=>'Chờ duyệt',
         'forceDelete'=>'Xóa vĩnh viễn'
     ];
        //Trạng thái chờ duyệt
        if($option=='pending'){
         $list_act=[
                     'publish'=>'Công khai',
                     // 'delete'=>'Xóa tạm thời',
                     'delete'=>'Xóa tạm thời'
                     
                 ];
         $keyword=" ";
         if($request->input('keyword')){
             $keyword = $request->input('keyword');
         }
         
         $products = Product::with('category')->where([
         
             ['status','pending'],
             ['product_title','LIKE',"%{$keyword}%"]
             ])->paginate(10);
        }elseif($option=='publish'){
            //Trạng thái công khai
         $list_act=[
                     'pending'=>'Chờ xét duyệt',
                     // 'delete'=>'Xóa tạm thời',
                     'delete'=>'Xóa tạm thời'
                 ];
         $keyword=" ";
         if($request->input('keyword')){
             $keyword = $request->input('keyword');
         }
         
         $products = Product::with('category')->where([
        
             ['status','publish'],
             ['product_title','LIKE',"%{$keyword}%"]
             ])->paginate(10);
        }elseif($option=='delete'){
            //trạng thái thùng rác
             $list_act=[
                 'restore'=>'Khôi phục',
                 'forceDelete'=>'Xóa vĩnh viễn'
             ];
             $keyword=" ";
             if($request->input('keyword')){
                 $keyword = $request->input('keyword');
             }
            //  $users = User::onlyTrashed()->paginate(10);
             $products = Product::onlyTrashed()->with('category')->where([
 
                 
                 ['product_title','LIKE',"%{$keyword}%"]
                 ])->paginate(10);
        }
        else{
         $keyword=" ";
         if($request->input('keyword')){
             $keyword = $request->input('keyword');
         }
         
         $products = Product::where('product_title','LIKE',"%{$keyword}%")->paginate(10);
        }
        
         $status = [
             'publish'=>'Công khai',
             'pending'=>'Chờ duyệt',
             'delete'=>'Bản nháp'
         ];
         $count_page_publish=Product::where('status','publish')->count();
         $count_page_pending=Product::where('status','pending')->count();
         $count_page_delete=Product::onlyTrashed()->count();
         // $count_page_pending=Page::withTrashed()->where('status','delete')->count();
         $count=[$count_page_publish,$count_page_pending, $count_page_delete];
         return view('admin.product.list_product',compact('products','status','count','list_act','ProductCategory','option'));
    }
    //xóa vĩnh viển sản phẩm
    function forceDelete($id){
        $product=Product::withTrashed()->find($id);
        $product->forceDelete();
        return redirect('/admin/product/list')->with('status','Bạn đã xóa vĩnh viễn sản phẩm khỏi hệ thống');
 }
    //thao tác trên nhiều bản ghi
    function action(Request $request){
        
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            
            
                $act=$request->input('act');
                        if($act=="publish"){
                            foreach($list_check as $id){
                                Product::withTrashed()->with('category')->where('id',$id)->update(['status'=>'publish']);
                            }
                            return redirect('admin/product/list')->with('status','Đưa bản ghi về trạng thái công khai thành công');
                        }
                       

                        if($act=="delete"){
                            if(!empty($list_check)){
                                Product::destroy($list_check);
                                return redirect('admin/product/list')->with('status','Đã xóa thành viên thành công');
                            }
                           
                        }
                        if($act=="pending"){
                            foreach($list_check as $id){
                                Product::withTrashed()->with('category')->where('id',$id)->update(['status'=>'pending']);
                            }
                            return redirect('admin/product/list')->with('status','Đưa bản ghi về trạng thái chờ duyệt thành công');
                        }

                        if($act=="restore"){
                            if(!empty($list_check)){
                                Product::withTrashed()
                                ->whereIn('id',$list_check)
                                ->restore();
                                return redirect('admin/product/list')->with('status','Khôi phục bản ghi thành công');
                            }
                           
                        }
                        // if($act=="delete"){
                        //     foreach($list_check as $id){
                        //         Post::withTrashed()->with('category')->where('id',$id)->update(['status'=>'delete']);
                        //     }
                        //     return redirect('admin/post/list')->with('status','Đưa bản ghi về trạng thái xóa tạm thời thành công');
                        // }
                        
                        if($act=="forceDelete"){
                            Product::withTrashed()->with('category')
                            ->whereIn('id',$list_check)
                            ->forceDelete();
                            return redirect('admin/product/list')->with('status','Bạn đã xóa vĩnh viễn bài viết ra khỏi hệ thống');
                        }
            
        }else{
            return redirect('admin/product/list')->with('status','Bạn cần chọn bản ghi để thao tác');
        }
    }
    function add(){
        // $PostCategory = PostCategory::orderBy('name')->get();
       
        $ProductCategory = ProductCategory::all();
        $Colors = Colors::all();
        return view('admin.product.add_product',compact('ProductCategory','Colors'));
    }
    //xóa sản phẩm
    function delete($id){
        $product=Product::find($id);
        // dd($post);
        $product->delete();
            return redirect('admin/product/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
    //Sửa thông tin sản phẩm
    //Cập nhật
    function edit($id){
        
        // return $ImgRelativeProducts;
        $product=Product::find($id);
        // $ImgRelativeProducts = Product::find($id)->img_relative_product;
        $ImgRelativeProducts=Product::find($id)->img_relative_product;
        $ProductCategory = ProductCategory::all();
        $colors = Colors::all();
        return view('admin.product.edit_product',compact('product','ProductCategory','colors','ImgRelativeProducts'));
    }
    function update(Request $request,$id){
        $request->validate([
            'title' => 'required|string|max:255',
            // 'photos'=>'required',
            'product_desc'=>'required|string|min:10',
            'product_content'=>'required|string|min:10',
            // 'file'=>'required',
            'old_price'=>'required|integer',
            'new_price'=>'required|integer',
            'num_product'=>'required|integer',
            'status'=>'in:publish,pending',
            'category_id'=>'required',
            'color_id'=>'required'
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            'file'=>':attribute phải ở dạng file',
            'image'=>':attribute phải ở dạng ảnh .jpg,.png',
            'integer'=>':attribute phải là số nguyên'
            
        ],
        [
            
            'title'=>'Tiêu đề sản phẩm',
            'slug'=>'Đường dẫn sản phẩm',
            'product_desc'=>'Mô tả ngắn',
            'product_content'=>'Nội dung chi tiết sản phẩm',
            'file'=>'Ảnh sản phẩm',
            'old_price'=>'Giá cũ',
            'new_price'=>'Giá mới',
            'num_product'=>'Tổng sản phẩm trong kho',
            'status'=>'Trạng thái',
            'category_id'=>'Danh mục sản phẩm',
            'color_id'=>'Màu sắc của sản phẩm',
            'photos'=>'Hình ảnh liên quan'
            
        ]
        );
        $product = Product::find($id);
        //Nếu như người dùng ko chọn file ảnh thì ảnh cũ sẽ vẫn được lưu vào DB
        //Ngược lại nếu họ chọn vào ảnh mới thì ảnh mới sẽ thay thế ảnh cũ và lưu vào DB
        $image = request('file');
          if($image){
            // $destinationPath = $product->product_thumb;
            // if(file_exists($destinationPath)){
            //     unlink($destinationPath);
            // }
            $file=$request->file;
            $filename=$file->getClientOriginalName();
            $path= $file->move('public/uploads/products/',$file->getClientOriginalName());
            $thumbnail='public/uploads/products/'.$filename;

            $product=Product::where('id',$id)->update([
                'product_title'=>$request->input('title'),
                'product_desc'=>$request->input('product_desc'),
                'product_content'=>$request->input('product_content'),
                'product_thumb'=>$thumbnail,
                'old_price'=>$request->input('old_price'),
                'new_price'=>$request->input('new_price'),
                'num_product'=>$request->input('num_product'),
                'status'=>$request->input('status'),
                'category_id'=>$request->input('category_id'),
                'color_id'=>$request->input('color_id'),
                'user_id'=>Auth::id()  
                        
                    ]);
        }else{
            $product= Product::where('id',$id)->update([
                'product_title'=>$request->input('title'),
                'product_desc'=>$request->input('product_desc'),
                'product_content'=>$request->input('product_content'),
                'old_price'=>$request->input('old_price'),
                'new_price'=>$request->input('new_price'),
                'num_product'=>$request->input('num_product'),
                'status'=>$request->input('status'),
                'category_id'=>$request->input('category_id'),
                'color_id'=>$request->input('color_id'),
                'user_id'=>Auth::id()  
                
            ]);
        }
        
        //cap nhat anh chi tiet san pham 
       

        if(!empty($request->hasFile('photos'))){
            foreach($request->file('photos') as $file){
                $product_img = new ImgRelativeProduct();
                if(isset($file)){
                     
            
                    // $file=$request->file;
                    $filename=$file->getClientOriginalName();
                    $path= $file->move('public/uploads/products/detail_product/',$file->getClientOriginalName());
                    $thumbnail='public/uploads/products/detail_product/'.$filename;

                  
                    $product_img->product_id=$id;
                    $product_img->img_relative_thumb=$thumbnail;
                    // $destinationPath = $product_img->img_relative_product;
                    // if(file_exists($destinationPath)){
                    //     unlink($destinationPath);
                        
                    // }
                   
                    $product_img->save();
                   
                    
                }
            }


            // ImgRelativeProduct::where('product_id',$id)->update([
            //     'product_id'=>$id,
            //     'img_relative_thumb'=>$thumbnail
            //    ]);
        }
        return redirect('admin/product/list')->with('status','Cập nhật sản phẩm thành công');
    }

    function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'photos'=>'required',
            'product_desc'=>'required|string|min:10',
            'product_content'=>'required|string|min:10',
            'file'=>'required',
            'old_price'=>'required|integer',
            'new_price'=>'required|integer',
            'num_product'=>'required|integer',
            'status'=>'in:publish,pending',
            'category_id'=>'required',
            'color_id'=>'required'
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            'file'=>':attribute phải ở dạng file',
            'image'=>':attribute phải ở dạng ảnh .jpg,.png',
            'integer'=>':attribute phải là số nguyên'
            
        ],
        [
            
            'title'=>'Tiêu đề sản phẩm',
            'slug'=>'Đường dẫn sản phẩm',
            'product_desc'=>'Mô tả ngắn',
            'product_content'=>'Nội dung chi tiết sản phẩm',
            'file'=>'Ảnh sản phẩm',
            'old_price'=>'Giá cũ',
            'new_price'=>'Giá mới',
            'num_product'=>'Tổng sản phẩm trong kho',
            'status'=>'Trạng thái',
            'category_id'=>'Danh mục sản phẩm',
            'color_id'=>'Màu sắc của sản phẩm',
            'photos'=>'Hình ảnh liên quan'
            
        ]
        );
        if($request->hasFile('file') ){
            //ảnh đại diện
            $file=$request->file;
            $filename=$file->getClientOriginalName();
            $path= $file->move('public/uploads/products',$file->getClientOriginalName());
            $thumbnail='public/uploads/products/'.$filename;
          
            //them sp vao db
            $product=Product::create([
                'product_title'=>$request->input('title'),
                // 'slug'=>str_slug($request->input('name'),"-"),
              
                'product_desc'=>$request->input('product_desc'),
                'product_content'=>$request->input('product_content'),
                'product_thumb'=>$thumbnail,
                'old_price'=>$request->input('old_price'),
                'new_price'=>$request->input('new_price'),
                'num_product'=>$request->input('num_product'),
                'status'=>$request->input('status'),
                'category_id'=>$request->input('category_id'),
                'color_id'=>$request->input('color_id'),
                'user_id'=>Auth::id()  
            ]);
            
          
        }
       
        //xu ly upload nhieu hinh anh
        if(!empty($request->hasFile('photos'))){
            foreach($request->file('photos') as $file){
                $product_img = new ImgRelativeProduct();
                if(isset($file)){

                    // $file=$request->file;
                    $filename=$file->getClientOriginalName();
                    $path= $file->move('public/uploads/products/detail_product/',$file->getClientOriginalName());
                    $thumbnail='public/uploads/products/detail_product/'.$filename;

                  
                    $product_img->product_id=$product->id;
                    $product_img->img_relative_thumb=$thumbnail;
                    $product_img->save();

                   
                }
            }
        }
            // kiểm tra có files sẽ xử lý
		// if($request->hasFile('photos')) {
		// 	$allowedfileExtension=['jpg','png'];
		// 	$files = $request->file('photos');
        //     // flag xem có thực hiện lưu DB không. Mặc định là có
		// 	$exe_flg = true;
		// 	// kiểm tra tất cả các files xem có đuôi mở rộng đúng không
		// 	foreach($files as $file) {
		// 		$extension = $file->getClientOriginalExtension();
		// 		$check=in_array($extension,$allowedfileExtension);

		// 		if(!$check) {
        //             // nếu có file nào không đúng đuôi mở rộng thì đổi flag thành false
		// 			$exe_flg = false;
		// 			break;
		// 		}
		// 	} 
		// 	// nếu không có file nào vi phạm validate thì tiến hành lưu DB
		// 	if($exe_flg) {
        //         // lưu product
		// 		// $products= Product::create($request->all());
        //         // duyệt từng ảnh và thực hiện lưu
		// 		foreach ($request->photos as $photo) {
        //             $filename = $photo->storeAs('public/uploads/products/multiupload', $photo->getClientOriginalName());
		// 			ImgRelativeProduct::create([
		// 				'product_id' => $products->id,
		// 				'img_relative_thumb' => $filename
		// 			]);
		// 		}
		// 		echo "Upload successfully";
		// 	} else {
		// 		echo "Falied to upload. Only accept jpg, png photos.";
		// 	}
		// }
      
        return redirect('admin/product/list')->with('status','Thêm sản phẩm thành công'); 
    }
    //quan ly mau
    function list_color(){
        $product_colors = Colors::paginate(10);
        return view('admin.product.list_color',compact('product_colors'));
    }

    function store_color(Request $request){
        // return $request->all();
        $request->validate(
            [
                'name' => 'required|min:1|max:200',
                'favcolor'=>'required',
                
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',            
            ],
            [
                'name' => 'Tên màu',
                'favcolor'=>'Vui lòng chọn màu',
                'color_code'=>'Mã màu'      
                            
            ]);
           
            Colors::create([
                'name' => $request->input('name'),
                'color_code'=>$request->input('favcolor')
                             
            ]);  
            
         return redirect('admin/product/color/list')->with('status','Đã thêm màu thành công'); 
    }   
    //Xóa màu
    function delete_color($id){
        $product_color=Colors::find($id);
        $product_color->delete();
            return redirect('admin/product/color/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
}
