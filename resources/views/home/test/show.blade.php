<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Danh sách sản phẩm</h1>
    <label for="keyword">Tìm kiếm</label>
    <div class="form-group">
        <input type="text" name="keyword" id="keyword" class="form-control">
    </div>
    <table class="table">
        <thead>
            <tr>
                <td>Tên sp</td>
                <td>số lượng</td>
            </tr>
            
        </thead>
        <tbody id="listProduct" >
            <tr>
                <td>iphone 11</td>
                <td>12</td>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product_title }}</td>
                    <td>{{ $product->num_product }}</td>
                </tr>
            
            
            @endforeach
        </tbody>
    </table>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript">
    // $.ajaxSetup({
    //     headers:{
    //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    // $('#keyword').on('keyup',function(){
    //     $keyword  = $(this).val();
    //     if($keyword==''){
    //         $('#listProduct').html('');
    //         $('#listProduct').hide('');
    //     }else{
    //         $.ajax({
    //             method: "GET",
    //             url: "/search",
    //             data: JSON.stringify({
    //                 keyword : $keyword
    //             }),
    //             headers: {
    //                 'Accept':'application/json',
    //                 'Content-Type':'application/json'
    //             },
    //             success: function(data) {
    //               console.log(data);
    //             },
    //             error: function(xhr, ajaxOptions, thrownError) {
    //                 alert(xhr.status);
    //                 alert(thrownError);
    //             }
    //         });
    //     }
    // });
    $(document).ready(function(){
        // // alert('ok');
        // $('#keyword').keyup(function(){
        //     // alert($('#keyword').val());
        //     var txt = $('#keyword').val();
        //     $.ajax({
        //         type: "GET",
        //         url: "/search",
        //         data: txt,
        //         dataType: "json",
        //         success: function(data) {
        //             $('#listProduct').html(data);
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status);
        //             alert(thrownError);
        //         }
        //     });
        // })
        //================main
        $(document).on('keyup','#keyword',function(){
            var keyword = $(this).val();
           
                    // $("#listProduct-data").show();
                    $.ajax({
                type: "GET",
                url: "https://localhost/UNITEST/search",
                data: {
                    keyword : keyword
                },
                dataType: "json",
                success: function(response) {
                   
                        $('#listProduct').html(response);
                        $('#listProduct').show();
                    
                   
                },
                // $("#listProduct-data").show();
                // error: function(xhr, ajaxOptions, thrownError) {
                //     alert(xhr.status);
                //     alert(thrownError);
                // }
            });
                
                
        });
        //=============
 

    });
</script>
</html>