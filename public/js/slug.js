$('input#product_title').keyup(function(event){
    var title ,slug ;
    // Lấy text từ thẻ input title 
    title = $(this).val();

    // Đổi chữ hoa thành chữ thường 
    slug = title.toLowerCase();

    // Đổi kí tự có dấu thành không dấu

    slug = slug.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/gi, 'a');
    slug = slug.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/gi, 'e');
    slug = slug.replace(/i|ì|í|ị|ỉ|ĩ/gi, 'i');
    slug = slug.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/gi, 'o');
    slug = slug.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/gi, 'u');
    slug = slug.replace(/ỳ|ý|ỵ|ỷ|ỹ/gi , 'y');
    slug = slug.replace(/đ/gi, 'd');

    // Xóa kí tự đặc biệt
    slug = slug.replace(/\`|\~|\!|\!|\@|\#|\|\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');

    // Đổi khoảng trắng thành kí tự gạnh ngang 
    slug = slug.replace(/ /gi, "-");

    // Đổi nhiều kí tự gạch ngang liên tiếp thành 1 kí tự gạch ngang 
    // Phòng trường hợp người nhập vào qúa nhiều kí tự trắng    
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');

    // Xóa kí tự gạnh ngang ở đầu và cuối 
    
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');

    // In slug ra text có id là slug 

    $('input#slug').val(slug);
})