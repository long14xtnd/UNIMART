@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        @if (Cart::count()>0)
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Mã sản phẩm</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td colspan="2">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $cart)
                        <tr>
                            <td>PRODUCT{{ $cart->id }}</td>
                            <td>
                                <a href="{{ route('product.detail',Str::slug($cart->name)) }}" title="" class="thumb">
                                    <img src="{{ asset($cart->options->thumbnail) }}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('product.detail',Str::slug($cart->name)) }}" title="" class="name-product">{{ $cart->name }}</a>
                            </td>
                            <td>{{number_format($cart->price, 0, '' ,'.')}}đ</td>
                            <td>
     
                                <input type="number" data-rowId="{{ $cart->rowId }}" name="qty[{{ $cart->rowId }}]" value="{{ $cart->qty }}" min="1" max="{{$cart->options->max_qty  }}" class="num-order">
                            </td>
                            <td id="sub-total-{{$cart->rowId}}">{{ number_format($cart->subtotal, 0, '', '.') }}đ</td>
                            <td>
                                <a href="{{ route('cart.remove', $cart->rowId) }}" title="" class="del-product"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                      
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span>{{ Cart::subtotal(0, '', '.') }}đ</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                           
                            <td colspan="7">
                                
                                <div class="clearfix">
                                    <div class="fl-right">
                                        <a href="{{ route('cart.destroy') }}" title="" onclick="return confirm('Bạn muốn xóa toàn bộ giỏ hàng?')" id="update-cart">Xóa giỏ hàng</a>
                                        <a href="{{ url('thanh-toan.html') }}" title="" id="checkout-cart">Thanh toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                {{-- <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p> --}}
                <a href="{{ url('/') }}" title="" id="buy-more">Mua tiếp</a><br/>
                {{-- <a href="{{ route('cart.destroy') }}" title="" onclick="return confirm('Bạn muốn xóa toàn bộ giỏ hàng?')" id="delete-cart">Xóa giỏ hàng</a> --}}
            </div>
        </div>
        @else
            <div class="section" id="empty-cart" style="text-align: center; align-items: center; justify-content: center;">
           
           
                <img src="{{ url('public/images/empty-cart.png') }}" alt="" style="display:inline">
                {{-- <p style="font-size: 2.5rem; font-weight: bold; font-style: italic;   line-height: 40px; color: #857fa6; font-family: 'Varela Round' " >Giỏ hàng rỗng</p> --}}
                <div>
                    <a href="{{ url('/') }}" class="btn btn-danger" style=" border: 1px solid #2f80ed; border-radius: 5px;    color: white;    display: block;    margin: 0 auto;    max-width: 340px;    padding: 10px 5px; text-align: center;margin-top: 40px;">BẮT ĐẦU SHOPPING</a>
            </div>
            </div>
            
        @endif
        
    </div>
</div>
@endsection