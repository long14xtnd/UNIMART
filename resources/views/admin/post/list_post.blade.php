@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
        <div class="alert alert-success">
                {{ session('status') }}
        </div>
    @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" name="keyword" placeholder="Tìm kiếm" value="{{ request()->input('keyword') }}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ request()->fullUrlWithQuery(['option'=>'publish']) }}" class="text-primary">Công khai<span class="text-muted">({{ $count[0] }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['option'=>'pending']) }}" class="text-primary">Chờ duyệt<span class="text-muted">({{ $count[1] }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['option'=>'delete']) }}" class="text-primary">Thùng rác<span class="text-muted">({{ $count[2] }})</span></a>
            </div>
            <form action="{{ url('admin/post/action') }}">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="act">
                    <option>Chọn</option>
                    @foreach ($list_act as $k=>$act)
                    <option value="{{ $k }}">{{ $act }}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($posts->total()>0)
                    @php
                        $t=0;
                    @endphp
                    @foreach ($posts as $post)
                       @php
                           $t++;
                       @endphp
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $post->id }}">
                        </td>
                        <th scope="row">{{ $t }}</th>
                        <td><img src="{{ url($post->post_thumb) }}" style="width:80px;height:80px" alt=""></td>
                        <td><p class="limited-text">{{ $post->title }}</p></td>
                        <td>{{ $post->category->name }}</td>
                        
                             @foreach ($status as $k=>$v )
                            @if ($k==$post->status)
                            <td>{{ $v }}</td>
                            @endif
                       
                            @endforeach
                    
                        
                        
                        <td>
                            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            @if ($option!='delete')
                            <a href="{{ route('post.delete',$post->id) }}" onclick="return confirm('Bạn có chắc muốn xóa bản ghi này')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            {{-- @else
                            <a href="{{ route('post.forceDelete',$post->id) }}" onclick="return confirm('Xóa vĩnh viễn bản ghi này')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a> --}}
                            @endif
                           
                         
                        </td>
                    </tr>
                    @endforeach
                   
                   @else
                       <tr><td class="bg-white" colspan="7">Không tìm thấy bản ghi nào</td></tr>
                   @endif


                    


                </tbody>
            </table>
        </form>
            {{$posts->links()}}
        </div>
    </div>
</div>
@endsection
<?php
//Lấy ra tên danh mục
function db_fetch_row($query_string) {
    global $conn;
    $result = array();
    $mysqli_result = db_query($query_string);
    $result = mysqli_fetch_assoc($mysqli_result);
    mysqli_free_result($mysqli_result);
    return $result;
}

function get_name_cat_by_cat_id($category_id){
    $result = db_fetch_row("SELECT * FROM `post_category` WHERE `id`='{$category_id}'");
    return $result['product_cat_title'];
}

?>