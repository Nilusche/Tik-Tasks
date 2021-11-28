
 @extends('layouts.app')
 @section('navbar')
    <div class="container-fluid navcontainer">
        <nav class="navbar navbar-expand-lg navbar-dark back">
        <a class="navbar-brand" href="/Startseite">Tiktasks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto">
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="/Systempanel">Systemverwaltung</a>
                </li>
                @endif
                @if(auth()->user()->isManager())
                <li class="nav-item">
                    <a class="nav-link" href="/Assign">Zuweisen</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/Settings">Einstellungen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Startseite">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Ausloggen</a>
                </li>
                </ul>
            </div>
        </nav>
    </div>
 @endsection

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