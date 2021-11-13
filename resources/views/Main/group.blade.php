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
<div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
         @endif
    <form action="/storeTags" method="GET">
    @csrf
        <div class="form-group">
            <input type="text" name="tag" class="form-control" placeholder="Neuer Gruppenname">
            <button type="submit" class="btn btn-dark form-control">Neu erstellen</button>
        </div>
        <input type="hidden" name="userid" value="{{auth()->user()->id}}">
    </form>

    <form action="/assignTags" method="POST">
        @csrf
        <div class="form-group">
                <select id="selecttag" class="form-control chosen-select" name="tags[]" multiple>
                @foreach($tags as $tag)
                    @if($tag->users_id == auth()->user()->id)
                        <option value="{{$tag->id}}">
                        {{$tag->name}}
                        </option>
                    @endif
                @endforeach
                </select>

        </div>
        @if($tasks->first(function($task){return $task->users_id == auth()->user()->id;}))
        <ul class="list-group">
            @if($tasks->count()>0)
            @foreach($tasks as $task)
                @if($task->completed==false && auth()->user()->id == $task->users_id)
                    <li class="list-group-item">
                        <input class="form-check-input me-1" name="tasks[]" type="checkbox" value="{{$task->id}}" aria-label="...">
                        <div class="row">
                            <div class="col-lg-4">
                                <h5>Titel: </h5>{{$task->title}}
                            </div>
                            <div class="col-lg-4">
                                <h5>Deadline: </h5>{{$task->deadline}}
                            </div>
                            <div class="col-lg-4">
                                <h5>Gruppen: </h5>
                                @foreach($tags as $tag)
                                @if($tag->users_id == auth()->user()->id)
                                    @if($task->hasTag($tag->id))
                                        [{{$tag->name }}]
                                @endif
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
            @else
            <div class="container">
                    <h1>Keine Aufgaben vorhanden</h1>
            </div>
            @endif
        </ul>
        <button type="submit" class="btn btn-primary">Gruppieren</button>
        @else
        <div class="container">
            <h1>Keine Aufgaben vorhanden</h1>
        </div>
        @endif
    </form>
        
    
    
</div>
@endsection
