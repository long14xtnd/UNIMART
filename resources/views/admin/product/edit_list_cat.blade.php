@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Chỉnh sửa danh mục
                </div>
                <div class="card-body">
                    <form action="{{ route('ProductCategory.update',$ProductCategory->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $ProductCategory->title }}">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Tên đường dẫn</label>
                            <input class="form-control" type="text" name="slug" id="slug" value="{{ $ProductCategory->slug }}">
                            @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="parent_cat">
                                <option value="0">Chọn danh mục(Mặc định là danh mục cha)</option>
                                <?php 
                                showCategories($ProductCategorys) 
                                ?>
                            </select>
                            @error('parent_cat')
                             <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                       
                        <button type="submit" name="btn-update" value="Cập nhật" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- <div class="col-8">
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
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Đường dẫn</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (5>3)
                            @php
                                $t=0;
                            @endphp   
                            @foreach ($PostCategory as $item)
                             @php
                                $t++;
                             @endphp
                                 <tr>
                                    <th scope="row">{{ $t }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>
                                        <a href="{{ route('PostCategory.edit',$item->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('PostCategory.delete',$item->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr><td class="bg-white" colspan="3">Không tìm thấy bản ghi nào</td></tr>
                            @endif
                            
                           
                            
                        </tbody>
                    </table>
                    {{ $PostCategory->links() }}
                </div>
            </div>
        </div> --}}
    </div>

</div>
@endsection
<?php 
//HÀM ĐỆ QUY HIỂN THỊ CATEGORIES
function showCategories($PostCategorys, $parent_id = 0, $char = '')
{
    foreach ($PostCategorys as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($item['parent_id'] == $parent_id)
        {
            echo '<option value="'.$item->id.'">'.$char.$item->title.'</option>'; 
             
            // Xóa chuyên mục đã lặp
            unset($PostCategorys[$key]);
             
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($PostCategorys, $item['id'], $char.'---');
        }
    }
}
?>
