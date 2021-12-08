@extends('layouts.app')

 @section('content')

<div class="container col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
            <h2>Einstellungen</h2>
            <div class="row p-1">
                <div class="row cardList">
                    <div><a href="/Archive" class="btn btn-primary cardBtn" data-toggle="tooltip" data-placement="top" title="Archiv"><i class="fa fa-archive icon"></i></a>
                    <a href="/NonAdminExportImport" class="btn btn-danger cardBtn" data-toggle="tooltip" 
                            data-placement="top" title="Aufgaben exportieren und importieren"><i class="fas fa-file-export icon"></i></a>
                            <a class="btn btn-warning position-relative cardBtn" href="/UserNotifications"
                                data-toggle="tooltip" data-placement="top" title="Benachrichtigungen">
                                <i class="fas fa-bell icon"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{$notis}}
                            <span class="visually-hidden">unread messages</span>
                        </span></a>

                </div>
            </div>
            </div>
        </div>
</div>

 @endsection