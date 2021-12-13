@extends('layouts.app')

@section('content')
    @if(auth()->user()->isAdmin())
        <div class="container">
            <div class="systempanel">
                <img style="margin-top:3.8em;" src="sources/adminpanel.svg" alt="Systempanel.png">
                <div>
                    <span id=systempanelbutton><a id=edituser href="/EditUser"></a></span>
                    <span id=systempanelbutton><a id=registuser href="{{route('register')}}"></a></span>
                    <span id=systempanelbutton><a id=deleteuser href="/DeleteUser"></a></span>
                    <span id=systempanelbutton><a id=importexport href="/AdminExportImport"></a></span>
                </div>
            </div>
        </div>
    @endif
@endsection
