@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $orders_complete->count() }}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $orders_shipping->count() }}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($sales, 0, '', '.') }}đ</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $orders_cancel->count() }}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
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
                        <th scope="col">Mã hóa đơn</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số điện thoại</th>
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
            {{$orders->links()}}
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
