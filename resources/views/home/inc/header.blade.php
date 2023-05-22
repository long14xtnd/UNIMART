<div id="site">
    <div id="container">
        <div id="header-wp">
            <div id="head-top" class="clearfix">
                <div class="wp-inner">
                    <a href="{{ url('page/canh-bao-gia-mao.html') }}" title="" id="payment-link" class="fl-left">Cảnh báo giả mạo</a>
                    <div id="main-menu-wp" class="fl-right">
                        <ul id="main-menu" class="clearfix">
                            <li>
                                <a href="{{ url('/') }}" title="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{ url('san-pham.html') }}" title="">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="{{ url('bai-viet.html') }}" title="">Blog</a>
                            </li>
                            <li>
                                <a href="{{ url('page/huong-dan-mua-hang-online.html') }}" title="">Hướng dẫn mua hàng online</a>
                            </li>
                            <li>
                                <a href="{{ url('page/lien-he.html') }}" title="">Liên hệ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="head-body" class="clearfix">
                <div class="wp-inner">
                    <a href="{{ url('/') }}" title="" id="logo" class="fl-left"><img src="{{ url('public/images/logo.png') }}"/></a>
                    <div id="search-wp" class="fl-left">
                        <form method="GET" action="{{ route('search') }}">
                            <input type="text" name="s" id="s"  placeholder="Nhập từ khóa tìm kiếm tại đây!">
                            <button type="submit" id="sm-s">Tìm kiếm</button>
                        </form>
                        {{-- Hiển thị dl tìm kiếm  --}}
                       <ul id="searchResult" style="display: none;">
                        @foreach ($products as $product)
                        <li class="clearfix">
                            <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" class="clearfix" style="display:block">
                                <div class="thumb fl-left">
                                    <img src="{{ url($product->product_thumb) }}" >
                                </div>
                                 <div class="info fl-left">
                                    <p class="product_name"> {{ $product->product_title }}</p>
                                     <p class="product_price"> {{ $product->new_price }} </p>
                                    </div> 
                                </a>
                        </li>
                        @endforeach
                        
                        </ul>
                        <style>
                        #searchResult {
                            position: absolute;
                            z-index: 10;
                            background: #fff;
                            width: 399px;
                            /* display: none; */
                        }
                        #searchResult li {
                            padding: 8px 20px;
                            transition: all .4s;
                            }

                        #searchResult li:hover {
                            background: #efe1e1;
                        }

                        #searchResult li .thumb {
                            margin-right: 10px;
                        }

                        #searchResult li a img {
                            max-width: 60px;
                        }

                        #searchResult .info{
                            max-width: 80%;
                            white-space: nowrap;
                            text-overflow: ellipsis;
                            overflow: hidden;
                        }

                        #searchResult .info .product_name {
                            color: #333;
                            font-size: 14px;
                            font-weight: 700;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                        }

                        #searchResult .info .product_price {
                            font-size: 14px;
                            color: #d0021b;
                            font-weight: bold;
                        }

</style>
<script type="text/javascript">              
    $('#s').on('keyup',function(){
    $value = $(this).val();
    if($value==''){
        $('#searchResult').html('');
        $('#searchResult').hide();
    }else{
        $.ajax({
        type: 'get',
        url: '{{ URL::to('search') }}',
        data: {
            'search': $value
        },
        success:function(data){
            $('#searchResult').html(data);
            $('#searchResult').show();
        }
    });
    }
})
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
                      
                    </div>
                    <div id="action-wp" class="fl-right">
                        <div id="advisory-wp" class="fl-left">
                            <span class="title">Tư vấn</span>
                            <span class="phone">0987.654.321</span>
                        </div>
                        <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                        <a href="{{ url('gio-hang.html') }}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span id="num">
                                @if (Cart::count() > 0)
                                {{ Cart::count() }}
                            @endif
                            </span>
                        </a>
                        <div id="cart-wp" class="fl-right">
                            <a href="{{ url('gio-hang.html') }}" id="btn-cart" style="color:#fff">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">
                                    @if (Cart::count() > 0)
                                    {{ Cart::count() }}
                                @endif
                                </span>
                            </a>
                            @if (Cart::count() > 0)
                            <div id="dropdown">
                                <p class="desc">Có <span> {{ Cart::count() }} sản phẩm</span> trong giỏ hàng</p>
                                <ul class="list-cart">
                                    @foreach (Cart::content() as $cart)
                                    <li class="clearfix">
                                        <a href="" title="" class="thumb fl-left">
                                            <img src="{{ asset($cart->options->thumbnail) }}" alt="">
                                        </a>
                                        <div class="info fl-right">
                                            <a href="{{ route('product.detail',Str::slug($cart->product_title)) }}" title="" class="product-name">{{ $cart->name }}</a>
                                            <p class="price sub-total-{{ $cart->rowId }}">{{ number_format($cart->subtotal, 0, '', '.') }}đ</p>
                                            <p  class="qty" >Số lượng: <span class="qty-{{ $cart->rowId }}">{{ $cart->qty }}</span></p>
                                        </div>
                                    </li>
                                    @endforeach
                                    
                                   
                                </ul>
                                <div class="total-price clearfix">
                                    <p class="title fl-left">Tổng:</p>
                                    <p class="price fl-right">{{ Cart::subtotal(0, '', '.') }}đ</p>
                                </div>
                                <div class="action-cart clearfix">
                                    <a href="{{ url('gio-hang.html') }}" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                                    <a href="{{ url('thanh-toan.html') }}" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                                </div>
                            </div>
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>