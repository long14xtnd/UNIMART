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
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" name="keyword" placeholder="Nhập mã hóa đơn" value="{{ request()->input('keyword') }}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
              
                <a href="{{ request()->fullUrlWithQuery(['status'=>'shipping']) }}" class="text-primary">Đang xử lý<span class="text-muted">({{ $count[0] }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status'=>'complete']) }}" class="text-primary">Hoàn thành<span class="text-muted">({{ $count[1] }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status'=>'cancel']) }}" class="text-primary">Đã hủy<span class="text-muted">({{ $count[2] }})</span></a>
            </div>
            <form action="{{ url('admin/order/action') }}">
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
                        <th>
                            <input type="checkbox" name="">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mã hóa đơn</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Điện thoại</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Chi tiết</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->total()>0)
                    @php
                    $t=0;
                    @endphp
                    @foreach ($orders as $order)
                        @php
                        $t++;
                    @endphp
                   <tr>
                    <td>
                        <input type="checkbox" name="list_check[]" value="{{ $order->id }}">
                    </td>
                    <td>{{ $t }}</td>
                    <td><a href="{{ route('order.detail',$order->id) }}">{{ $order->order_code }}</a></td>
                    <td>
                        {{ $order->customer->fullname }}
                       
                    </td>
                    <td>{{ $order->customer->address }}</td>
                    <td> {{ $order->customer->phone }}</td>
                     
                        @if ($order->status=='shipping')
                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                        @elseif ($order->status=='complete')
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        @elseif ($order->status=='cancel')
                        <td><span class="badge badge-dark">Đã hủy</span></td>
                        @endif
                    <td>{{ $order->date_order }}</td>
                    <td><a href="{{ route('order.detail',$order->id) }}">Chi tiết</a></td>
                    <td>
                        <a href="{{ route('order.edit',$order->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('order.delete',$order->id) }}" onclick="return confirm('Bạn có chắc muốn xóa bản ghi này')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                    @endforeach
                    
                    @else
                    <tr><td class="bg-white" colspan="9">Không tìm thấy bản ghi nào</td></tr>
                    @endif
                   
                    

                </tbody>
            </table>
        </form>
            {{ $orders->links() }}
            {{-- <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Trước</span>
                            <span class="sr-only">Sau</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav> --}}
        </div>
    </div>
</div>
@endsection