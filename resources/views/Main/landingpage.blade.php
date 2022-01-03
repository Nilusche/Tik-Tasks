@extends('layouts.landing_app')
@section('content')
    <div class="transition2"></div>
    <div class="wrapper">
        <div class="container landingpage">
            <div class="row">
                <div class="col-lg-6">
                    <img class="logo" src="sources/logo.png" alt="logo">
                    <!-- Insert Corporate Text here -->
                    <p class="introduction">
                        <select class="form-select mb-2" onChange="window.location.href=this.value">
                            @if(App::currentLocale()=='de')
                            <option value="/lang/en" >{{__('menu.english')}}</option>
                            <option value="/lang/de" selected>{{__('menu.german')}}</option>
                            @else
                            <option value="/lang/en" selected>{{__('menu.english')}}</option>
                            <option value="/lang/de" >{{__('menu.german')}}</option>
                            @endif
                        </select>
                        {{__('menu.coporatetext')}}
                    </p>
                    @if(App::currentLocale()=='de')
                        <span id="einloggen"><a href="/login"></a></span>
                    @else
                        <span id="login"><a href="/login"></a></span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <img class="workpicture" src="sources/LandingPageIllustrationsScaledDown.jpg" alt="work">
                </div>
            </div>
        </div>
    </div>
    <div class="transition1"></div>
    <footer class="text-center text-lg-start">
        <div class="text-center p-3 foot">
        {{__('menu.disclaimer')}}
        </div>
    </footer>

@endsection
