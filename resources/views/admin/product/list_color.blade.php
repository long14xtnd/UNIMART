@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm màu sắc
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/product/color/store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên màu</label>
                            <input class="form-control" type="text" name="name" id="name">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="favcolor">Chọn màu</label><br>
                            <input type="color" id="favcolor" name="favcolor" value="#ff0000" style="width:290px">
                            @error('favcolor')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="color_code">Mã màu</label>
                            <input class="form-control" type="text" name="color_code" id="color_code">
                            @error('color_code')
                             <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
                       
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
                                <th scope="col">STT</th>
                                <th scope="col">Tên màu</th>
                                <th scope="col">Mã màu</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($product_colors->total()>0)
                    @php
                        $t=0;
                    @endphp
                    @foreach ($product_colors as $item)
                       @php
                           $t++;
                       @endphp
                    <tr>
                        
                        <th scope="row">{{ $t }}</th>
                        <td>{{ $item->name }}</td>

                        <td>{{ $item->color_code }}</td>
                       
                        <td>
                         
                            <a href="{{ route('product.delete_color',$item->id) }}" onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                           
                           
                        </td>
                    </tr>
                    @endforeach
                   
                   @else
                       <tr><td class="bg-white" colspan="7">Không tìm thấy bản ghi nào</td></tr>
                   @endif
                        </tbody>
                    </table>
                    {{$product_colors->links()}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
