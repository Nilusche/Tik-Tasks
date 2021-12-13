@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="systempanel">
            <img src="sources/undraw_tabs_re_a2bd.svg" alt="Settings_Picture">
            <div>
                <span id=systempanelbutton>
                    <a id=profilbearbeiten href="/Profile/edit"></a>
                </span>
                <span id=systempanelbutton>
                    <a id=profilpasswortändern href="/Profile/change-password"></a>
                </span>
            </div>
        </div>
    </div>


@endsection
