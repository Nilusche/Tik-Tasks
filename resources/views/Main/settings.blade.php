@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>{{__('menu.settings')}}</h1>
        </div>
        <div class="systempanel">
        <img style="margin-top:3.8em; margin-left:3em;"src="sources/settings.svg" alt="Settings_Picture">
            <div>
                @if(App::currentLocale()=='de')
                    <span id=systempanelbutton>
                        <a id=archiv href="/Archive"></a>
                    </span>
                    <span id=systempanelbutton>
                        <a id=aufgabenexportierenundimportieren href="/NonAdminExportImport"></a>
                    </span>
                    <span id=systempanelbutton>
                        <a id=usernotification href="/UserNotifications" data-toggle="tooltip" data-placement="top"></a>
                    </span>
                @else
                    <span id=systempanelbutton>
                        <a id=archivEN href="/Archive"></a>
                    </span>
                    <span id=systempanelbutton>
                        <a id=aufgabenexportierenundimportierenEN href="/NonAdminExportImport"></a>
                    </span>
                    <span id=systempanelbutton>
                        <a id=usernotificationEN href="/UserNotifications" data-toggle="tooltip" data-placement="top"></a>
                    </span>
                @endif
                
                <span>
                    <select class="form-select mb-2 w-50" onChange="window.location.href=this.value">
                        <option value="" selected>{{__('menu.select_language')}}</option>
                        <option value="/lang/en">{{__('menu.english')}}</option>
                        <option value="/lang/de">{{__('menu.german')}}</option>
                    </select>
                </span>
            </div>
            
        </div>
    </div>
@endsection
