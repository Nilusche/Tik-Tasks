@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/card.css">
@endsection
@section('content')
    <div class="container">
        <span id=erstell><a id=erstellen href="/Create-task"></a></span>
        <span id=gruppe><a id=gruppieren href="/Group"></a></span>
        <div class="btn-group">
            <button class="btn btn-lg dropdown-toggle Sortbtn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sortieren nach
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/Startseite/{{ $tag_id }}/view/SortbyNameAscGroup">Titel
                        aufsteigend</a></li>
                <li><a class="dropdown-item" href="/Startseite/{{ $tag_id }}/view/SortbyNameDescGroup">Titel
                        absteigend</a></li>
                <li><a class="dropdown-item" href="/Startseite/{{ $tag_id }}/view/SortbyDeadlineAscGroup">Deadline
                        aufsteigend</a></li>
                <li><a class="dropdown-item" href="/Startseite/{{ $tag_id }}/view/SortbyDeadlineDescGroup">Deadline
                        absteigend</a></li>
                <li><a class="dropdown-item"
                        href="/Startseite/{{ $tag_id }}/view/SortbyDateOfCreationAscGroup">Erstellungdatum
                        aufsteigend</a></li>
                <li><a class="dropdown-item"
                        href="/Startseite/{{ $tag_id }}/view/SortbyDateOfCreationDescGroup">Erstellungdatum
                        absteigend</a></li>
                <li><a class="dropdown-item" href="/Startseite/{{ $tag_id }}/view/SortbyPriorityAscGroup">Priorität
                        aufsteigend</a>
                </li>
                <li><a class="dropdown-item" href="/Startseite/{{ $tag_id }}/view/SortbyPriorityDescGroup">Priorität
                        absteigend</a>
                </li>
            </ul>
        </div>
        <form class="form-inline filter" method="get" action="/Startseite/{{ $tag_id }}/view/searchGroup">
            @csrf
            <input class="form-control mr-sm-2 filterinput" type="search" name="search" placeholder="Filtern nach"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0 searchbutton" type="submit"><i
                    class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="container">
        <form class="form-inline" method="get" action="/storeTags">
            @csrf
            <input class="form-control" type="text" name="tag" placeholder="Gruppe erstellen">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">erstellen</button>
            <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
        </form>
    </div>

    <!-- Teilgruppen -->
    <!-- gibt es Gruppen für den User? -->
    <div class="container">
        @foreach ($tags as $tag)
            <div class="row">
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <div class="form-group">
                        <a href="/Startseite/{{ $tag->id }}/view">
                            <div class="row task">
                                <div class="badge bg-primary">
                                    <img src="sources/Ordner.png" alt=""
                                        style="max-height: 60px; float: left; padding-top: 9px; padding-left: 10px">
                                    <div class="card-body overflow-auto">
                                        <h4>Gruppe: {{ $tag->name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <a class="btn btn-danger" type="button" data-bs-toggle="modal"
                            data-bs-target="#deleteGroup{{ $tag->id }}"><i class="fas fa-trash-alt fa-3x"
                                style="font-size: 62px">
                            </i></a>
                    </div>
                </div>
            </div>
            <!-- Modal delete Group-->
            <div class="modal fade" id="deleteGroup{{ $tag->id }}" tabindex="-1" aria-labelledby="deleteGroup"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteGroup">Gruppierung löschen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Möchten sie wirklich die Gruppierung löschen? Die enthaltenen Aufgaben werden nicht
                            gelöscht.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <a type="button" class="btn btn-danger"
                                href="/Startseite/{{ $tag->id }}/deleteGroup">löschen</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Aufgaben für den User, in der Gruppe -->
        @foreach ($tasks as $task)
            @if ($task->completed == false)
                <div class="container" data-aos="zoom-in-down">
                    <div class="blog-card">
                        <div class="meta">
                            <div class="photo" style="background-image: url(/sources/task.svg)"></div>
                            <ul class="details">
                                <li class="date">Erstellt am:
                                    {{ $date = date('d-m-Y H:i', strtotime($task->created_at)) }}</li>
                                <li><i class="fas fa-exclamation-triangle"></i> &nbsp;Priorität: {{ $task->priority }}
                                </li>
                                <li class="tags">
                                    <ul>
                                        @foreach ($allTasks as $task2)
                                            <li>{{ $task2->name }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                                @if ($task->deadline)
                                    <li><i class="far fa-calendar-alt"></i> &nbsp;<a href="{{ $task->calendarICS }}">ICS
                                            Datei</a></li>
                                    <li><i class="far fa-calendar-alt"></i> &nbsp;<a
                                            href="{{ $task->calendarGoogle }}">Google Calendar</a></li>
                                    <li><i class="far fa-calendar-alt"></i> &nbsp;<a
                                            href="{{ $task->calendarWebOutlook }}">
                                            WebOutlook Calendar</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="description">
                            @if ($task->deadline)
                                <h1 class="h1-color mb-4">
                                    <div class="Deadline-title"><i class="far fa-calendar-alt"></i>&nbsp;DEADLINE:
                                        {{ $task->deadline }}</div>
                                </h1>
                            @endif
                            <h1 class="mb-4">AUFGABE: {{ $task->title }}</h1>
                            <h2 class="mb-2">BESCHREIBUNG:</h2>
                            @if ($task->priority == 1)
                                <p class="priority1"> {!! $task->description !!} </p>
                            @elseif($task->priority==2)
                                <p class="priority2"> {!! $task->description !!}</p>
                            @elseif($task->priority==3)
                                <p class="priority3"> {!! $task->description !!}</p>
                            @elseif($task->priority==4)
                                <p class="priority4"> {!! $task->description !!}</p>
                            @else
                                <p class="priority5"> {!! $task->description !!}</p>
                            @endif

                            <p class="read-more">
                                <a type="button" data-toggle="collapse" id="open"
                                    data-target="#collapseExample{{ $task->tasks_id }}" aria-expanded="false"
                                    aria-controls="collapseExample{{ $task->tasks_id }}">Mehr anzeigen</a>
                            </p>

                            <div class="collapse" id="collapseExample{{ $task->tasks_id }}">
                                <h2 class="mt-4">Kommentar:</h2>
                                @if ($task->priority == 1)
                                    <p class="priority1"> {!! $task->comment !!}</p>
                                @elseif($task->priority==2)
                                    <p class="priority2"> {!! $task->comment !!}</p>
                                @elseif($task->priority==3)
                                    <p class="priority3"> {!! $task->comment !!}</p>
                                @elseif($task->priority==4)
                                    <p class="priority4"> {!! $task->comment !!}</p>
                                @else
                                    <p class="priority5"> {!! $task->comment !!}</p>
                                @endif
                                <h2 class="mt-3">Verbleibende Zeit: <span class="h1-color">
                                        {{ $totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline) }}</span>
                                </h2>


                                <div class="mt-4">
                                    <b class="mr-4">
                                        <button class="btn btn-warning but " href="" data-bs-toggle="modal"
                                            data-bs-target="#finish{{ $task->tasks_id }}"><i
                                                class="fas fa-check-circle"></i>Beenden</button>
                                    </b>
                                    &nbsp;&nbsp;&nbsp;
                                    @foreach ($taskOwner as $to)
                                        @if ($to->tasks_id == $task->tasks_id)
                                            <b>
                                                <button class="btn btn-danger but" href="" data-bs-toggle="modal"
                                                    data-bs-target="#deleteTask{{ $task->tasks_id }}"><i
                                                        class="fas fa-trash-alt"></i>Löschen</button>
                                            </b>
                                        @endif
                                    @endforeach
                                </div>
                                <p class="read-more">
                                    <a href="/Startseite/{{ $task->tasks_id }}/edit">Bearbeiten</a>
                                </p>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal Delete Task-->
                @foreach ($taskOwner as $to)
                    @if ($to->tasks_id == $task->tasks_id)
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
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Abbrechen</button>
                                        <a type="button" class="btn btn-danger"
                                            href="/Startseite/{{ $task->tasks_id }}/delete">Löschen</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
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
