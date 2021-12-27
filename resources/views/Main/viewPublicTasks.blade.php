@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="/css/card.css">
    <link rel="stylesheet" href="/css/card2.css">
@endsection

@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>{{__('manager.allTasks')}}</h1>
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
                                @if($task->estimatedEffort)<li><i class="fas fa-hourglass-half"></i>&nbsp; {{__('menu.estimated_effort')}}: {{$task->estimatedEffort}}</li>
                                @endif
                                @if($task->totalEffort)<li><i class="fas fa-hourglass-half"></i>&nbsp; {{__('menu.total_effort')}} Aufwand: {{$task->totalEffort}}</li>
                                @endif
                                @if ($task->deadline)
                                    <li><i class="far fa-calendar-alt"></i> &nbsp;<a id=link
                                            href="{{ $task->calendarICS }}">ICS</a></li>
                                    <li><i class="far fa-calendar-alt"></i> &nbsp;<a id=link
                                            href="{{ $task->calendarGoogle }}">Google Calendar</a></li>
                                    <li><i class="far fa-calendar-alt"></i> &nbsp;<a id=link
                                            href="{{ $task->calendarWebOutlook }}"> WebOutlook Calendar</a>
                                    </li>
                                @endif
                            </ul>
                            
                    </div>
                    <div class="description" id="desc">
                        @if ($task->deadline)
                            <h1 class="h1-color mb-4">
                                <div class="Deadline-title"><i class="far fa-calendar-alt"></i>&nbsp;DEADLINE:
                                    {{ $task->deadline }}</div>
                            </h1>
                        @endif
                        <h1 class="mb-4">{{__('menu.task')}}: {{ $task->title }}</h1>
                        <h2 class="mb-2">{{__('menu.description')}}:</h2>
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
                                aria-controls="collapseExample{{ $task->id }}">{{__('menu.toggle')}}</a>
                        </p>

                        <div class="collapse" id="collapseExample{{ $task->id }}">
                            <h2 class="mt-4">{{__('menu.comment')}}:</h2>
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
        @endforeach
    @else
        <div class="container">
            <h4 class="EmptyWebsite">Keine öffentlichen Aufgaben vorhanden</p>
        </div>
    @endif
@endsection
