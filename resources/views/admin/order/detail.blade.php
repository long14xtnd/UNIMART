@extends('layouts.admin')
@section('content')

<div id="content" class="container">
<div class="px-1 py-3">
<a class="btn btn-secondary" href="{{ url('/dashboard') }}">
    <i class="fas fa-chevron-circle-left mr-1"></i>
    Quay lại danh sách đơn hàng
</a>
</div>

<div class="row">
    <div class="col-5">
        <div class="card">
            <div class="card-header">
                <h5>Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="title">
                            <i class="fas fa-barcode text-primary mr-1"></i>
                            <strong>Mã đơn hàng</strong>
                        </div>
                        <div class="content mt-2">
                            {{ $order->order_code }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="title">
                            <i class="fas fa-cash-register text-primary mr-1"></i>
                            <strong>Hình thức thanh toán</strong>
                        </div>
                        <div class="content mt-2">
                          @if ($order->payment=='home')
                              Thanh toán tại nhà
                            @elseif ($order->payment=='store')
                            Thanh toán tại cửa hàng
                          @endif
                                                                </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="title">
                            <i class="fas fa-map-marked-alt text-primary mr-1"></i>
                            <strong>Địa chỉ nhận</strong>
                        </div>
                        <div class="content mt-2">
                            {{ $order->customer->address }}
                        </div>
                    </div>
    
                    <div class="col-6 mt-3">
                        <div class="title">
                            <i class="fas fa-shipping-fast text-primary mr-1"></i>
                            <strong>Trạng thái đơn hàng</strong>
                        </div>
                        <div class="content mt-2" >
                                <div class="input-group">
                                    @if ($order->status=='shipping')
                                        Đang xử lý
                                    @elseif ($order->status=='complete')
                                         Hoàn thành
                                    @else
                                    Đã hủy
                                    @endif
                                         
                                                                                       </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h5>Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-7">
                        <div class="title">
                            <i class="fas fa-user text-primary mr-1"></i>
                            <strong>Tên khách hàng</strong>
                        </div>
                        <div class="content mt-1">
                         {{ $order->customer->fullname }}
                        </div>
                    </div>
    
                    <div class="col-5">
                        <div class="title">
                            <i class="fas fa-phone-volume text-primary mr-1"></i>
                            <strong>Điện thoại</strong>
                        </div>
                        <div class="content mt-1">
                            {{ $order->customer->phone }}
                        </div>
                    </div>
    
                    <div class="col-12 mt-2">
                        <div class="title">
                            <i class="fas fa-at text-primary mr-1"></i>
                            <strong>Email</strong>
                        </div>
                        <div class="content mt-1">
                            {{ $order->customer->email }}
                        </div>
                    </div>
    
                    <div class="col-12 mt-2">
                        <div class="title">
                            <i class="fas fa-comment text-primary mr-1"></i>
                            <strong>Ghi Chú</strong>
                        </div>
                        <div class="content mt-1">
                            {{ $order->customer->note }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <h5>Tổng giá trị đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="section">
                    <strong>Tổng số sản phẩm:</strong><span class="ml-2">{{ $sum_qty }} </span>
                </div>
                <div class="section">
                    <strong class="text-danger">
                        Tổng giá trị:
                    </strong><span class="text-danger font-weight-bold ml-2">{{ number_format($order->total, 0, '', '.') }}VNĐ</span>
                </div>
            </div>
        </div>
        <div class="card">
            <a  target="_blank" class="btn btn-success py-2" href="">In hóa đơn</a>
        </div>
    
    </div>
    
    </div>
    
    <div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Danh sách sản phẩm</h5>
            </div>
            <div class="card-body">
                <table class="table info-exhibition">
                    <thead>
                    <tr>
                        <th class="thead-text">STT</th>
                        <th class="thead-text">Ảnh sản phẩm</th>
                        <th class="thead-text">Tên sản phẩm</th>
                        <th class="thead-text">Đơn giá</th>
                        <th class="thead-text">Số lượng</th>
                        <th class="thead-text">Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                           @foreach ($detail_orders as $detail_order)
                           <tr>
                           <td class="thead-text">1</td>
                           <td class="thead-text">
                               <div class="thumb">
                                   <img src="{{ url($detail_order->product->product_thumb) }}" class="img-thumbnail" width="100" alt="">
                               </div>
                           </td>
                           <td class="thead-text">{{ $detail_order->product->product_title }}</td>
                           <td class="thead-text">{{ number_format($detail_order->product->new_price, 0, '', '.') }}VNĐ</td>
                           <td class="thead-text">{{ $detail_order->qty }}</td>
                           <td class="thead-text">{{ number_format($detail_order->price, 0, '', '.') }}VNĐ</td>
                           @endforeach                                                                                                 <tr>
                           
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>



</div>


@endsection