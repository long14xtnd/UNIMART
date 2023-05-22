@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Điện thoại</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <a href="" title="" id="main-thumb">
                            <div style="position:relative;">
                            <img id="zoom" src="{{ url($product->product_thumb) }}"/>
                            </div>
                        </a>
                        <div id="list-thumb">
                            @foreach ($img_relative_products as $img)
                            <a href="" data-image="{{ url($img->img_relative_thumb) }}">
                                <img id="zoom" src="{{ url($img->img_relative_thumb) }}" />
                            </a>
                            @endforeach
                           
                        
                        </div>
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="{{ url($product->product_thumb) }}" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{ $product->product_title }}</h3>
                        <div class="desc">
                            {!! $product->product_desc !!}
                           
                        </div>
                        @if ($product->num_product!=0)
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">Còn hàng</span>
                        </div>
                        <p class="price"> {{number_format($product->new_price, 0, '' ,'.')}}đ</p>
                        <form method="get" id="num-order-wp" action="{{route('cart.add',$product->id)}}">
                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                            <input type="text" name="num-order" value="1" id="num-order">
                            <a title="" id="plus"><i class="fa fa-plus"></i></a><hr>
                            <input type="submit" value="Thêm giỏ hàng" class="add-cart">
                        </form>
                       
                        {{-- <a href="{{ route('cart.add',$product->id) }}" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a> --}}
                        @else
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">Hết hàng</span>
                        </div>
                        <p class="price"> {{number_format($product->new_price, 0, '' ,'.')}}đ</p>
                        {{-- <div id="num-order-wp">
                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                            <input type="text" name="num-order" value="1" id="num-order">
                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                        </div> --}}
                         <a href="?page=cart" title="Thêm giỏ hàng" onclick="return confirm('Hết hàng?')" class="add-cart">Thêm giỏ hàng</a>
                        @endif
                        
                        
                       
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="detail">
                    {!! $product->product_content !!}
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    
                    <ul class="list-item">
                        @foreach ($products_with_cat as $product)
                        <li>
                            <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="thumb">
                                <img src="{{ url($product->product_thumb) }}">
                            </a>
                            <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="product-name">{{ $product->product_title }}</a>
                            <div class="price">
                                <span class="new"> {{number_format($product->new_price, 0, '' ,'.')}}đ</span>
                                <span class="old"> {{number_format($product->old_price, 0, '' ,'.')}}đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{  route('cart.add',$product->id)  }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{  route('checkout.buynow',$product->id)  }}" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                        
                       
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            @include('home.inc.sidebar')
            @include('home.inc.banner')
        </div>
    </div>
</div>
@endsection