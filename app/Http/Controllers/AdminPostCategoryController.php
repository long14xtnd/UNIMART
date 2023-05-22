<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostCategoryController extends Controller
{
    //
    function list(){
        //Lấy danh sách các danh mục để hiển thị trên table
        $PostCategorys = PostCategory::orderBy('id','ASC')->paginate(10);
        
       
        // Lấy danh mục
        $PostCategory = PostCategory::orderBy('name', 'ASC')->get();
       return view('admin.post.list_cat', compact('PostCategory', 'PostCategorys'));
    }
    function delete($id){
        $PostCategory=PostCategory::find($id);
        $PostCategory->delete();
            return redirect('admin/post/cat/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
    function edit($id){
        $PostCategorys = PostCategory::all();
        $PostCategory = PostCategory::find($id);

        return view('admin.post.edit_list_cat',compact('PostCategory','PostCategorys'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name' => 'required|min:5|max:200',
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

            PostCategory::where('id',$id)->update([
                'name'=>$request->input('name'),
                'slug'=>Str::slug($request->input('slug'),'-'),
                'parent_id'=>$request->input('parent_cat'),
                'user_id'=>Auth::id()
               ]);

             return redirect('admin/post/cat/list')->with('status','Cập nhật danh mục thành công'); 

    }

    function store(Request $request){
        $request->validate(
            [
                'name' => 'required|min:5|max:200',
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
           
            PostCategory::create([
                'name' => $request->input('name'),
                'slug'=>Str::slug($request->input('slug'),'-'), 
                'parent_id' => $request->input('parent_cat'), 
                'user_id'=>Auth::id()   
                             
            ]);  
            
         return redirect('admin/post/cat/list')->with('status','Đã thêm danh mục thành công'); 

    }
}
