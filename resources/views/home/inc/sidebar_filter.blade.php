<div class="section" id="filter-product-wp">
    <div class="section-head">
        <h3 class="section-title">Bộ lọc</h3>
    </div>
    <div class="section-detail">
        <form method="GET" action="" action="" id="filter-price">
            <input type="hidden" name="orderby" value="{{Request::get('orderby')}}">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Giá</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="radio" class="common_selector filter-price" name="r-price" value="0" {{Request::get('r-price') == '0' ? "checked":""}}></td>
                        <td>Tất cả</td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="common_selector filter-price" name="r-price" value="1" {{Request::get('r-price') == '1' ? "checked":""}}></td>
                        <td>Dưới 500.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="common_selector filter-price" name="r-price" value="2" {{Request::get('r-price') == '2' ? "checked":""}}></td>
                        <td>500.000đ - 1.000.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="common_selector filter-price" name="r-price" value="3" {{Request::get('r-price') == '3' ? "checked":""}}></td>
                        <td>1.000.000đ - 5.000.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="common_selector filter-price" name="r-price" value="4" {{Request::get('r-price') == '4' ? "checked":""}}></td>
                        <td>5.000.000đ - 10.000.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="common_selector filter-price" name="r-price" value="5" {{Request::get('r-price') == '5' ? "checked":""}}></td>
                        <td>Trên 10.000.000đ</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Hãng</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input class="common_selector filter-brand" type="radio" name="r-brand" value="all" {{Request::get('r-brand') == 'all' ? "checked":""}}></td>
                        <td>Tất cả</td>
                    </tr>
                    @foreach ($list_brands as $brand)
                    <tr>
                        <td><input type="radio" class="common_selector filter-brand" name="r-brand" value="{{$brand->title}}" {{Request::get('r-brand') == $brand->title ? "checked":""}}></td>
                                    <td>{{$brand->title}}</td>
                    </tr>
                    @endforeach
                   
                    
                </tbody>
            </table>
            {{-- <table>
                <thead>
                    <tr>
                        <td colspan="2">Loại</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>Điện thoại</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>Laptop</td>
                    </tr>
                </tbody>
            </table> --}}
        </form>
    </div>
</div>
<script>
    $(function(){
           $('.filter-price').click(function(){
               $('#filter-price').submit();
           })
       })
</script>
<script>
    $(function(){
        $('.orderby').change(function(){
            // alert('ok');
            $('#filter-arrange').submit();
            
        })

        $('.common_selector').click(function(){
            $('#filter-price').submit();
        })
    })

</script>