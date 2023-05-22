<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active'=>'page']);
            return $next($request);
        });
    }

    function add(){

        return view('admin.page.add');
    }
    function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content'=>'required|string|max:50000',
            'status'=>'in:publish,pending'
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            
        ],
        [
            'name'=>'Tên trang',
            'title'=>'Tiêu đề trang',
            'content'=>'Nội dung trang',
            
        ]
        );
    // if($request->input('btn-add')){
    //     return $request->input();
    // }
    // return $request->input();
        //validate dl xong thì thêm vào DB
        
        Page::create([
            'name'=>$request->input('name'),
            // 'slug'=>str_slug($request->input('name'),"-"),
            'slug'=>Str::slug($request->input('name'),'-'),
            'title'=>$request->input('title'),
            'content'=>$request->input('content'),
            'status'=>$request->input('status'),
            'user_id'=>Auth::id()
            
        ]);
        // //chuyển hướng người dùng đến trang user.list
        return redirect('admin/page/list')->with('status','Thêm trang thành công');
    }

    //hiển thị danh sách trang
    function list(Request $request){
       $option = $request->input('option');
       $list_act=[
        'forceDelete'=>'Xóa vĩnh viễn',
        'publish'=>'Công khai',
        'pending'=>'Chờ duyệt'
    ];
   
       if($option=='pending'){
        $list_act=[
                    'publish'=>'Công khai',
                    // 'delete'=>'Xóa tạm thời',
                    'forceDelete'=>'Xóa vĩnh viễn'
                    
                ];
        $keyword=" ";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        
        $pages = Page::where([
        
            ['status','pending'],
            ['name','LIKE',"%{$keyword}%"]
            ])->paginate(10);
       }elseif($option=='publish'){
        $list_act=[
                    'pending'=>'Chờ xét duyệt',
                    // 'delete'=>'Xóa tạm thời',
                    'forceDelete'=>'Xóa vĩnh viễn'
                ];
        $keyword=" ";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        
        $pages = Page::where([
       
            ['status','publish'],
            ['name','LIKE',"%{$keyword}%"]
            ])->paginate(10);
       }elseif($option=='delete'){
            $list_act=[
                'publish'=>'Công khai',
                'pending'=>'Chờ xét duyệt',
                'forceDelete'=>'Xóa vĩnh viễn'
            ];
            $keyword=" ";
            if($request->input('keyword')){
                $keyword = $request->input('keyword');
            }

            $pages = Page::withTrashed()->where([

                ['status','delete'],
                ['name','LIKE',"%{$keyword}%"]
                ])->paginate(10);
       }
       else{
        $keyword=" ";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        
        $pages = Page::where('name','LIKE',"%{$keyword}%")->paginate(10);
       }
      
        $status = [
            'publish'=>'Công khai',
            'pending'=>'Chờ duyệt',
            'delete'=>'Thùng rác'
        ];
        $count_page_publish=Page::where('status','publish')->count();
        $count_page_pending=Page::where('status','pending')->count();
        // $count_page_pending=Page::withTrashed()->where('status','delete')->count();
        $count=[$count_page_publish,$count_page_pending];
        return view('admin.page.list',compact('pages','status','count','list_act'));
    }
    //Xóa trang
    function delete($id){
        $page=Page::find($id);
        $page->delete();
            return redirect('admin/page/list')->with('status','Bạn đã xóa bản ghi thành công');
    }
    //Xóa vĩnh viễn trang
    function forceDelete($id){
        $page=Page::withTrashed()->find($id);
        $page->forceDelete();
        return redirect('/admin/page/list')->with('status','Bạn đã xóa vĩnh viễn bản ghi khỏi hệ thống');
 }
    //Thao tác trên nhiều bản ghi
    function action(Request $request){
        
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            
            
                $act=$request->input('act');
                        if($act=="publish"){
                            foreach($list_check as $id){
                                Page::withTrashed()->where('id',$id)->update(['status'=>'publish']);
                            }
                            return redirect('admin/page/list')->with('status','Đưa bản ghi về trạng thái công khai thành công');
                        }
                       

                     
                        if($act=="pending"){
                            foreach($list_check as $id){
                                Page::withTrashed()->where('id',$id)->update(['status'=>'pending']);
                            }
                            return redirect('admin/page/list')->with('status','Đưa bản ghi về trạng thái chờ duyệt thành công');
                        }
                        
                        if($act=="forceDelete"){
                            Page::withTrashed()
                            ->whereIn('id',$list_check)
                            ->forceDelete();
                            return redirect('admin/page/list')->with('status','Bạn đã xóa vĩnh viễn trang ra khỏi hệ thống');
                        }
            
        }else{
            return redirect('admin/page/list')->with('status','Bạn cần chọn bản ghi để thao tác');
        }
    }
    //cập nhật thông tin trang
    function edit($id){
        $page=Page::find($id);
        return view('admin.page.edit',compact('page'));
    }
    function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content'=>'required|string|max:50000',
            'status'=>'in:publish,pending'
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            
        ],
        [
            'name'=>'Tên trang',
            'title'=>'Tiêu đề trang',
            'content'=>'Nội dung trang',
            
        ]
        );
        Page::where('id',$id)->update([
            'name'=>$request->input('name'),
            'slug'=>Str::slug($request->input('name'),'-'),
            'title'=>$request->input('title'),
            'content'=>$request->input('content'),
            'status'=>$request->input('status'),
            'user_id'=>Auth::id()
           ]);
    
           //chuyển hướng đến trang admin/page/list
           return redirect('admin/page/list')->with('status','Cập nhật thông tin thành công');
    }
}
