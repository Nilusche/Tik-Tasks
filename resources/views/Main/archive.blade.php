@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="css/card.css">
@endsection
@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>{{__('settings.archive')}}</h1>
        </div>
    </div>
    <div class="container">
    @if(App::currentLocale()=='de')  
        <span id=leere><a id=leeren data-bs-toggle="modal" data-bs-target="#delarchive" href=""></a></span>
    @else
        <span id=leere><a id=leerenEN data-bs-toggle="modal" data-bs-target="#delarchive" href=""></a></span>
    @endif
        @foreach ($TaskUserPairs as $TaskUserPair)
            @if ($TaskUserPair->users_id == auth()->user()->id)
                @foreach ($tasks as $task)
                    @if ($task->completed == true && $task->id == $TaskUserPair->tasks_id)
                        <div class="container">
                            <div class="blog-card">
                                <div class="meta">
                                    <div class="photo" style="background-image: url(sources/task.svg)"></div>
                                    <ul class="details">
                                            <li class="date">{{__('menu.created_at')}}:
                                                {{ $date = date('d-m-Y H:i', strtotime($task->created_at)) }}</li>
                                            <li><i class="fas fa-exclamation-triangle"></i> &nbsp;{{__('menu.priority')}}:
                                                {{ $task->priority }}</li>
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
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
    <div class="modal fade" id="delarchive" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteLabel">{{__('settings.deletearchive')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    {{__('settings.delarchivemodal')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal">{{__('menu.cancel')}}</button>
                        <a type="button" class="btn btn-danger"href="/deleteArchive">{{__('menu.confirm')}}</a>
                    </div>
                </div>
            </div>
        </div>
@endsection
