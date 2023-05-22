@extends('layouts.admin')
@section('content')
<script>
    function loadPreview(input){
        var data = $(input)[0].files; //this file data
        $.each(data, function(index, file){
            if(/(\.|\/)(gif|jpeg|png)$/i.test(file.type)){
                var fRead = new FileReader();
                fRead.onload = (function(file){
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image thumb element
                        $('#thumb-output').append(img);
                    };
                })(file);
                fRead.readAsDataURL(file);
            }
        });
    }
 </script>
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm 
        </div>
        <div class="card-body">
            <style>
                .thumb{
                    margin: 10px 5px 0 0;
                    width: 300px;
                }
            </style>
            <form action="{{ route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề sản phẩm</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ $product->product_title }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="slug">Slug</label>
                    <input class="form-control" type="text" name="slug" id="slug">
                    @error('slug')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label for="product_desc">Thông số kỹ thuật</label>
                    <textarea name="product_desc" class="form-control" id="product_desc" cols="30" rows="5">{{ $product->product_desc }}</textarea>
                    @error('product_desc')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_content">Chi tiết sản phẩm</label>
                    <textarea name="product_content" class="form-control" id="product_content" cols="30" rows="5">{{ $product->product_content }}</textarea>
                    @error('product_content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="old_price">Giá cũ</label>
                    <input class="form-control" type="text" name="old_price" id="old_price" value="{{ $product->old_price }}">
                    @error('old_price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_price">Giá mới</label>
                    <input class="form-control" type="text" name="new_price" id="new_price" value="{{ $product->new_price }}">
                    @error('new_price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="num_product">Tổng số lượng trong kho</label>
                    <input class="form-control" type="text" name="num_product" id="num_product" value="{{ $product->num_product }}">
                    @error('num_product')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file">Ảnh sản phẩm</label><br>
                   <input type="file" name="file" id="file"><br><br>
                   {{-- <input type="submit" value="Upload Image" name="submit"> --}}
                   <label for="current_image">Ảnh hiện tại</label><br><br>
                   <img src="{{ url($product->product_thumb) }}" style="width:300px;height:200px" alt="">
                   @error('file')
                   <small class="text-danger">{{ $message }}</small>
               @enderror
                </div>
                <div class="form-group">
                    <label for="relative_product">Hình ảnh liên quan(có thể chọn nhiều file)</label>
					<br>
					{{-- <input type="file" id="relative_product" class="form-control" name="photos[]" multiple /> --}}
                    <input type="file" id="file-input" onchange="loadPreview(this)" name="photos[]"   multiple/>

                
					<br><br>
                    <div id="thumb-output">
                       
                         @foreach ( $ImgRelativeProducts as $item)
                      
                         <img src="{{ url($item->img_relative_thumb) }}" alt="" style="width:300px;height:200px">
                         
                            
                        @endforeach 
                    </div>
                    @error('photos')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="color_id">Màu sắc</label>
                    <select class="form-control" id="color_id" name="color_id">
                      <option >Chọn màu</option>
                      @foreach($colors as $key => $color)
                      @if($color->id==$product->color_id)
                      <option selected value="{{$color->id}}">{{$color->name}}</option>
                      @else
                      <option value="{{$color->id}}">{{$color->name}}</option>
                      @endif
                  @endforeach
                      @error('color_id')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
                    </select>
                </div>
               
                <div class="form-group">
                    <label for="category_id">Danh mục sản phẩm</label>
                    <select class="form-control" id="category_id" name="category_id">
                      <option >Chọn danh mục</option>
                      @foreach($ProductCategory as $key => $cate)
                      @if($cate->id==$product->category_id)
                      <option selected value="{{$cate->id}}">{{$cate->title}}</option>
                      @else
                      <option value="{{$cate->id}}">{{$cate->title}}</option>
                      @endif
                  @endforeach
                      @error('category_id')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    @if ($product->status=='publish')
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
                </div>



                <button type="submit" class="btn btn-primary" name="btn-add" value="Cập nhật">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
<?php 
//HÀM ĐỆ QUY HIỂN THỊ CATEGORIES
function showCategories($ProductCategory, $parent_id = 0, $char = '')
{
    foreach ($ProductCategory as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($item['parent_id'] == $parent_id)
        {
            echo '<option value="'.$item->id.'">'.$char.$item->title.'</option>'; 
             
            // Xóa chuyên mục đã lặp
            unset($ProductCategory[$key]);
             
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($ProductCategory, $item['id'], $char.'---');
        }
    }
}
?>


