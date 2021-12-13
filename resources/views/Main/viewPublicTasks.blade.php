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
    @foreach ($publicTasks as $task)
        <div class="container">
        <div class="blog-card">
                    <div class="meta">
                        <div class="photo" style="background-image: url(/sources/task.svg)"></div>
                            <ul class="details">
                                <li class="author">Erstellt von:</b> {{ $task->name }}, {{ $task->email }} </li>
                                <li class="date">Erstellt am: {{ $date = date('d-m-Y H:i', strtotime($task->created_at)) }}</li>
                                <li><i class="fas fa-exclamation-triangle"></i>  &nbsp;Priorität: {{$task->priority}}</li>
                            </ul>
                    </div>
                    <div class="description">
                        @if ($task->deadline)
                            <h1 class="h1-color mb-4">
                                <div class="Deadline-title"><i
                                        class="far fa-calendar-alt"></i>&nbsp;DEADLINE:
                                    {{ $date = date('d-m-Y H:i', strtotime($task->deadline)) }}</div>
                            </h1>
                        @endif
                        <h1 class="mb-4">AUFGABE: {{ $task->title }}</h1>
                        <h2 class="mb-2">BESCHREIBUNG:</h2>
                        <p class="priority1"> {!! $task->description !!} </p>
                            <h2 class="mt-4">Kommentar:</h2>
                            <p class="priority1"> {!! $task->comment !!}</p>
                            <!-- Verbleibende Zeit wird nur angezeigt wenn keine Deadline vorhanden ist -->
                            @if ($task->deadline)
                                <h2 class="mt-3">Verbleibende Zeit: <span class="h1-color">
                                        {{ $totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline) }}</span>
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
