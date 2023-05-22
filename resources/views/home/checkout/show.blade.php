@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form action="{{ url('checkout/store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div id="wrapper" class="wp-inner clearfix">
       
           
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                  
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="fullname" id="fullname" >
                                @error('fullname')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            
                            <div class="form-col fl-right">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" >
                                @error('email')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <label for="address">Địa chỉ:</label>
                            <div class="form-col fl-left">
                                <label for="province">Tỉnh/Thành Phố</label>
                                <select name="province" class="province form-control">
                                    <option value="">-- Chọn Tỉnh/Thành Phố--</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}"> {{ ucfirst($province->name) }}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-left">
                                <label for="district">Quận/Huyện</label>
                                <select name="district" class="district form-control">
                                    <option value="">-- Chọn quận/huyện --</option>                  
                                </select>
                                @error('district')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-left">
                                <label for="ward">Xã/Phường</label>
                                <select name="ward" class="ward form-control">
                                    <option value="">-- Chọn Xã/Phường --</option>                  
                                </select>
                                @error('ward')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            
                            <div class="form-col fl-right">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone">
                                @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" id="address" placeholder="Số nhà,tên đường...">
                                @error('address')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="note">Ghi chú</label>
                                <textarea name="note"></textarea>
                            </div>
                        </div>
                    
                </div>
               
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Cart::count()>0)
                                @foreach (Cart::content() as $item)
                                <tr class="cart-item">
                                    <td class="product-name">{{ $item->name }}<strong class="product-quantity">x {{ $item->qty }}</strong></td>
                                    <td class="product-total">{{ number_format($item->subtotal, 0, '', '.') }}đ</td>
                                </tr>
                                @endforeach
                            @endif
                           
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price">{{ Cart::subtotal(0, '', '.') }}đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <ul id="payment_methods">
                            <li>
                                <input type="radio" id="direct-payment" name="payment-method" value="store" >
                                <label for="direct-payment">Thanh toán tại cửa hàng</label>
                            </li>
                            <li>
                                <input type="radio" id="payment-home" name="payment-method" value="home" checked>
                                <label for="payment-home">Thanh toán tại nhà</label>
                            </li>
                        </ul>
                    </div>
                    <div class="place-order-wp clearfix">
                        <input type="submit" name="order-now" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        
       
    </div>
    </form>
</div>

@endsection