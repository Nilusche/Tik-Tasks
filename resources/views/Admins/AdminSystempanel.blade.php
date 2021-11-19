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
                    <a class="nav-link" href="/Startseite">Systemverwaltung</a>
                </li>
                @endif
                @if(auth()->user()->isManager())
                <li class="nav-item">
                    <a class="nav-link" href="/Startseite">Zuweisen</a>
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
 @if(auth()->user()->isAdmin())
 <div class="container">
    <a href="" class="btn btn-primary">Benutzer bearbeiten</a>
    <a href="{{route('register')}}" class="btn btn-warning">Benutzer registrieren</a>
    <a href="/DeleteUser" class="btn btn-warning">Benutzer löschen</a>
    <a href="/AdminExportImport" class="btn btn-danger">Sämtliche Aufgaben exportieren und importieren</a>
    
</div>
 @endif
 @endsection