<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ url('public/customAuth/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ url('public/customAuth/css/style.css') }}">
</head>
<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                <form method="POST" id="signup-form" class="signup-form" action="{{ route('register') }}">
					@csrf
                    <h2>Register </h2>
                    <p class="desc">if you don't have a <span>“Member Account”</span></p>
                    <div class="form-group">
						{{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
                        <input type="text" class="form-input @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required autocomplete="name" autofocus/>
						@error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
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
                        {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> --}}
                        <input type="password" class="form-input" name="password" id="password" placeholder="Password" class="@error('password') is-invalid @enderror" required autocomplete="new-password"/>
						@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
                        <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group">
                        {{-- <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> --}}
                        <input type="password" class="form-input" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password"  required autocomplete="new-password"/>
                        <span toggle="#password_confirmation" class="zmdi zmdi-eye field-icon toggle-password"></span>
                    </div>

                    
                    <div class="form-group">
                        <input type="submit" name="submit" id="submit" class="form-submit submit" value="Register">
                        {{-- <a href="{{ route('register') }}" class="submit-link submit" type="submit">Register</a> --}}
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