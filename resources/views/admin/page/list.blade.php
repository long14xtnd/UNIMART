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
            <h5 class="m-0 ">Danh sách các trang</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" name="keyword" placeholder="Tìm kiếm" value="{{ request()->input('keyword') }}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                {{-- @foreach ($status as $k=>$v)
                
                <a href="{{ request()->fullUrlWithQuery(['status'=>"$k"]) }}" class="text-primary">{{ $v }}<span class="text-muted">(@foreach ($count as $c)
                    {{ $c }}
                @endforeach)</span></a>
              
                @endforeach --}}
                <a href="{{ request()->fullUrlWithQuery(['option'=>'publish']) }}" class="text-primary">Công khai<span class="text-muted">({{ $count[0] }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['option'=>'pending']) }}" class="text-primary">Chờ duyệt<span class="text-muted">({{ $count[1] }})</span></a>
                {{-- <a href="{{ request()->fullUrlWithQuery(['option'=>'delete']) }}" class="text-primary">Thùng rác<span class="text-muted">(100)</span></a> --}}
            </div>
            <form action="{{ url('admin/page/action') }}">
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
                        <th scope="col">STT</th>
                        <th scope="col">Tên trang</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                   
                    {{-- <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td scope="row">1</td>
                        <td><img src="http://via.placeholder.com/80X80" alt=""></td>
                        <td><a href="">Giá xăng sẽ tiếp tục tăng ở mức cao, lần thứ 4 liên tiếp vào ngày mai?</a></td>
                        <td>Tin nóng</td>
                        <td>26:06:2020 14:00</td>
                        <td><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                        </td>

                    </tr> --}}
                    @if ($pages->total()>0)
                    @php
                        $t=0;
                    @endphp
                    @foreach ($pages as $page)
                       @php
                           $t++;
                       @endphp
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $page->id }}">
                        </td>
                        <th scope="row">{{ $t }}</th>
                        <td>{{ $page->name }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>{{ $page->created_at }}</td>
                        @foreach ($status as $k=>$v )
                            @if ($k==$page->status)
                            <td>{{ $v }}</td>
                            @endif
                       
                        @endforeach
                        
                        <td>
                            <a href="{{ route('page.edit',$page->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('page.forceDelete',$page->id) }}" onclick="return confirm('Xóa vĩnh viễn bản ghi này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                   
                   @else
                       <tr><td class="bg-white" colspan="7">Không tìm thấy bản ghi nào</td></tr>
                   @endif


                </tbody>
            </table>
        </form>
            {{ $pages->links() }}
        </div>
    </div>
</div>
@endsection

