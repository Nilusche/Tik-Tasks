@extends('layouts.app')

@section('content')
    <div class="container">
        <style>
            *,
            *:before,
            *:after {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }

            input::placeholder {
                color: black;
            }

            textarea::placeholder {
                color: black;
            }

            input[type=number]::-webkit-inner-spin-button {
                -webkit-appearance: none;
            }

            .danger {
                color: red;
            }

        </style>

        <head>
            <title>Aufgabe erstellen/ändern</title>
        </head>
    </div>

    <body id="grad_a_e">

        <div class="grid_a_e">
            <div class="background_a_e">
                <!--
                        <div id="bluesphere_a_e" class="sphere_g"></div>
                        <div id="redsphere_a_e" class="sphere_g"></div>
                        -->
            </div>
            <form class="form_a_e" action="/Save-tasks" method="POST">
                @csrf
                <div>
                    <h3 class="text_tiktok" style="color:white;">Aufgabe erstellen</h3>
                </div>
                <div class="teil_a_e">
                    <div class="neuer_abschnitt">
                        <label class="labelinput_a_e" for="title">Titel *</label>
                        <input class="input_a_e  @error('title') is-invalid @enderror" type="text" id="title" name="title"
                            value="{{ old('title') }}" placeholder="Titel der Aufgabe">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong class="danger">{{ $message }}</strong>
                            </span>
                        @enderror


                        <label class="labelinput_a_e" for="deadline">Deadline</label>
                        <input class="input_a_e  @error('deadline') is-invalid @enderror" type="datetime-local"
                            id="deadline" name="deadline" value="{{ old('deadline') }}">
                        @error('deadline')
                            <span class="invalid-feedback" role="alert">
                                <strong class="danger">{{ $message }}</strong>
                            </span>
                        @enderror

                        <label class="labelinput_a_e" for="description">Beschreibung</label>
                        <textarea class="inputtext_a_e  @error('description') is-invalid @enderror" class="form-control"
                            name="description" placeholder="Beschreibung" id="description" cols="50"
                            rows="9">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong class="danger">{{ $message }}</strong>
                            </span>
                        @enderror
                        <label class="labelinput_a_e" for="comment">Kommentar</label>
                        <input class="input_a_e @error('comment') is-invalid @enderror" type="text" id="comment"
                            name="comment" value="{{ old('comment') }}" placeholder="Kommentar">
                        @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong class="danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label class="labelinput_a_e" for="visibility">Sichtbarkeit</label>
                        <select class="boxs" id="visibility" name="visibility" value="{{ old('visibility') }}"
                            aria-label="Default select example">
                            @if (old('visibility') == 1)
                                <option value="0">privat</option>
                                <option value="1" selected>öffentlich</option>
                            @else
                                <option value="0" selected>privat</option>
                                <option value="1">öffentlich</option>
                            @endif
                        </select>

                        <label class="labelinput_a_e" for="priority">Priorität (1-5 zunehmend wichtiger)</label>
                        <input class="input_a_e" type="range" id="priority" name="priority" min="1" max="5" step="1"
                            oninput="this.nextElementSibling.value = this.value" value="{{ old('effort') }}">
                        <output><b>{{ old('priority') }}</b></output>

                        <label class="labelinput_a_e" for="alarm">Erinnerungsalarm</label>
                        <select class="boxs" id="alarm" name="alarm" value="{{ old('alarm') }}"
                            aria-label="Default select example">
                            <option value="0" selected>Wenn abgelaufen</option>
                            <option value="1">1 Stunde vorher</option>
                            <option value="2">1 Tag vorher</option>
                            <option value="3">Deadline minus aufwand</option>
                            <option value="4">Niemals</option>
                        </select>

                        <label class="labelinput_a_e" for="effort">Geschätzter aufwand (in Stunden)</label>
                        <input class="input_a_e @error('effort') is-invalid @enderror" type="number" id="effort"
                            name="effort" min="0" value="{{ old('effort') }}" placeholder="3.5">
                        @error('effort')
                            <span class="invalid-feedback" role="alert">
                                <strong class="danger">{{ $message }}</strong>
                            </span>
                        @enderror
                        <p>Die mit * markierten Felder sind Pflichteingaben</p>
                    </div>
                </div>
                <div>

                    <button type="submit" class="btn btn-success" id="button_a_e">Speichern</button>

                </div>


            </form>
        </div>
    </body>

    </html>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
@endsection
