@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="systempanel">
            <img src="sources/GearSettings.png" alt="Settings_Picture">
            <div>
                <span id=systempanelbutton>
                    <a id=archiv href="/Archive"></a>
                </span>
                <span id=systempanelbutton>
                    <a id=aufgabenexportierenundimportieren href="/NonAdminExportImport"></a>
                </span>
                <span id=systempanelbutton>
                    <a id=usernotification href="/UserNotifications" data-toggle="tooltip" data-placement="top"></a>
                </span>
            </div>
        </div>
    </div>
@endsection
