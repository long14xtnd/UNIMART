@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Tìm kiếm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">Kết quả tìm kiếm với "{{ Request::get('s') }}"</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc text-danger">Tìm thấy {{ $products->count() }} sản phẩm</p>
                        {{-- <div class="form-filter">
                           <form method="GET" action="" id="filter-arrange">
                        <select name="orderby" class="orderby" class="form-control form-search">
                            <option {{Request::get('orderby') == '' ? "selected='selected'":""}} value="">Sắp xếp</option>
                            <option {{Request::get('orderby') == '1' ? "selected='selected'":""}} value="1">Từ A-Z</option>
                            <option {{Request::get('orderby') == '2' ? "selected='selected'":""}} value="2">Từ Z-A</option>
                            <option {{Request::get('orderby') == '3' ? "selected='selected'":""}} value="3">Giá cao xuống thấp</option>
                            <option {{Request::get('orderby') == '4' ? "selected='selected'":""}} value="4">Giá thấp lên cao</option>
                        </select>
                        <button type="submit" name="filter">Lọc</button>
                    </form>
                        </div> --}}
                    </div>
                </div>
                @if ($products->count()>0)
                <div class="section-detail">
                    <ul class="list-item clearfix">
                   @foreach ($products as $product)
                   <li>
                       <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="thumb">
                           <img src="{{ url($product->product_thumb) }}">
                       </a>
                       <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="product-name">{{ $product->product_title }}</a>
                       <div class="price">
                           <span class="new">{{number_format($product->new_price, 0, '' ,'.')}}đ</span>
                           <span class="old">{{number_format($product->old_price, 0, '' ,'.')}}đ</span>
                       </div>
                       <div class="action clearfix">
                           <a href="{{  route('cart.add',$product->id)  }}" title="" class="add-cart fl-left" onclick="setTimeout(2000)">Thêm giỏ hàng</a>
                           <a href="{{  route('checkout.buynow',$product->id)  }}" title="" class="buy-now fl-right">Mua ngay</a>
                       </div>
                   </li>
                   @endforeach
                   </ul> 
              </div>
                @else
                <div class="not-found">
                    <img src="{{ url('public/images/unnamed.jpg') }}" alt="" style="width:960px;height:500px;">
                    <!-- <p style="text-align:center;">Không tìm thấy sản phẩm nào..</p> -->
                </div>
                @endif
              
 
            </div>
            
            {{-- <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                    </ul>
                </div>
            </div> --}}
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

