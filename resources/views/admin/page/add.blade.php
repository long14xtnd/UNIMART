@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm trang
        </div>
        <div class="card-body">
            <form action="{{ url('admin/page/store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên trang</label>
                    <input class="form-control" type="text" name="name" id="name">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="title">Tiêu đề trang</label>
                    <input class="form-control" type="text" name="title" id="title">
                    @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung trang</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                {{-- <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="">
                      <option>Chọn danh mục</option>
                      <option>Danh mục 1</option>
                      <option>Danh mục 2</option>
                      <option>Danh mục 3</option>
                      <option>Danh mục 4</option>
                    </select>
                </div> --}}
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                  
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="pending" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="publish">
                        <label class="form-check-label" for="exampleRadios2">
                          Công khai
                        </label>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary" name="btn-add" value="Thêm mới">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
