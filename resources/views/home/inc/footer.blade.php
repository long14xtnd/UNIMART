<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <h3 class="title">ISMART</h3>
                <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính sách ưu
                    đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                <div id="payment">
                    <div class="thumb">
                        <img src="public/images/img-foot.png" alt="">
                    </div>
                </div>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title">Thông tin cửa hàng</h3>
                <ul class="list-item">
                    <li>
                        <p>106 - Trần Bình - Cầu Giấy - Hà Nội</p>
                    </li>
                    <li>
                        <p>0987.654.321 - 0989.989.989</p>
                    </li>
                    <li>
                        <p>longdoan14xtnd@gmail.com</p>
                    </li>
                </ul>
            </div>
            <div class="block menu-ft policy" id="info-shop">
                <h3 class="title">Chính sách mua hàng</h3>
                <ul class="list-item">
                    <li>
                        <a href="{{ url('page/quy-che-hoat-dong.html') }}" title="">Quy chế hoạt động</a>
                    </li>
                    <li>
                        <a href="{{ url('page/chinh-sach-bao-hanh.html') }}" title="">Chính sách bảo hành - đổi
                            trả</a>
                    </li>
                    <li>
                        <a href="{{ url('page/chinh-sach-tra-gop.html') }}" title="">Chính sách trả góp</a>
                    </li>
                    <li>
                        <a href="{{ url('page/cau-hoi-thuong-gap.html') }}" title="">Câu hỏi thường gặp</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title">Bảng tin</h3>
                <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                <div id="form-reg">
                    <form method="POST" action="">
                        <input type="email" name="email" id="email" placeholder="Nhập email tại đây">
                        <button type="submit" id="sm-reg" disabled>Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">© Bản quyền thuộc về hailongdev.click | Fullstack Developer</p>
        </div>
    </div>
</div>
</div>

<div id="menu-respon">
    <a href="{{ url('/') }}" title="" class="logo">VSHOP</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="{{ url('/') }}" title>Trang chủ</a>
            </li>
            @foreach ($ProductCategorys as $key => $cate)
                @if ($cate->parent_id == 0)
                    <li>
                        <a href="{{ url('danh-muc/' . $cate->slug) }}">{{ $cate->title }}</a>
                        <ul class="sub-menu">
                            @foreach ($ProductCategorys as $key => $cate_sub)
                                @if ($cate_sub->parent_id == $cate->id)
                                    <li>
                                        <a href="{{ url('danh-muc/' . $cate_sub->slug) }}">{{ $cate_sub->title }}</a>
                                        {{-- <ul class="sub-menu">
                                        @foreach ($ProductCategorys as $key => $cate_sub_1)
                                            @if ($cate_sub_1->parent_id == $cate_sub->id)
                                                <li>
                                                    <a href="">{{ $cate_sub_1->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul> --}}
                                    </li>
                                @endif
                            @endforeach
                            <li></li>
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<div id="btn-top"><img src="{{ url('public/images/icon-to-top.png') }}" alt="" /></div>
<div id="fb-root"></div>
{{-- hiển thị thêm,rút gọn  --}}
{{-- <script type="text/javascript" src="clients/js/jquery.readmore.js"></script> --}}

{{-- <script type="text/javascript">
    $('.detail').readmore({
      speed: 100,
      moreLink: '<a href="#" class="accordion" style=" border: 1px solid #2f80ed; border-radius: 5px;    color: #2f80ed;    display: block;    margin: 0 auto;    max-width: 340px;    padding: 10px 5px; text-align: center;margin-top: 40px;">HIỂN THỊ THÊM</a>',
      lessLink: '<a href="#" class="accordion" style=" border: 1px solid #2f80ed; border-radius: 5px;    color: #2f80ed;    display: block;    margin: 0 auto;    max-width: 340px;    padding: 10px 5px; text-align: center;margin-top: 40px;">ẨN BỚT</a>',
      collapsedHeight: 1000,
      heightMargin:1,
    });
</script> --}}

<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


</body>

</html>
