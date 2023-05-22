<div class="section" id="selling-wp">
    <div class="section-head">
        <h3 class="section-title">Sản phẩm bán chạy</h3>
    </div>
    <div class="section-detail">
        <ul class="list-item">
            @foreach ($products_selling as $product)
          
            <li class="clearfix">
                <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="thumb fl-left">
                    <img src="{{ url($product->product_thumb) }}" alt="">
                </a>
                <div class="info fl-right">
                    <a href="{{ route('product.detail',Str::slug($product->product_title)) }}" title="" class="product-name">{{ $product->product_title }}</a>
                    <div class="price">
                        <span class="new"> {{number_format($product->new_price, 0, '' ,'.')}}đ</span>
                        <span class="old"> {{number_format($product->old_price, 0, '' ,'.')}}đ</span>
                    </div>
                    <a href="{{  route('checkout.buynow',$product->id)  }}" title="" class="buy-now">Mua
                        ngay</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>