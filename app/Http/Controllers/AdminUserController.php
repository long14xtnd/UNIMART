<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    function __construct()
    {
        $this->middleware(function($request,$next){
            session(['module_active'=>'user']);
            return $next($request);
        });
    }
    
    //Hiển thị danh sách user
    //thuật toán tìm kiếm
    // Lúc đầu khi chưa nhập gì thì keyword= rỗng,khi ng dùng nhập vào ký tự bất kì để tìm kiếm thì $keyword sẽ là từ khóa đó
    //lúc này ta tiến hành lấy ra những user mà có tên giống với tên của kết quả tìm kiếm
    function list(Request $request){  
        $status = $request->input('status');
        $list_act=[
            'delete'=>'Xóa tạm thời'
        ];
        if($status=='trash'){
            $list_act=[
                'restore'=>'Khôi phục',
                'forceDelete'=>'Xóa vĩnh viễn'
            ];
            $users = User::onlyTrashed()->paginate(10);
        }else{
            $keyword=" ";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        // return $request->input('keyword');  
        $users = User::where('name','LIKE',"%{$keyword}%")->paginate(10);
        }
        
        $count_user_active=User::count();
        $count_user_trash=User::onlyTrashed()->count();
        $count=[$count_user_active,$count_user_trash];
        
        
        return view('admin.user.list',compact('users','count','list_act','status'));
    }
    //Thêm user
        //giao diện thêm người dùng
    function add(){
        
        return view('admin.user.add');
    }
        //nơi xử lý submit form
    function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],
        //Thiết lập câu tiếng việt báo lỗi
        [
            'required'=>':attribute không được để trống',
            'min'=>':attribute có độ dài ít nhất :min kí tự',
            'max'=>':attribute có độ dài tối đa :max kí tự',
            'confirmed'=>':attribute Xác nhận mật khẩu không thành công'
        ],
        [
            'name'=>'Tên người dùng',
            'email'=>'Email',
            'password'=>'Mật khẩu'
        ]
    );
    
        //validate dl xong thì thêm vào DB
        User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        //chuyển hướng người dùng đến trang user.list
        return redirect('admin/user/list')->with('status','Thêm thành viên thành công');
    }

    //Xóa user trong hệ thống
    function delete($id){
        //Thuật toán:muốn xóa được user thì phải xem đó là user nào dựa vào id
        //thứ 2 là phải kiểm tra cái user cần xóa phải khác với user đang đăng nhập tức là chính cta
        //sau khi xóa xong cần chuyển hướng ng dùng là xuất ra thông báo
        if(Auth::id()!=$id){
            $user = User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('status','Bạn đã xóa thành viên thành công');
        }else{
            return redirect('admin/user/list')->with('status','Bạn không thể tự xóa chính mình ra khỏi hệ thống');
        }
        
        
    }
    //thao tác trên nhiều bản ghi
    //Thuật toán: 
    //1.Cần lấy ra được danh sách các bản ghi được chọn thông qua id của từng bản ghi (list_check)
    //2.Sau khi lấy ra được ds bản ghi cần phải foreach mảng để kiểm tra xem phần tử ta chọn có trùng với bản ghi đang login hay ko,nếu có cần unset nó ra khỏi mảng
    //3.sau khi unset ptử đang login ra khỏi mảng xong,nếu như mảng vẫn khác rỗng thì ta xem action lúc này là gì
    //4.nếu là delete thì là xóa tạm thời->chuyển hướng
    //5.nếu là restore thì khôi phục bản ghi->chuyển hướng
    //6.nếu là xóa vĩnh viễn thì xóa vĩnh viễn bản ghi->chuyển hướng
    function action(Request $request){
        
        $list_check = $request->input('list_check');
        if($list_check){
            foreach($list_check as $k=>$id){
                if(Auth::id()==$id){
                    unset($list_check[$k]);
                }
            }
            if(!empty($list_check)){
                $act=$request->input('act');
                if($act=="delete"){
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status','Đã xóa thành viên thành công');
                }
                if($act=="restore"){
                    User::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();
                    return redirect('admin/user/list')->with('status','Khôi phục thành viên thành công');
                }
                //xóa vĩnh viễn
                if($act='forceDelete'){
                    User::withTrashed()
                    ->whereIn('id',$list_check)
                    ->forceDelete();
                    return redirect('admin/user/list')->with('status','Bạn đã xóa vĩnh viễn user ra khỏi hệ thống');
                }
            }
            return redirect('admin/user/list')->with('status','Bạn không thể tự xóa chính mình ra khỏi hệ thống');
        }else{
            return redirect('admin/user/list')->with('status','Bạn cần chọn bản ghi để thao tác');
        }
       
       
    }
    //xóa vĩnh viễn user ra khỏi hệ thống
    function forceDelete($id){
           $user=User::withTrashed()->find($id);
           $user->forceDelete();
           return redirect('/admin/user/list')->with('status','Bạn đã xóa vĩnh viễn user khỏi hệ thống');
    }
    //Cập nhật thông tin user
    function edit($id){
        $user=User::withTrashed()->find($id);
        return view('admin.user.edit',compact('user'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'required'=>':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min kí tự',
                'max' => ':attribute có độ dài tối đa :max kí tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name'=>'Tên người dùng',
                'password'=>'Mật khẩu'
            ]
        );

        User::withTrashed()->where('id',$id)->update([
            'name'=>$request->input('name'),
            'password'=>Hash::make($request->input('password'))
           ]);
    
           //chuyển hướng đến trang admin/user/list
           return redirect('admin/user/list')->with('status','Cập nhật thông tin thành công');

    }

}
