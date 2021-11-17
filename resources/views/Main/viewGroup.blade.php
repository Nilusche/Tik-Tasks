@extends('layouts.app')
@section('navbar')
    <div class="container-fluid navcontainer">
        <nav class="navbar navbar-expand-lg navbar-dark back">
            <a class="navbar-brand" href="/Startseite">Tiktasks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto">
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="/Startseite">Systemverwaltung</a>
                        </li>
                    @endif
                    @if (auth()->user()->isManager())
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
        <div class="container">
            <span id=erstell><a id=erstellen href="/Create-task"></a></span>
            <span id=gruppe><a id=gruppieren href="/Group"></a></span>
            <div class="btn-group">
                <button class="btn btn-lg dropdown-toggle Sortbtn" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Sortieren nach
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyNameAscGroup">Titel aufsteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyNameDescGroup">Titel absteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyDeadlineAscGroup">Deadline aufsteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyDeadlineDescGroup">Deadline absteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyDateOfCreationAscGroup">Erstellungdatum aufsteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyDateOfCreationDescGroup">Erstellungdatum absteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyPriorityAscGroup">Priorität aufsteigend</a></li>
                    <li><a class="dropdown-item" href="/Startseite/{{$tag_id}}/view/SortbyPriorityDescGroup">Priorität absteigend</a></li>
                </ul>
            </div>
            <form class="form-inline filter" method="get" action="/Startseite/{{$tag_id}}/view/searchGroup">
                @csrf
                <input class="form-control mr-sm-2 filterinput" type="search" name="search" placeholder="Filtern nach"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 searchbutton" type="submit"><i
                        class="fas fa-search"></i></button>
            </form>
        </div>
        @foreach ($tasks as $task)
            @if ($task->completed == false)
                <div class="container">
                    <div class="row task">
                        <div class="col-lg-11 col-md-11 col-sm-11">
                            <div class="card tabsize">
                                <div class="card-header text-center aufgabenwrapper">
                                    <h4 class="card-title">
                                        @if (!empty($task->deadline))
                                            {{ $date = date('d-m-Y H:i', strtotime($task->deadline)) }}
                                        @endif
                                    </h4>
                                </div>
                                <div class="card-body overflow-auto">
                                    <p class="text">Erstellt am:
                                        {{ $date = date('d-m-Y H:i', strtotime($task->created_at)) }}<br><br></p>
                                    <h4 class="card-title text-center">{{ $task->title }}</h4><br>
                                    <p class="text ">
                                    <h5 class="card-title">Beschreibung</h5>{!! $task->description !!}</p>
                                    <p class="text">
                                    <h5 class="card-title">Kommentare</h5>{!! $task->comment !!}<br><br></p>
                                    <a class="btn btn-dark" type="button" name="button"
                                        href="/Startseite/{{ $task->tasks_id }}/edit"><i
                                            class="fas fa-edit">Bearbeiten</i></a>
                                    <a class="btn btn-warning" type="button" data-bs-toggle="modal"
                                        data-bs-target="#finish{{ $task->tasks_id }}"><i class="fas fa-trash-alt">
                                            Beenden</i></a>
                                    <a class="btn btn-danger" type="button" data-bs-toggle="modal"
                                        data-bs-target="#deleteTask{{ $task->tasks_id }}"><i class="fas fa-trash-alt">
                                            Löschen</i></a>
                                    <a class="btn btn-primary" type="button" name="button" href="/Startseite"><i
                                            class="fas fa-sync"> Aktualisieren</i></a>
                                </div>
                                @if (!empty($task->deadline))
                                    <div class="container-fluid">
                                        <a class="badge rounded-pill bg-info" href="{{ $task->calendarICS }}">Ics
                                            Datei</a>
                                        <a class="badge rounded-pill bg-info" href="{{ $task->calendarGoogle }}">Google
                                            Calendar</a>
                                        <a class="badge rounded-pill bg-info"
                                            href="{{ $task->calendarWebOutlook }}">WebOutlook Calendar</a>
                                    </div>
                                @endif
                                <div class="card-footer text-muted text-center">
                                    {{ $totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline) }}
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1">
                            @if ($task->priority == 1)
                                <div class="card priority1 tabsize"></div>
                            @elseif($task->priority==2)
                                <div class="card priority2 tabsize"></div>
                            @elseif($task->priority==3)
                                <div class="card priority3 tabsize"></div>
                            @elseif($task->priority==4)
                                <div class="card priority4 tabsize"></div>
                            @else
                                <div class="card priority5 tabsize"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Modal Delete Task-->
                <div class="modal fade" id="deleteTask{{ $task->tasks_id }}" tabindex="-1"
                    aria-labelledby="deleteTaskLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteTaskLabel">Aufgabe löschen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Möchten sie die Aufgabe wirklich löschen?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                <a type="button" class="btn btn-danger"
                                    href="/Startseite/{{ $task->tasks_id }}/delete">Löschen</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal finish Task-->
                <div class="modal fade" id="finish{{ $task->tasks_id }}" tabindex="-1" aria-labelledby="finishLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="finishLabel">Aufgabe beenden</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Möchten sie die Aufgabe abschliessen?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                <a type="button" class="btn btn-danger"
                                    href="/Startseite/{{ $task->tasks_id }}/complete">Beenden</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
