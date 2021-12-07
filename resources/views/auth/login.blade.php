@extends('layouts.auth')
@section('content')
<div class="grid">
    <div>
        <div class="background">
            <div id="bluesphere" class="sphere"></div>
            <div id="redsphere" class="sphere"></div>
        </div>
        <form class="loginform" method="POST" action="{{ route('login') }}">
        @csrf
            <h3 class="loginuber">{{ __('Login') }}</h3>

            <label for="email" class="labelinput">{{ __('E-Mail Address') }}</label>
            <input type="text" placeholder="name@example.net" id="email" class="loginput @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            
            <label for="password" class="labelinput">{{ __('Password') }}</label>
            <input type="password" placeholder="Passwort" id="password" class="loginput @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            
            <input class="check" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="check" for="remember">  {{ __('Remember Me') }} </label>
            
            <div id="loginfail">
                @error('email')
                    <span role="alert">
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    </span>
                @enderror
                @error('password')
                    <span role="alert">
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" id="loginbutton"> {{ __('Login') }}</button>
        </form>
    </div>
    <div class="logo">
        <img src="sources/logo_white.png">
    </div>
</div>
@endsection

@section('loader')
<div class="loader-wrapper">
    <div class="loader">
        <div class="loader-inner">
            <div class="loader-line-wrap">
                <div class="loader-line"></div>
            </div>
            <div class="loader-line-wrap">
                <div class="loader-line"></div>
            </div>
            <div class="loader-line-wrap">
                <div class="loader-line"></div>
            </div>
            <div class="loader-line-wrap">
                <div class="loader-line"></div>
            </div>
            <div class="loader-line-wrap">
                <div class="loader-line"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script>
        $(window).on("load",function(){
            $(".loader-wrapper").fadeOut("slow");
        })
    </script>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection