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
                    <a class="nav-link" href="/Archive">Einstellungen</a>
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
        <span class="erstellen" id=erstell ><a id=erstellen href="/Create-task" ></a></span>
        </div>
        @if($tasks->count()!=0)
        @foreach($tasks as $task)
            @if($task->completed==false && auth()->user()->id == $task->users_id)
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
                            <a class="btn btn-dark" type="button" name="button" href="/Startseite/{{$task->id}}/edit"><i class="fas fa-edit">Bearbeiten</i></a>
                            <a class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#finish{{$task->id}}"><i class="fas fa-trash-alt"> Beenden</i></a>
                            <a class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteTask{{$task->id}}"><i class="fas fa-trash-alt"> Löschen</i></a>
                            <a class="btn btn-primary" type="button" name="button"><i class="fas fa-sync"> Aktualisieren</i></a>
                            </div>
                            <div class="card-footer text-muted text-center">
                            {{$totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline);}}
                            </div>
                        </div>
                        
                        
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1">
                        @if($task->priority==1)
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
                <div class="modal fade" id="deleteTask{{$task->id}}" tabindex="-1" aria-labelledby="deleteTaskLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteTaskLabel">Aufgabe löschen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Möchten sie die Aufgabe wirklich löschen?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <a type="button" class="btn btn-danger" href="/Startseite/{{$task->id}}/delete" >Löschen</a>
                        </div>
                        </div>
                    </div>
                </div>
            <!-- Modal finish Task-->
            <div class="modal fade" id="finish{{$task->id}}" tabindex="-1" aria-labelledby="finishLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="finishLabel">Aufgabe beenden</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Möchten sie die Aufgabe abschliessen?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <a type="button" class="btn btn-danger" href="/Startseite/{{$task->id}}/complete" >Beenden</a>
                        </div>
                        </div>
                    </div>
                </div>

            @endif
        @endforeach
        @else
        <div class="container">
            <h1>Keine Aufgaben vorhanden</h1>
        </div>
        @endif
 @endsection