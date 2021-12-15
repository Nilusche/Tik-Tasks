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
        <form action="/Save-tasks" method="POST">
            @csrf
            <div class="row">
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="title">Titel *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                            placeholder="Titel der Aufgabe">
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="datetime-local" class="form-control" id="deadline" name="deadline"
                            value="{{ old('deadline') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <textarea class="form-control" name="description" id="description" cols="30"
                            rows="9">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group"></div>
                    <div class="form-group">
                        <label for="comment">Kommentar</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="{{ old('comment') }}"
                            placeholder="Kommentar">
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="visibility" class="">Sichtbarkeit</label>
                        <select class="form-select" id="visibility" name="visibility" value="{{ old('visibility') }}"
                            aria-label="Default select example">
                            @if (old('visibility') === 1)
                                <option value="0">privat</option>
                                <option value="1" selected>öffentlich</option>
                            @elseif(old('visibility')===0)
                                <option value="0" selected>privat</option>
                                <option value="1">öffentlich</option>
                            @else
                                <option value="0">privat</option>
                                <option value="1" selected>öffentlich</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="priority" class="">Priorität (1-5 zunehmend wichtiger)</label>
                        <input type="range" class="form-range" id="priority" name="priority" min="1" max="5" step="1" value="1"
                            oninput="this.nextElementSibling.value = this.value" value="{{ old('priority') }}">
                        <output><b>{{ old('priority') }}</b></output>
                    </div>
                    <div class="form-group">
                        <label for="alarm" class="">Erinnerungsalarm</label>
                        <select class="form-select" id="alarm" name="alarm" value="{{ old('alarm') }}"
                            aria-label="Default select example" required>
                            <option value="0">Wenn abgelaufen</option>
                            <option value="1">1 Stunde vorher</option>
                            <option value="2">1 Tag vorher</option>
                            <option value="3">Deadline minus aufwand</option>
                            <option value="4" selected>Niemals</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="effort" class="form-label">Geschätzter aufwand (in Stunden)</label>
                        <input type="number" class="form-control" id="effort" name="effort" min="0"
                            value="{{ old('effort') }}" placeholder="3.5">
                    </div>
                    <div class="form-group"></div>
                    <div class="form-group"></div>
                    <div class="form-group"></div>
                    <div class="form-group">
                        <p>Die mit * markierten Felder sind Pflichteingaben</p>
                        <span id=speicher><a id=speichern onclick="this.closest('form').submit();return false;"></a></span>
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <img class="createTaskpic" src="/sources/addTask.svg" alt="taskpicture">
                </div>

            </div>
        </form>
    </div>
@endsection



@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
@endsection
