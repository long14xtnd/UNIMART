<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductCategoryController extends Controller
{
    //
     //
     function list(){
        //Lấy danh sách các danh mục để hiển thị trên table
        $ProductCategorys = ProductCategory::orderBy('id','ASC')->paginate(15);
        
        
        // Lấy danh mục
        $ProductCategory = ProductCategory::orderBy('title', 'ASC')->get();
       return view('admin.product.list_cat', compact('ProductCategory', 'ProductCategorys'));
    }
    function delete($id){
        $ProductCategory=ProductCategory::find($id);
        $ProductCategory->delete();
            return redirect('admin/product/cat/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
    function edit($id){
        $ProductCategorys = ProductCategory::all();
        $ProductCategory = ProductCategory::find($id);

        return view('admin.product.edit_list_cat',compact('ProductCategory','ProductCategorys'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name' => 'required|min:3|max:200',
                'slug' => 'required:unique:post_category',
                'parent_cat' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',            
            ],
            [
                'name' => 'Tên danh mục',
                'slug' => 'Đường dẫn danh mục',  
                'parent_cat'=>'Danh mục cha'           
                            
            ]);

            ProductCategory::where('id',$id)->update([
                'title'=>$request->input('name'),
                'slug'=>Str::slug($request->input('slug'),'-'),
                'parent_id'=>$request->input('parent_cat'),
                'user_id'=>Auth::id()
               ]);

             return redirect('admin/product/cat/list')->with('status','Cập nhật danh mục thành công'); 

    }

    function store(Request $request){
        $request->validate(
            [
                'name' => 'required|min:3|max:200',
                'slug' => 'required:unique:post_category',
                'parent_cat' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',            
            ],
            [
                'name' => 'Tên danh mục',
                'slug' => 'Đường dẫn danh mục',  
                'parent_cat'=>'Danh mục cha'           
                            
            ]);
           
            ProductCategory::create([
                'title' => $request->input('name'),
                'slug'=>Str::slug($request->input('slug'),'-'), 
                'parent_id' => $request->input('parent_cat'), 
                'user_id'=>Auth::id()   
                             
            ]);  
            
         return redirect('admin/product/cat/list')->with('status','Đã thêm danh mục thành công'); 

    }
}
