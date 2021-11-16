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
                        <a class="nav-link" href="/ogout">Ausloggen</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
@endsection

@section('content')
    <div>
        <h1>Zuweisung</h1>
        <form action="/assignTasks" method ="POST">
            @csrf
            <div>
                <input type = "text" name ="operator">
            </div>
            <div>
                @foreach($TaskUserPairs as $TaskUserPair)
                    @if($TaskUserPair->users_id == auth()->user()->id)
                        @foreach($tasks as $task)
                            @if($task->completed==false && $task->id == $TaskUserPair->tasks_id)
                                <li class = "list-group-item">
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
                <input type ="submit" name = "send">
            </div>
        </form>
    </div>
@endsection
