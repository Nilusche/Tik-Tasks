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
                    <a class="nav-link" href="/Startseite">Einstellungen</a>
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
     <h1>Aufgabenarchiv</h1>
 </div>
 <div class="container">
    
    <span id=leere ><a id=leeren href="/deleteArchive" ></a></span>
        @if($tasks->count()!=0)
        @foreach($tasks as $task)
            @if($task->completed==true && auth()->user()->id == $task->users_id)
                <div class="container">
                    <div class="row task">
                        <div class="col-lg-11 col-md-11 col-sm-11">
                            <div class="card tabsize">
                                <div class="card-header text-center aufgabenwrapper">
                                    <h4 class="card-title">
                                        @if(!empty($task->deadline))
                                            {{$date = date("d-m-Y", strtotime($task->deadline));}} 
                                        @endif
                                    </h4>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <p class="text">Erstellt am: {{$date = date("d-m-Y H:i", strtotime($task->created_at));}}<br><br></p>
                                    <h4 class="card-title text-center">{{$task->title}}</h4><br>
                                    <p class="text"><h5 class="card-title">Beschreibung</h5>{{$task->description}}</p>
                                    <p class="text"><h5 class="card-title">Kommentare</h5>{{$task->comment}}<br><br></p>
                                </div>
                                <div class="card-footer text-muted text-center">
                                    {{$totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline);}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @else
        <h1 class="text-center"style="margin-top:2em;">Keine Aufgaben im Archiv</h1>
        @endif
 @endsection