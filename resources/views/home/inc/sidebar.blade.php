<div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
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
<?php 
    // BƯỚC 2: HÀM ĐỆ QUY HIỂN THỊ CATEGORIES
function showCategories($categories, $parent_id = 0, $char = '', $stt = 0)
{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $cate_child = array();
    foreach ($categories as $key => $category)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($category['parent_id'] == $parent_id)
        {
            $cate_child[] = $category;
            unset($categories[$key]);
        }
    }
     
    // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if ($cate_child)
    {
        if ($stt == 0){
            // là cấp 1
      
        }
        else if ($stt == 1){
            // là cấp 2
         
        }
        else if ($stt == 2){
            // là cấp 3
        }
         
        echo '<ul class="list-item">';
        foreach ($cate_child as $key => $item)
        {
            // Hiển thị tiêu đề chuyên mục
            echo '<li><a>'.$item['title'];
                if ($category['parent_id'] == $item->id)
        {
            showCategories($categories, $item['id'], $char.'|---', ++$stt);
            // $cate_child[] = $item;
            // unset($categories[$key]);
        }
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            // showCategories($categories, $item['id'], $char.'|---', ++$stt);
            echo '</a></li>';
        }
        echo '</ul>';
    }
}
?>