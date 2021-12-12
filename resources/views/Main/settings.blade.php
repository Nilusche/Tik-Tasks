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

                <!--
                        
                    <a href="/Archive" id=AdminPanelArchiv class="btn btn-primary cardBtn" data-toggle="tooltip"
                        data-placement="top" title="Archiv">
                        <i class="fa fa-archive icon"></i>
                    </a>
                    
                    <a href="/NonAdminExportImport" class="btn btn-danger cardBtn" data-toggle="tooltip" data-placement="top"
                        title="Aufgaben exportieren und importieren">
                        <i class="fas fa-file-export icon"></i>
                    </a>
                   
                    <a class="btn btn-warning position-relative cardBtn" href="/UserNotifications" data-toggle="tooltip"
                        data-placement="top" title="Benachrichtigungen">
                        <i class="fas fa-bell icon"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notis }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                    -->
            </div>
        </div>
    </div>
@endsection
