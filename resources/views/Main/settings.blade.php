@extends('layouts.app')

 @section('content')

<div class="container">
    <a href="/Archive" class="btn btn-primary">Archiv</a>
    <a href="/NonAdminExportImport" class="btn btn-danger">Aufgaben exportieren und importieren</a>
    <a class="btn btn-warning position-relative" href="/UserNotifications">
        Benachrichtigungen
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{$notis}}
            <span class="visually-hidden">unread messages</span>
        </span>
    </a>
</div>

 @endsection
