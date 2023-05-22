{{-- HEADER  --}}
<!DOCTYPE html>
<html>
    <head>
        <title>ISMART STORE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         {{--CSRF Token--}}
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-token" content="TfF7gvM1emmVGjkm7WR1RkUH9TKD986WTgJaFROn">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="{{ url('public/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/reset.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/responsive.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/sweet-alert.css') }}" rel="stylesheet" type="text/css"/>

        <script src="{{ url('public/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/js/main.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/js/app.js') }}" type="text/javascript"></script>
        <script src="{{ url('public/js/readmore.js') }}" type="text/javascript"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
       
    </head>
    <body>
        
@include('home.inc.header')
{{-- END HEADER  --}}

{{-- CONTENT --}}
@yield('content')


{{-- END CONTENT  --}}

{{-- FOOTER  --}}
@include('home.inc.footer')

{{-- END FOOTER --}}


