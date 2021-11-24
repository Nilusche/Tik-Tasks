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
@if(auth()->user()->isManager())
    <div>
        <h1 id="zuweisen-header">Zuweisung</h1>
        <form id="zuweisen" action="/assignTasks" method ="POST">
            @csrf
            <input id="zuweisen-input" type = "text" name ="operator" placeholder="Tragen Sie hier Ihre E-Mail ein">
            <div id="zuweisen-list">
                @foreach($TaskUserPairs as $TaskUserPair)
                    @if($TaskUserPair->users_id == auth()->user()->id)
                        @foreach($tasks as $task)
                            @if($task->completed==false && $task->id == $TaskUserPair->tasks_id)
                                <li id="zuweisen-item" class = "list-group-item">
                                    <label>
                                        <input class ="form-check-input me-1" name ="tasks[]" type ="checkbox" value ="{{$task->id}}" aria-label ="...">
                                        {{$task->title}}
                                    </label>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            <div>
                <input id="zuweisenbutton" class="btn btn-info" type ="submit" name = "send">
            </div>
        </form>
    </div>
@endif    
@endsection
