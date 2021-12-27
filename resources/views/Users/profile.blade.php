@extends('layouts.app')

@section('content')
    <div class ="container">
        <div class="btn btn-secondary position-relative">
            <h1>{{__('menu.profile')}}</h1>
        </div>
    </div>
    <div class="container">
        <div class="systempanel">
            <img src="sources/undraw_tabs_re_a2bd.svg" alt="Settings_Picture">
            <div>
                @if(App::currentLocale()=='de')
                    <span id=systempanelbutton>
                        <a id=profilbearbeiten href="/Profile/edit"></a>
                    </span>
                    <span id=systempanelbutton>
                        <a id=profilpasswortändern href="/Profile/change-password"></a>
                    </span>
                @else
                    <span id=systempanelbutton>
                        <a id=profilbearbeitenEN href="/Profile/edit"></a>
                    </span>
                    <span id=systempanelbutton>
                        <a id=profilpasswortändernEN href="/Profile/change-password"></a>
                    </span>
                @endif
            </div>
        </div>
    </div>
@endsection
