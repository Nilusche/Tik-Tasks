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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item">{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    <form action="/Startseite/{{$task->id}}/Update-tasks-limited" method="POST">
        @csrf
        <div class="row">
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="title">Titel *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$task->title}}"placeholder="Titel der Aufgabe" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="9">{{$task->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="comment">Kommentar</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="{{$task->comment}}" placeholder="Kommentar">
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="alarm" class="">Erinnerungsalarm</label>
                        <select class="form-select" id="alarm" name="alarm" value="{{old('alarm')}}" aria-label="Default select example" required>
                            <option value="" selected>Auswählen</option>
                            <option value="0">Wenn abgelaufen</option>
                            <option value="1">1 Stunde vorher</option>
                            <option value="2">1 Tag vorher</option>
                            <option value="3">Deadline minus aufwand</option>
                            <option value="4">Niemals</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="effort" class="form-label">Geschätzter aufwand (in Stunden)</label>
                        <input type="number" class="form-control" id="effort" name="effort" min="0" value="{{$task->estimatedEffort}}"placeholder="3.5" readonly>
                    </div>
                    <div class="form-group">
                        <label for="effort2" class="form-label">Tatsächlicher aufwand (in Stunden)</label>
                        <input type="number" class="form-control" id="effort2" name="effort2" min="0" value="{{$task->totalEffort}}" placeholder="3.5">
                    </div>
                    <div class="form-group"></div><br>
                    <div class="form-group">
                        <p>Die mit * markierten Felder sind Pflichteingaben</p>
                    </div>
                    <div class="form-group">
                    <span id=speicher ><a id=speichern onclick="this.closest('form').submit();return false;"></a></span>
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <img class="createTaskpic" src="/sources/createTask.png" alt="taskpicture">
                </div>

        </div>
    </form>
</div>
@endsection