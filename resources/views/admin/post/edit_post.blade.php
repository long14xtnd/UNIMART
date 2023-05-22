@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action="{{ route('post.update',$post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ $post->title }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{ $post->post_content }}</textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file">Ảnh đại diện</label><br>
                   <input type="file" name="file" id="file"><br><br>
                   <img src="{{ url($post->post_thumb) }}" style="width:80px;height:80px" alt="">
                   {{-- <input type="submit" value="Upload Image" name="submit"> --}}
                   @error('file')
                   <small class="text-danger">{{ $message }}</small>
               @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Danh mục bài viết</label>
                    <select class="form-control" id="category_id" name="category_id">
                      <option >Chọn danh mục</option>

                      {{-- @foreach ($PostCategory as $cate)
                      <option value="{{ $cate->id }}" {{ ($cate->id==$post->category_id)?'selected':'' }} >{{ $cate->name }}</option>
                          
                      @endforeach --}}

                      @foreach($PostCategory as $key => $cate)
                      @if($cate->id==$post->category_id)
                      <option selected value="{{$cate->id}}">{{$cate->name}}</option>
                      @else
                      <option value="{{$cate->id}}">{{$cate->name}}</option>
                      @endif
                  @endforeach
                     {{-- @foreach ($PostCategory as $cate)
                        @if ($cate->parent_id==0)
                        <option {{ ($cate->id==$post->category_id) ? 'selected' : '' }} value="{{ $cate->id }}" >{{ $cate->name }}</option>
                           
                       
                        
                        @foreach ($PostCategory as $cate_sub_op)
                        @if ($cate_sub_op->parent_id!=0 && $cate_sub_op->parent_id==$cate->id)
                        <option {{ ($cate_sub_op->id==$post->category_id) ? 'selected' : '' }} value="{{ $cate_sub_op->id }}" >{{'--'. $cate_sub_op->name }}</option>
                        @endif
                        
                    @endforeach
                    @else
                   
                        @endif
                       
                     @endforeach --}}
                  
                      @error('category_id')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    @if ($post->status=='publish')
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="publish" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Công khai
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="pending" >
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    @else
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="pending" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="publish" >
                        <label class="form-check-label" for="exampleRadios1">
                          Công khai
                        </label>
                    </div>
                    @endif
                    
                 
                        @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                   
                </div>



                <button type="submit" class="btn btn-primary" name="btn-update" value="Cập nhật">Cập nhật</button>
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