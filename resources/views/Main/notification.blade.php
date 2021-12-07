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
 <div class="container">
     <h1>Benachrichtigungen</h1>
 </div>
 <div class="container">
    <div class="row">
           <div class="col-lg-6">Aufgaben name</div>
           <div class="col-lg-6">Verbliebene Zeit</div>
    </div>
    @foreach($notifications as $notification)
        @if($notification['read_at']==null)
        <div class="row">
           <div class="col-lg-6 text-danger"> {{$notification['taskname']}}</div>
           <div class="col-lg-6 text-danger"> {{$notification['diff']}}</div>
        </div>
        @endif
    @endforeach
    @foreach($notifications as $notification)
        @if($notification['read_at']!=null)
        <div class="row">
           <div class="col-lg-6 text-success"> {{$notification['taskname']}}</div>
           <div class="col-lg-6 text-success"> {{$notification['diff']}}</div>
        </div>
        @endif
    @endforeach
    <a class="btn btn-primary" href="/readNotifications">Mark as Read</a>

 </div>
 @endsection