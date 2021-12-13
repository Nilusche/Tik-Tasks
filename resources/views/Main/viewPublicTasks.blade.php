@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/card.css">
    <link rel="stylesheet" href="/css/card2.css">
@endsection

@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>Alle öffentlichen Aufgaben</h1>
        </div>
    </div>
    @if ($publicTasks->first())
    @foreach ($publicTasks as $ptask)
        <div class="container">
            <div class="blog-card">
                <div class="meta">
                <div class="photo" style="background-image: url(/sources/task.svg)"></div>
                <ul class="details">
                    <li class="author">Erstellt von:</b> {{ $ptask->name }}, {{ $ptask->email }} </li>
                    <li class="date">Erstellt am: {{ $date = date('d-m-Y H:i', strtotime($ptask->created_at)) }}</li>
                    <li><i class="fas fa-exclamation-triangle"></i>  &nbsp;Priorität: {{$ptask->priority}}</li>
                </ul>
                </div>
                <div class="description">
                @if($ptask->deadline)
                <h1 class="h1-color mb-4"><div class="Deadline-title"><i class="far fa-calendar-alt"></i>&nbsp;DEADLINE: {{ $date = date('d-m-Y H:i', strtotime($task->deadline)) }}</div> </h1>
                @endif
                <h1 class="mb-4">AUFGABE: {{ $ptask->title }}</h1>
                <h2 class="mb-2">BESCHREIBUNG:</h2>
                <p>  {!!$ptask->description!!} </p>
                        <p class="read-more">
                            <a type="button" data-toggle="collapse" id="open"
                                data-target="#collapseExample{{ $ptask->id }}" aria-expanded="false"
                                aria-controls="collapseExample{{ $ptask->id }}">auf-/zuklappen</a>
                        </p>

                        <div class="collapse" id="collapseExample{{ $ptask->id }}">
                            <h2 class="mt-4">Kommentar:</h2>
                                <p> {!! $ptask->comment !!}</p>
                            <!-- Verbleibende Zeit wird nur angezeigt wenn keine Deadline vorhanden ist -->
                            @if ($ptask->deadline)
                                <h2 class="mt-3">Verbleibende Zeit: <span class="h1-color">
                                        {{ $totalDuration = Carbon\Carbon::now()->diffForHumans($ptask->deadline) }}</span>
                                </h2>
                            @endif
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
