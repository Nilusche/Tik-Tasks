@extends('layouts.app')

@section('content')
    @if(auth()->user()->isAdmin())
        <div class ="container">
            <div class="btn btn-secondary position-relative">
                <h1>{{__('menu.systempanel')}}</h1>
            </div>
        </div>
        <div class="container">
            <div class="systempanel">
                <img style="margin-top:3.8em;" src="sources/adminpanel.svg" alt="Systempanel.png">
                <div>
                @if(App::currentLocale()=='de')
                    <span id=systempanelbutton><a id=edituser href="/EditUser"></a></span>
                    <span id=systempanelbutton><a id=registuser href="{{route('register')}}"></a></span>
                    <span id=systempanelbutton><a id=deleteuser href="/DeleteUser"></a></span>
                    <span id=systempanelbutton><a id=importexport href="/AdminExportImport"></a></span>
                @else
                    <span id=systempanelbutton><a id=edituserEN href="/EditUser"></a></span>
                    <span id=systempanelbutton><a id=registuserEN href="{{route('register')}}"></a></span>
                    <span id=systempanelbutton><a id=deleteuserEN href="/DeleteUser"></a></span>
                    <span id=systempanelbutton><a id=importexportEN href="/AdminExportImport"></a></span>
                @endif
                    
                </div>
            </div>
        </div>
    @endif
@endsection
