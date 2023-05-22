<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\PostCategory;
use App\Post;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active'=>'post']);
            return $next($request);
        });
    }
    function add(){
        $PostCategory = PostCategory::orderBy('name')->get();
        return view('admin.post.add_post',compact('PostCategory'));
    }
    function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'file'=>'required|image|file',
            'content'=>'required|string|max:50000',
            'status'=>'in:publish,pending',
            'category_id'=>'required'
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
            
            'title'=>'Tiêu đề trang',
            'content'=>'Nội dung trang',
            'file'=>'File tải lên',
            'status'=>'Trạng thái',
            'parent_id'=>'Danh mục cha'
            
        ]
        );
        if($request->hasFile('file')){
            
            $file=$request->file;
            $filename=$file->getClientOriginalName();
            $path= $file->move('public/uploads/posts',$file->getClientOriginalName());
            $thumbnail='public/uploads/posts/'.$filename;
            Post::create([
                'title'=>$request->input('title'),
                // 'slug'=>str_slug($request->input('name'),"-"),
                'slug'=>Str::slug($request->input('title'),'-'),
                'post_content'=>$request->input('content'),
                'post_thumb'=>$thumbnail,
                'status'=>$request->input('status'),
                'user_id'=>Auth::id(),
                'category_id'=>$request->input('category_id'),
                
            ]);
        }
        return redirect('admin/post/list')->with('status','Thêm bài viết thành công'); 
    }
    //Hiển thị ds bài viết
    // function list(){
    //     $posts = Post::with('category')->paginate('10');
    //     $PostCategory = PostCategory::all();
    //     // dd($posts);
    //     return view('admin.post.list_post',compact('posts','PostCategory'));
    // }
    function list(Request $request){
        $posts = Post::with('category')->paginate('10');
        $PostCategory = PostCategory::all();
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
         
         $posts = Post::with('category')->where([
         
             ['status','pending'],
             ['title','LIKE',"%{$keyword}%"]
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
         
         $posts = Post::with('category')->where([
        
             ['status','publish'],
             ['title','LIKE',"%{$keyword}%"]
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
             $posts = Post::onlyTrashed()->with('category')->where([
 
                 
                 ['title','LIKE',"%{$keyword}%"]
                 ])->paginate(10);
        }
        else{
         $keyword=" ";
         if($request->input('keyword')){
             $keyword = $request->input('keyword');
         }
         
         $posts = Post::where('title','LIKE',"%{$keyword}%")->paginate(10);
        }
        
         $status = [
             'publish'=>'Công khai',
             'pending'=>'Chờ duyệt',
             'delete'=>'Bản nháp'
         ];
         $count_page_publish=Post::where('status','publish')->count();
         $count_page_pending=Post::where('status','pending')->count();
         $count_page_delete=Post::onlyTrashed()->count();
         // $count_page_pending=Page::withTrashed()->where('status','delete')->count();
         $count=[$count_page_publish,$count_page_pending, $count_page_delete];
         return view('admin.post.list_post',compact('posts','status','count','list_act','PostCategory','option'));
    }
    //Xóa tạm thời
    function delete($id){
        $post=Post::find($id);
        // dd($post);
        $post->delete();
            return redirect('admin/post/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
    //Xóa vĩnh viễn
    // function forceDelete($id){
    //     $post=Post::find($id);
    //     $destinationPath = $post->post_thumb;
    //     if(file_exists($destinationPath)){
    //         unlink($destinationPath);
    //     }
    //     $post->forceDelete();
    //     return redirect('/admin/post/list')->with('status','Bạn đã xóa vĩnh viễn bản ghi khỏi hệ thống');
    // }
    function forceDelete($id){
        $post=Post::withTrashed()->find($id);
        $destinationPath = $post->post_thumb;
        if(file_exists($destinationPath)){
            unlink($destinationPath);
          
           
        }
        $post->forceDelete();
        return redirect('/admin/post/list')->with('status','Bạn đã xóa vĩnh viễn bản ghi khỏi hệ thống');
 }
    //Cập nhật
    function edit($id){
        $post=Post::withTrashed()->find($id);
        $PostCategory = PostCategory::all();
        return view('admin.post.edit_post',compact('post','PostCategory'));
    }
    function update(Request $request,$id){
        $request->validate([
            'title' => 'required|string|max:255',
           
            'content'=>'required|string|max:50000',
            'status'=>'required|in:publish,pending',
            'category_id'=>'required'
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
          
            
        ],
        [
            
            'title'=>'Tiêu đề trang',
            'content'=>'Nội dung trang',
           
            'status'=>'Trạng thái',
            'category_id'=>'Danh mục '

            
        ]
        );
        $post = Post::find($id);
        //Nếu như người dùng ko chọn file ảnh thì ảnh cũ sẽ vẫn được lưu vào DB
        //Ngược lại nếu họ chọn vào ảnh mới thì ảnh mới sẽ thay thế ảnh cũ và lưu vào DB
        $image = request('file');
          if($image){
            $destinationPath = $post->post_thumb;
            if(file_exists($destinationPath)){
                unlink($destinationPath);
            }
            $file=$request->file;
            $filename=$file->getClientOriginalName();
            $path= $file->move('public/uploads/posts',$file->getClientOriginalName());
            $thumbnail='public/uploads/posts/'.$filename;

            Post::where('id',$id)->update([
                        'title'=>$request->input('title'),
                        'slug'=>Str::slug($request->input('title'),'-'),
                        'post_content'=>$request->input('content'),
                        'post_thumb'=>$thumbnail,
                        'status'=>$request->input('status'),
                        'user_id'=>Auth::id(),
                        'category_id'=>$request->input('category_id'),
                        
                    ]);
        }else{
            Post::where('id',$id)->update([
                'title'=>$request->input('title'),
                'slug'=>Str::slug($request->input('title'),'-'),
                'post_content'=>$request->input('content'),
                'status'=>$request->input('status'),
                'user_id'=>Auth::id(),
                'category_id'=>$request->input('category_id'),
                
            ]);
        }
        return redirect('admin/post/list')->with('status','Cập nhật bài viết thành công');
    }
    //thao tác trên nhiều bản ghi
    function action(Request $request){
        
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            
            
                $act=$request->input('act');
                        if($act=="publish"){
                            foreach($list_check as $id){
                                Post::withTrashed()->with('category')->where('id',$id)->update(['status'=>'publish']);
                            }
                            return redirect('admin/post/list')->with('status','Đưa bản ghi về trạng thái công khai thành công');
                        }
                       

                        if($act=="delete"){
                            if(!empty($list_check)){
                                Post::destroy($list_check);
                                return redirect('admin/post/list')->with('status','Đã xóa thành viên thành công');
                            }
                           
                        }
                        if($act=="pending"){
                            foreach($list_check as $id){
                                Post::withTrashed()->with('category')->where('id',$id)->update(['status'=>'pending']);
                            }
                            return redirect('admin/post/list')->with('status','Đưa bản ghi về trạng thái chờ duyệt thành công');
                        }

                        if($act=="restore"){
                            if(!empty($list_check)){
                                Post::withTrashed()
                                ->whereIn('id',$list_check)
                                ->restore();
                                return redirect('admin/post/list')->with('status','Khôi phục bản ghi thành công');
                            }
                           
                        }
                        // if($act=="delete"){
                        //     foreach($list_check as $id){
                        //         Post::withTrashed()->with('category')->where('id',$id)->update(['status'=>'delete']);
                        //     }
                        //     return redirect('admin/post/list')->with('status','Đưa bản ghi về trạng thái xóa tạm thời thành công');
                        // }
                        
                        if($act=="forceDelete"){
                            Post::withTrashed()->with('category')
                            ->whereIn('id',$list_check)
                            ->forceDelete();
                            return redirect('admin/post/list')->with('status','Bạn đã xóa vĩnh viễn bài viết ra khỏi hệ thống');
                        }
            
        }else{
            return redirect('admin/post/list')->with('status','Bạn cần chọn bản ghi để thao tác');
        }
    }
}
