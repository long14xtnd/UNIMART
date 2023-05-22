<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ url('public/customAuth/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ url('public/customAuth/css/style.css') }}">
</head>
<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <form method="POST" id="signup-form" class="signup-form" action="{{ route('password.email') }}">
					@csrf
                    <h2>Reset Password </h2>
                    <p class="desc">Update your password  <span>“if you have forgotten it”</span></p>
                       
                    {{-- <div class="form-group">
                        <input type="text" class="form-input" name="name" id="name" placeholder="Your Name"/>
                    </div> --}}
                    <div class="form-group">
						{{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
                        <input type="email" class="form-input @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
						@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                   
					
                    <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="form-submit submit" value="Reset ">
                        
                    </div>
                   
                </form>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="{{ url('public/customAuth/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('public/customAuth/js/main.js') }}"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>