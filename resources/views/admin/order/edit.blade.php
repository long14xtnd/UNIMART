@extends('layouts.admin')
@section('content')

<div id="content" class="container">
<div class="card">
<div class="card-header font-weight-bold">
    Cập nhật đơn hàng
</div>
<div class="card-body">
    <form action='{{ route('order.update',$order->id)}}' method="POST" >
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="code">Mã đơn hàng</label>
                    <input class="form-control" type="text" name="code" id="code" value="{{ $order->order_code }}" readonly="readonly">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="customer">Tên khách hàng</label>
                    <input class="form-control" type="text" name="customer" id="customer" value="{{ $order->customer->fullname }}" readonly="readonly">
                </div>
            </div>
                <div class="col-6">
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input class="form-control" type="text" name="phone" id="phone" value="{{ $order->customer->phone }}" >
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ $order->customer->email }}" readonly="readonly">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input class="form-control" type="text" name="address" id="address" value="{{ $order->customer->address }}" >
                    @error('address')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
                <div class="col-6">
                <div class="form-group">
                    <label for="product_qty">Ngày đặt</label>
                    <input class="form-control" type="text" name="date_order" id="date_order" value="{{ $order->date_order }}" readonly="readonly">
                </div>
                </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="total_price">Giá trị</label>
                    <input class="form-control" type="text" name="total_price" id="total_price" value="{{ $order->total}}VNĐ" readonly="readonly">
                </div>
            </div>
            <div class="col-6">

                <div class="form-group">
                    <label for="">Trạng thái</label>

                    <select class="form-control" id="status" name="status">
                        <option value="" selected> -- Trạng thái -- </option>  
                        @if ($order->status=='shipping')
                        <option value="shipping" selected='selected'>Đang xử lý</option>
                        <option value="complete">Hoàn thành </option>
                        <option value="cancel">Đã hủy </option>
                        @elseif ($order->status=='complete')
                        <option value="complete" selected='selected'>Hoàn thành </option>
                        <option value="shipping">Đang xử lý</option>
                        <option value="cancel">Đã hủy </option>
                        @elseif ($order->status=='cancel')
                        <option value="cancel" selected='selected'>Đã hủy </option>
                        <option value="shipping">Đang xử lý</option>
                        <option value="complete">Hoàn thành </option>
                        @endif                 
                     
                       
                       
                    </select>
                </div>
                                                        

                                               
            </div>
        </div>
        <div class="col-4 float-right">
            <button type="submit"  class="btn btn-primary text-center" name="btn-update" value="Cập nhật">Cập nhật</button>
        </div>

    </form>
</div>
</div>

@endsection