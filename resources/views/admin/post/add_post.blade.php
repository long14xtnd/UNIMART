@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action="{{ url('admin/post/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="title">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file">Ảnh đại diện</label><br>
                   <input type="file" name="file" id="file"><br><br>
                   {{-- <input type="submit" value="Upload Image" name="submit"> --}}
                   @error('file')
                   <small class="text-danger">{{ $message }}</small>
               @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Danh mục bài viết</label>
                    <select class="form-control" id="category_id" name="category_id">
                      <option >Chọn danh mục</option>
                      <?php showCategories($PostCategory) ?>
                      @error('category_id')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="publish" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Công khai
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="pending">
                        <label class="form-check-label" for="exampleRadios2">
                          Chờ duyệt
                        </label>
                        @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>
                </div>



                <button type="submit" class="btn btn-primary" name="btn-add" value="Thêm mới">Thêm mới</button>
            </form>
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