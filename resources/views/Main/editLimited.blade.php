@extends('layouts.app')

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
        <form action="/Startseite/{{ $task->id }}/Update-tasks-limited" method="POST">
            @csrf
            <div class="row">
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="title">Titel *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}"
                            placeholder="Titel der Aufgabe" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <textarea class="form-control" name="description" id="description" cols="30"
                            rows="9">{{ $task->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="comment">Kommentar</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="{{ $task->comment }}"
                            placeholder="Kommentar">
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="alarm" class="">Erinnerungsalarm</label>
                        <select class="form-select" id="alarm" name="alarm" aria-label="Default select example">
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
                        <input type="number" class="form-control" id="effort" name="effort" min="0"
                            value="{{ $task->estimatedEffort }}" placeholder="3.5" readonly>
                    </div>
                    <div class="form-group">
                        <label for="effort2" class="form-label">Tatsächlicher aufwand (in Stunden)</label>
                        <input type="number" class="form-control" id="effort2" name="effort2" min="0"
                            value="{{ $task->totalEffort }}" placeholder="3.5">
                    </div>
                    <div class="form-group"></div><br>
                    <div class="form-group">
                        <p>Die mit * markierten Felder sind Pflichteingaben</p>
                    </div>
                    <div class="form-group">
                        <span id=speicher><a id=speichern onclick="this.closest('form').submit();return false;"></a></span>
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <img class="createTaskpic" src="/sources/editTask.svg" alt="taskpicture">
                </div>

            </div>
        </form>
    </div>
@endsection
