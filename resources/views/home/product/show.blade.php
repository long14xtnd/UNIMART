@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Sản phẩm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                </div>
            </div>
            <div class="filter-wp fl-right">
                <p class="desc text-danger fl-left">Hiển thị tổng {{count($products)}} sản phẩm!</p>
                <div class="form-filter">
                    <form method="GET" action="" id="filter-arrange">
                       
                        <select name="orderby" class="orderby" class="form-control form-search">
                            <option {{Request::get('orderby') == '' ? "selected='selected'":""}} value="">Sắp xếp</option>
                            <option {{Request::get('orderby') == '1' ? "selected='selected'":""}} value="1">Từ A-Z</option>
                            <option {{Request::get('orderby') == '2' ? "selected='selected'":""}} value="2">Từ Z-A</option>
                            <option {{Request::get('orderby') == '3' ? "selected='selected'":""}} value="3">Giá cao xuống thấp</option>
                            <option {{Request::get('orderby') == '4' ? "selected='selected'":""}} value="4">Giá thấp lên cao</option>
                        </select>
                        <button type="submit" >Lọc</button>
                    </form>
                </div>
            </div>
            @foreach($product_cats as $cat)
                <div class="section" id="list-product-wp">
                    @if($products_by_cat[$cat->id])
                        <div class="section-head">
                            <h3 class="section-title">{{$cat->title}}</h3>
                        </div>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                @foreach($products_by_cat[$cat->id] as $product)
                                    <li>
                                        <a href="{{route('product.detail', Str::slug($product->product_title))}}" title="" class="thumb">
                                            <img src="{{asset($product->product_thumb)}}">
                                        </a>
                                        <a href="{{route('product.detail', Str::slug($product->product_title))}}" title="" class="product-name">{{$product->product_title}}</a>
                                        <div class="price">
                                            <span class="new">{{number_format($product->new_price, 0, '' ,'.')}}đ</span>
                                            <span class="old">@empty($product->old_price)
                                                @else
                                                {{number_format($product->old_price, 0, '' ,'.')}}đ
                                            @endempty</span>
                                        </div>
                                        <div class="action clearfix">
                                            <a href="{{route('cart.add',$product->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left" >Thêm giỏ hàng</a>
                                            <a href="{{  route('checkout.buynow',$product->id)  }}" title="" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Phân trang --}}
                        {{-- <div class="section" id="paging-wp">
                            <div class="section-detail">
                                {{$products_by_cat[$cat->id]->withQueryString()->links()}}
                            </div>
                        </div> --}}
                        {{--  --}}
                    @endif
                </div>
            @endforeach
        </div> 
<div class="sidebar fl-left">
            @include('home.inc.sidebar')
            <br>
            @include('home.inc.product_selling')
            @include('home.inc.banner')
        </div>
    </div>
</div>
@endsection