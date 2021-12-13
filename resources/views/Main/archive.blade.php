@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="css/card.css">
@endsection
@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>Aufgabenarchiv</h1>
        </div>
    </div>
    <div class="container">

        <span id=leere><a id=leeren href="/deleteArchive"></a></span>
        @foreach ($TaskUserPairs as $TaskUserPair)
            @if ($TaskUserPair->users_id == auth()->user()->id)
                @foreach ($tasks as $task)
                    @if ($task->completed == true && $task->id == $TaskUserPair->tasks_id)
                        <div class="container">
                            <div class="blog-card">
                                <div class="meta">
                                    <div class="photo" style="background-image: url(sources/task.svg)"></div>
                                    <ul class="details">
                                        <li class="date">Erstellt am:
                                            {{ $date = date('d-m-Y H:i', strtotime($task->created_at)) }}</li>
                                        <li><i class="fas fa-exclamation-triangle"></i> &nbsp;Priorität:
                                            {{ $task->priority }}</li>
                                        <li class="tags">
                                            <ul>
                                            </ul>
                                        </li>
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
                                            data-target="#collapseExample{{ $task->id }}" aria-expanded="false"
                                            aria-controls="collapseExample{{ $task->id }}">Mehr anzeigen</a>
                                    </p>

                                    <div class="collapse" id="collapseExample{{ $task->id }}">
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

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endsection
