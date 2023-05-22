<div id="menu-respon">
    <a href="{{ url('/') }}" title="" class="logo">VSHOP</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="{{ url('/') }}" title>Trang chủ</a>
            </li>
            @foreach ($ProductCategorys as $key=>$cate)
            @if ($cate->parent_id==0)
                <li>
                    <a href="{{route('cat', Str::slug($cate->title))}}">{{ $cate->title }}</a>
                    <ul class="sub-menu">
                        @foreach ($ProductCategorys as $key=>$cate_sub)
                            @if ($cate_sub->parent_id==$cate->id)
                                <li>
                                    <a href="{{route('cat', Str::slug($cate_sub->title))}}">{{ $cate_sub->title }}</a>
                                    {{-- <ul class="sub-menu">
                                        @foreach ($ProductCategorys as $key=>$cate_sub_1  )
                                            @if ($cate_sub_1->parent_id==$cate_sub->id)
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