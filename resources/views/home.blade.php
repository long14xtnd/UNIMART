@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    <div class="item">
                        <img src="{{ url('public/images/slider-01.png') }}" alt="">
                    </div>
                    <div class="item">
                        <img src="{{ url('public/images/slider-02.png') }}" alt="">
                    </div>
                    <div class="item">
                        <img src="{{ url('public/images/slider-03.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="{{ url('public/images/icon-1.png') }}">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ url('public/images/icon-2.png') }}">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ url('public/images/icon-3.png') }}">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ url('public/images/icon-4.png') }}">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{ url('public/images/icon-5.png') }}">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                    @foreach ($product_feature as $product)
                  
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
            </div>
            
            @foreach($product_cats as $cat)
            @php
                $cats_child = data_tree($cats, $cat['id'], 0);
                $cats_child[] = $cat;
                $products_best_by_cat = array();
                foreach ($products as $product) {
                    foreach ($cats_child as $cat) {
                        if($product['category_id'] == $cat['id']){
                            $products_best_by_cat[] = $product;
                        }
                    }
                }
                $products_best_by_cat = array_slice($products_best_by_cat, 0 ,8);
            @endphp
            @if($products_best_by_cat)
           
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                     
                        <h3 class="section-title">{{$cat->title}}</h3>
                    </div>
                    
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach($products_best_by_cat as $product)
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
                    </div>
                </div>
            @endif
        @endforeach
            {{-- <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Điện thoại</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-16.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Motorola Moto G5S Plus</a>
                            <div class="price">
                                <span class="new">6.990.000đđ</span>
                                <span class="old">8.990.000đđ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-15.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Samsung Galaxy A5</a>
                            <div class="price">
                                <span class="new">7.990.000đ</span>
                                <span class="old">9.990.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-14.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Sony Xperia XA Ultra</a>
                            <div class="price">
                                <span class="new">6.990.000đ</span>
                                <span class="old">7.990.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-13.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Huawei Nova 2i</a>
                            <div class="price">
                                <span class="new">5.990.000đ</span>
                                <span class="old">8.990.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-12.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Xiaomi Mi A1</a>
                            <div class="price">
                                <span class="new">5.990.000đ</span>
                                <span class="old">6.990.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-11.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">HTC U Ultra Sapphire</a>
                            <div class="price">
                                <span class="new">16.490.000đ</span>
                                <span class="old">18.490.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-08.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Sony Xperia XZ Dual</a>
                            <div class="price">
                                <span class="new">9.990.000đ</span>
                                <span class="old">10.990.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="?page=detail_product" title="" class="thumb">
                                <img src="public/images/img-pro-10.png">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">Bphone 2017</a>
                            <div class="price">
                                <span class="new">9.790.000đ</span>
                                <span class="old">10.790.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Laptop</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-17.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Asus X441NA</a>
                            <div class="price">
                                <span class="new">7.690.000đ</span>
                                <span class="old">8.690.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-18.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Lenovo IdeaPad 110</a>
                            <div class="price">
                                <span class="new">9.490.000đ</span>
                                <span class="old">10.490.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-19.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Acer ES1 533</a>
                            <div class="price">
                                <span class="new">7.490.000đ</span>
                                <span class="old">9.490.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-20.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Lenovo IdeaPad 110</a>
                            <div class="price">
                                <span class="new">6.990.000đ</span>
                                <span class="old">7.990.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-21.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Asus X441NA</a>
                            <div class="price">
                                <span class="new">6.490.000đ</span>
                                <span class="old">8.490.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-22.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Acer Aspire ES1</a>
                            <div class="price">
                                <span class="new">6.390.000đ</span>
                                <span class="old">7.390.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-05.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Lenovo IdeaPad 120S</a>
                            <div class="price">
                                <span class="new">5.190.000đ</span>
                                <span class="old">7.190.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <li>
                            <a href="" title="" class="thumb">
                                <img src="public/images/img-pro-23.png">
                            </a>
                            <a href="" title="" class="product-name">Laptop Asus A540UP I5</a>
                            <div class="price">
                                <span class="new">14.490.000đ</span>
                                <span class="old">16.490.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="?page=cart" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
        <div class="sidebar fl-left">
            @include('home.inc.sidebar')
            @include('home.inc.product_selling')
            @include('home.inc.banner')
        </div>
    </div>
</div>
@endsection
<?php 
function data_tree($data,$parent_id = 0,$level=0){
   $result = [];
   foreach($data as $item){
      if($item['parent_id']==$parent_id){
         $item['level']=$level;
         $result[]=$item;
        
         //ở đây sa
         $child = data_tree($data,$item['id'],$level+1);
         $result=array_merge($result,$child);
      }

   }
   return $result;
}
?>
<script>
    $(function(){
        $('.orderBy').change(function(){
            $('#filter-arrange').submit();
        })

        $('.common_selector').click(function(){
            $('#filter-price').submit();
        })
    })

</script>