@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>Alle öffentlichen Aufgaben</h1>
        </div>
    </div>
    @if ($publicTasks->first())

        @foreach ($publicTasks as $ptask)
            <div class="container">
                <div class="row task">
                    <div class="col-lg-11 col-md-11 col-sm-11">
                        <div class="card tabsize">
                            <div class="card-header text-center aufgabenwrapper">
                                <h4 class="card-title">
                                    @if (!empty($ptask->deadline))
                                        {{ $date = date('d-m-Y', strtotime($ptask->deadline)) }}
                                    @endif
                                </h4>
                                </ul>
                            </div>
                            <div class="card-body">
                                <p class="text">
                                    <b>Erstellt von:</b> {{ $ptask->name }}, {{ $ptask->email }} <br>
                                    <b>Erstellt am:</b>
                                    {{ $date = date('d-m-Y H:i', strtotime($ptask->created_at)) }}<br><br>
                                </p>
                                <h4 class="card-title text-center">{{ $ptask->title }}</h4><br>
                                <p class="text">
                                <h5 class="card-title">Beschreibung</h5>{{ $ptask->description }}</p>
                                <p class="text">
                                <h5 class="card-title">Kommentare</h5>{{ $ptask->comment }}<br><br></p>
                            </div>
                            <div class="card-footer text-muted text-center">
                                {{ $totalDuration = Carbon\Carbon::now()->diffForHumans($ptask->deadline) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="container">
            <h4 class="EmptyWebsite">Keine öffentlichen Aufgaben vorhanden</p>
        </div>
    @endif
@endsection
