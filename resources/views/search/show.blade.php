<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Danh sách sản phẩm</h1>
    <label for="keyword">Tìm kiếm</label>
    <div class="form-group">
        <input type="text" name="inputSearch" id="inputSearch" class="form-control">
    </div>
    <div id="searchResult" style="display: none">
        {{-- <div class="form-group" >
            <a href="">Sp 1</a>
            <p>Title 1</p>
        </div> --}}
        
    </div>
    
   
</body>
</html>
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#inputSearch').on('keyup',function(){
        $inputSearch  = $(this).val();
       if($inputSearch==''){
           $('#searchResult').html('');
           $('#searchResult').hide();
       }else{
        $.ajax({
            method : 'get',
            url : 'https://localhost/UNITEST/search',
            data:JSON.stringify({
                inputSearch:$inputSearch
            }),
            headers:{
                'Accept':'application/json',
                'Content-Type':'application/json'
            },
            success:function(data){
                var searchResultAjax='';
               data = JSON.parse(data);
               console.log(data);
               $('#searchResult').show();
        //        for(let i=0;i<data.length;i++){
        //            searchResultAjax +=`<div class="form-group">
        //     <a href="">`+data[i].product_title+`</a>
        //     <p>Title 2</p>
        // </div>`
        //        }
        //        $('#searchResult').html(searchResultAjax);
            }
        })
       }
    });
</script>
