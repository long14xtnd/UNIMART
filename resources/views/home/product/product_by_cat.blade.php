@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{route('cat', Str::slug($product_cat->title))}}" title="">{{$product_cat->title}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">{{ $product_cat->title }}</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị {{ count($products_by_cat)  }} sản phẩm</p>
                        <div class="form-filter">
                            <form method="GET" action="" id="filter-arrange">
                                 {{-- @csrf --}}
                            <input type="hidden" name="r-price" value="{{Request::get('r-price')}}">
                            <input type="hidden" name="r-brand" value="{{Request::get('r-brand')}}">
                            <select name="orderby" class="orderby" class="form-control form-search">
                                <option {{Request::get('orderby') == '' ? "selected='selected'":""}} value="">Sắp xếp</option>
                                <option {{Request::get('orderby') == '1' ? "selected='selected'":""}} value="1">Từ A-Z</option>
                                <option {{Request::get('orderby') == '2' ? "selected='selected'":""}} value="2">Từ Z-A</option>
                                <option {{Request::get('orderby') == '3' ? "selected='selected'":""}} value="3">Giá cao xuống thấp</option>
                                <option {{Request::get('orderby') == '4' ? "selected='selected'":""}} value="4">Giá thấp lên cao</option>
                            </select>
                                {{-- <button type="submit">Lọc</button> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="section-detail">
                    @if ($products_by_cat)
                    <ul class="list-item clearfix">
                        @foreach($products_by_cat as $product)
                            <li>
                                <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="thumb">
                                    <img src="{{url($product->product_thumb)}}" class="thumb-effect">
                                </a>
                                <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="product-name">{{$product->product_title}}</a>
                                <div class="price">
                                    <span class="new">{{number_format($product->new_price, 0, '' ,'.')}}đ</span>
                                    <span class="old">{{number_format($product->old_price, 0, '' ,'.')}}đ</span>
                                </div>
                                <div class="action clearfix">
                                    <a href="{{  route('cart.add',$product->id)  }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                    <a href="{{  route('checkout.buynow',$product->id)  }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                       <p class="text-danger">Không có sản phẩm nào!</p> 
                    @endif
                   
                </div>
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
            @include('home.inc.sidebar_filter')
            @include('home.inc.banner')
        </div>
    </div>
</div>
@endsection
{{-- <script>
    $(function(){
        $('.orderby').change(function(){
            alert('ok');
            // $('#filter-arrange').submit();
            
        })

        $('.common_selector').click(function(){
            $('#filter-price').submit();
        })
    })

</script> --}}
