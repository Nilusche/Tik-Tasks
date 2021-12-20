@extends('layouts.app')


@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #e62755;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }
        .tag-wrapper {
            max-height: 100px;
            max-width: 27em;
            overflow-x: auto;
            overflow-y: auto;
            display:inline-block;
        }
        .links{
            max-height: 100px;
            max-width: 27em;
            overflow-x: auto;
            overflow-y: auto;
            display:inline-block;
        }

        .btn-outline-danger:hover{
            background-color:#e62755;
        }
        .btn{
            background-color:white;
        }
    </style>
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
        <form action="/Startseite/{{ $task->id }}/Update-tasks" method="POST">
            @csrf
            <div class="row">
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="title">Titel *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}"
                            placeholder="Titel der Aufgabe">
                    </div>
                    <div class="form-group">
                        <label for="deadline">
                            Deadline @if($task->deadline)(bisher:
                            {{ Carbon\Carbon::parse($task->deadline)->format('d-m-Y H:i') }})
                            @endif
                        </label>
                        <input type="datetime-local" class="form-control datetimepicker" id="deadline" name="deadline"
                            value="{{$task->deadline}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <textarea class="form-control" name="description" id="description" cols="30"
                            rows="9" maxlength="500">{{ $task->description }}</textarea>
                    </div>
                    <div class="form-group"></div>
                    <div class="form-group">
                        <label for="comment">Kommentar</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="{{ $task->comment }}"
                            placeholder="Kommentar">
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="visibility" class="">Sichtbarkeit</label>
                        <select class="form-select" id="visibility" name="visibility" value="{{ $task->visibility }}"
                            aria-label="Default select example">
                            @if ($task->visibility == 1)
                                <option value="0">privat</option>
                                <option value="1" selected>öffentlich</option>
                            @else
                                <option value="0" selected>privat</option>
                                <option value="1">öffentlich</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:-1.5em;">
                        <label for="priority" class="" >Priorität (1-5 zunehmend wichtiger)</label>
                        <input type="range" class="form-range" id="priority" name="priority" min="1" max="5" step="1"
                            oninput="this.nextElementSibling.value = this.value" value="{{ $task->priority }}">
                        <output><b>{{ $task->priority }}</b></output>
                    </div>
                    <div class="form-group"></div>
                    <div class="form-group">
                        <label for="alarm" class="">Erinnerungsalarm</label>
                        <select class="form-select" id="alarm" name="alarm" aria-label="Default select example" required>
                            @if ($task->alarmdateInteger == 0)
                                <option value="0" selected>Wenn abgelaufen</option>
                                <option value="1">1 Stunde vorher</option>
                                <option value="2">1 Tag vorher</option>
                                <option value="3">Deadline minus aufwand</option>
                                <option value="4">Niemals</option>
                            @elseif($task->alarmdateInteger==1)
                                <option value="0">Wenn abgelaufen</option>
                                <option value="1" selected>1 Stunde vorher</option>
                                <option value="2">1 Tag vorher</option>
                                <option value="3">Deadline minus aufwand</option>
                                <option value="4">Niemals</option>
                            @elseif($task->alarmdateInteger==2)
                                <option value="0">Wenn abgelaufen</option>
                                <option value="1">1 Stunde vorher</option>
                                <option value="2" selected>1 Tag vorher</option>
                                <option value="3">Deadline minus aufwand</option>
                                <option value="4">Niemals</option>
                            @elseif($task->alarmdateInteger==3)
                                <option value="0">Wenn abgelaufen</option>
                                <option value="1">1 Stunde vorher</option>
                                <option value="2">1 Tag vorher</option>
                                <option value="3" selected>Deadline minus aufwand</option>
                                <option value="4">Niemals</option>
                            @elseif($task->alarmdateInteger==4)
                                <option value="0">Wenn abgelaufen</option>
                                <option value="1">1 Stunde vorher</option>
                                <option value="2">1 Tag vorher</option>
                                <option value="3">Deadline minus aufwand</option>
                                <option value="4" selected>Niemals</option>
                            @else
                                <option value="0">Wenn abgelaufen</option>
                                <option value="1">1 Stunde vorher</option>
                                <option value="2">1 Tag vorher</option>
                                <option value="3">Deadline minus aufwand</option>
                                <option value="4">Niemals</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="effort" class="form-label">Geschätzter aufwand (in Stunden)</label>
                        <input type="text" class="form-control" id="effort" name="effort" min="0"
                            value="{{ $task->estimatedEffort }}" placeholder="3.5" >
                    </div>
                    <div class="form-group">
                        <label for="effort2" class="form-label">Tatsächlicher aufwand (in Stunden)</label>
                        <input type="text" class="form-control" id="effort2" name="effort2" min="0"
                            value="{{ $task->totalEffort }}" placeholder="3.5">
                    </div>

                    <div class="form-group mb-5">
                        <p>Die mit * markierten Felder sind Pflichteingaben</p>
                        <span id=speicher><a id=speichern onclick="this.closest('form').submit();return false;"></a></span>
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="links">
                        <div class="form-group">
                            <label for="links" class="form-label">Vorhandene Links</label>
                            <div class="form-item" id="links">
                                @foreach($task->links as $link)
                                    <a class=" btn btn-outline-danger"href="https://{{ $link->name }}">{{ $link->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div><br>
                
                    <div class="form-group tag-wrapper">
                        <label for="links" class="form-label">Verlinkungen (Domains, mit Komma trennen)</label>
                        <input class="form-control" type="text" data-role="tagsinput" id="links" name="links" value="{{old('links')}}">
                    </div>
                    <img class="createTaskpic" src="/sources/editTask.svg" alt="taskpicture" style="height:20em; width:auto;">
                </div>

            </div>
        </form>
    </div>

    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="pt-5"></div>
    <div class="container">
         <div class="bg-light p-5 rounded">
            <h1>Dateien</h1>
            <form action="/files/add/{{$task->id}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-4">
                <input type="file" name="files[]" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" multiple>
                </div>

                <button class="w-100 btn btn-lg btn-outline-danger mt-2 mb-5" type="submit">Weitere Dateien Hochladen</button>
            </form>               
            

            <table class="table table-striped mt-3">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Typ</th>
                <th scope="col">Ansicht</th>
                <th scope="col">Löschen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr>
                    <td width="3%">{{ $file->id }}</td>
                    <td>{{ $file->slug }}</td>
                    <td width="10%">{{ $file->type }}</td>
                    <td width="5%"><a href="/files/{{$file->name}}" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">Anzeigen</a></td>
                    <td width="5%"><a href="/files/delete/{{$file->id}}" class="btn btn-outline-danger" target="_blank" rel="noopener noreferrer">Löschen</a></td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection

@section('bottomscripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
@endsection
