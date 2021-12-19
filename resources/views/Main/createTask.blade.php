@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
    
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
        <form action="/Save-tasks" method="POST" enctype="multipart/form-data">
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
                    <div class="form-group" style="margin-bottom:-1.5em;">
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

                        
                    <div class="form-group tag-wrapper">
                        <label for="links" class="form-label">Verlinkungen (mit Komma trennen)</label>
                        <input class="form-control" type="text" data-role="tagsinput" id="links" name="links" value="{{old('links')}}">
                    </div>
                    <div class="form-group">
                    </div>
                    
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <img class="createTaskpic" src="/sources/addTask.svg" alt="taskpicture">
                </div>

            </div>
            <div class="pt-5"></div>
            <div class="pt-5"></div>
            <div class="pt-5"></div>
            <div class="pt-5"></div>
            <div class="pt-5"></div>
            <div class="pt-5"></div>
            <div class="bg-light p-5 rounded">
                <h1>Dateien zum Hochladen auswählen</h1>
                <div class="form-group mt-4">
                <input type="file" name="files[]" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" multiple>
            </div>

            <p>Die mit * markierten Felder sind Pflichteingaben</p>
            <span id=speicher><a id=speichern onclick="this.closest('form').submit();return false;"></a></span>     
        </div>
        </form>
    </div>
@endsection



@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    
@endsection
@section('bottomscripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
@endsection

