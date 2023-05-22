@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm danh mục
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/post/cat/store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Tên đường dẫn</label>
                            <input class="form-control" type="text" name="slug" id="slug">
                            @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="parent_cat">
                                <option value="0">Chọn danh mục(Mặc định là danh mục cha)</option>
                                <?php showCategories($PostCategory) ?>
                                
                            </select>
                            @error('parent_cat')
                             <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                       
                        <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                            {{ session('status') }}
                    </div>
                @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Đường dẫn</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php tablePostCategory($PostCategorys) ?>
                        </tbody>
                    </table>
                    {{$PostCategorys->links()}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
<?php 
//HÀM ĐỆ QUY HIỂN THỊ CATEGORIES
function showCategories($PostCategory, $parent_id = 0, $char = '')
{
    foreach ($PostCategory as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($item['parent_id'] == $parent_id)
        {
            echo '<option value="'.$item->id.'">'.$char.$item->name.'</option>'; 
             
            // Xóa chuyên mục đã lặp
            unset($PostCategory[$key]);
             
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($PostCategory, $item['id'], $char.'---');
        }
    }
}
?>
<?php
//ham xuat du lieu bang menu da cap su dung de quy
function tablePostCategory($PostCategorys, $parent_id = 0, $char = ''){
    $t = 0; 
    foreach($PostCategorys as $category => $item){
        $t++;
        if($item->parent_id == $parent_id ){
         
            echo '<tr>';
                echo '<th scope="row">';
                    echo $item->id;
                echo '</th>';
                echo '<td>';
                    echo $char . $item->name;
                echo '</td>';
                echo '<td>';
                    echo $item->slug;
                echo '</td>';
               
                echo '<td>';
                    echo '<a href="'.route('PostCategory.edit',$item->id).' " class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="'.route('PostCategory.delete',$item->id).'" onclick="return confirm(\'Xóa vĩnh viễn bản ghi này?\')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>';
                            
                        
                echo '</td>';
            echo '</tr>';    

            unset($PostCategorys[$category]);

            tablePostCategory($PostCategorys, $item->id, $char.' --');
        }
    }
}

?>
