@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="css/card.css">
@endsection

@section('content')

    <div class="container">

        @if(App::currentLocale()=='de')  
            <span id=erstell><a id=erstellen href=" /Create-task"></a></span>
            <span id=gruppe><a id=gruppieren href="/Group"></a></span>
        @else
            <span id=erstell><a id=erstellenEN href=" /Create-task"></a></span>
            <span id=gruppe><a id=gruppierenEN href="/Group"></a></span>
        @endif
        <div class="btn-group">
            <button class="btn btn-lg dropdown-toggle Sortbtn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if(App::currentLocale()=='de')
                SORTIEREN NACH
            @else
                SORT BY
            @endif
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/SortbyNameAsc">{{__('menu.titleAsc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyNameDesc">{{__('menu.titleDesc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyDeadlineAsc">{{__('menu.deadlineAsc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyDeadlineDesc">{{__('menu.deadlineDesc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyDateAsc">{{__('menu.dateAsc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyDateDesc">{{__('menu.dateDesc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyPriorityAsc">{{__('menu.priorityAsc')}}</a></li>
                <li><a class="dropdown-item" href="/SortbyPriorityDesc">{{__('menu.priorityDesc')}}</a></li>
            </ul>
        </div>
        @if(App::currentLocale()=='de')
            <form class="form-inline filter" method="get" action="/search">
                @csrf
                <input class="form-control mr-sm-2 filterinput" type="search" name="search" placeholder="Filtern nach"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 searchbutton" type="submit"><i
                        class="fas fa-search"></i></button>
            </form>
        @else
            <form class="form-inline filter" method="get" action="/search">
                @csrf
                <input class="form-control mr-sm-2 filterinput" type="search" name="search" placeholder="Filter by"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 searchbutton" type="submit"><i
                        class="fas fa-search"></i></button>
            </form>
        @endif
        @if(App::currentLocale()=='de')
            <form class="form-inline groupfield" method="get" action="/storeTags">
                @csrf
                <input class="form-control filterinput" type="text" name="tag" placeholder="Gruppe erstellen">
                <button class="btn btn-outline-primary my-2 my-sm-0 groupbutton" type="submit"><i
                        class="fas fa-folder-plus"></i></button>
                <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
                <input type="hidden" name="parent_id" value="">
            </form>
        @else
            <form class="form-inline groupfield" method="get" action="/storeTags">
                @csrf
                <input class="form-control filterinput" type="text" name="tag" placeholder="Create Group">
                <button class="btn btn-outline-primary my-2 my-sm-0 groupbutton" type="submit"><i
                        class="fas fa-folder-plus"></i></button>
                <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
                <input type="hidden" name="parent_id" value="">
            </form>
        @endif


        <!-- gibt es Gruppen für den User? -->
        @foreach ($tags as $tag)
            <div class="row">
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <div class="form-group">
                        <a style="text-decoration:none" href="/Startseite/{{ $tag->id }}/view">
                            <div class="row task">
                                <div class="badge bg-primary">
                                    <img src="sources/Ordner.png" alt=""
                                        style="max-height: 60px; float: left; padding-top: 9px; padding-left: 10px">
                                    <div class="card-body overflow-auto">
                                        <h3>{{__('menu.group')}}: {{ $tag->name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <a class="btn btn-danger" type="button" data-bs-toggle="modal"
                            data-bs-target="#deleteGroup{{ $tag->id }}"><i class="fas fa-trash-alt fa-3x"
                                style="font-size: 62px">
                            </i></a>
                    </div>
                </div>
            </div>
            <!-- Modal delete Group-->
            <div class="modal fade" id="deleteGroup{{ $tag->id }}" tabindex="-1" aria-labelledby="deleteGroup"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteGroup">{{__('menu.deletegroup')}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{__('menu.delgroupmodal')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('menu.cancel')}}</button>
                            <a type="button" class="btn btn-danger"
                                href="/Startseite/{{ $tag->id }}/deleteGroup">{{__('menu.confirm')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <!-- gibt es Aufgaben für den User?-->
        @foreach ($tasks as $task)
            @foreach ($TaskUserPairs as $TaskUserPair)
                @if ($TaskUserPair->users_id == auth()->user()->id)
                    @if ($task->completed == false && $task->id == $TaskUserPair->tasks_id)

                        <?php
                        $result = DB::select(
                            'select t.id, t.title, tag.name, tag.users_id
                            from tasks t
                            left join tag_task tt
                            on tt.task_id = t.id
                            left join tags tag
                            on tag.id = tt.tag_id
                            where users_id = :id
                            and t.id = :taskID',
                            ['id' => auth()->user()->id, 'taskID' => $task->id],
                        );
                        /*@if ($result)
                            Objekte die in einer Gruppierung sind, werden nicht angezeigt. 
                        @else*/
                            // Dieser code wurde entfernt sodass, alle aufgaben auf der startseite angezeigt werden
                        ?>
                        <!--
                        
                        -->


                            <div class="container" data-aos="zoom-in-down">
                                <div class="blog-card">
                                    <div class="meta">
                                        <div class="photo" style="background-image: url(sources/task.svg)"></div>
                                        <ul class="details">
                                            <li class="date">{{__('menu.created_at')}}:
                                                {{ $date = date('d-m-Y H:i', strtotime($task->created_at)) }}</li>
                                            <li><i class="fas fa-exclamation-triangle"></i> &nbsp;{{__('menu.priority')}}:
                                                {{ $task->priority }}
                                                @if($task->priority==1)
                                                <div class="input-color">
                                                    <div class="color-box" style="background-color: #4e9f3d;"> <!-- Replace "#FF850A" to change the color -->
                                                </div>
                                                @elseif($task->priority==2)
                                                <div class="input-color">
                                                    <div class="color-box" style="background-color: #fee440;"> <!-- Replace "#FF850A" to change the color -->
                                                </div>
                                                @elseif($task->priority==3)
                                                <div class="input-color">
                                                    <div class="color-box" style="background-color: #ff9300;"> <!-- Replace "#FF850A" to change the color -->
                                                </div>
                                                @elseif($task->priority==4)
                                                <div class="input-color">
                                                    <div class="color-box" style="background-color: #e02401;"> <!-- Replace "#FF850A" to change the color -->
                                                </div>
                                                @elseif($task->priority==5)
                                                <div class="input-color">
                                                    <div class="color-box" style="background-color: #950101;"> <!-- Replace "#FF850A" to change the color -->
                                                </div>
                                                @endif
                                            </li>
     
                                            @if(empty($allTasks))
                                                <li class="tags">
                                                    <ul>
                                                        @foreach ($allTasks as $task2)
                                                            <li>{{ $task2->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                            @if($task->estimatedEffort)<li><i class="fas fa-hourglass-half"></i>&nbsp; {{__('menu.estimated_effort')}}: {{$task->estimatedEffort}}</li>
                                            @endif
                                            @if($task->totalEffort)<li><i class="fas fa-hourglass-half"></i>&nbsp; {{__('menu.total_effort')}}: {{$task->totalEffort}}</li>
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
                                    <div class="description">
                                        @if ($task->deadline)
                                            <h1 class="h1-color mb-4">
                                                <div class="Deadline-title"><i
                                                        class="far fa-calendar-alt"></i>&nbsp;DEADLINE:
                                                    {{ $date = date('d-m-Y H:i', strtotime($task->deadline)) }}</div>
                                            </h1>
                                        @endif
                                        @if ($TaskUserPair->isOwner == 0)
                                            <h1 class="date text-danger mb-4">{{__('menu.assigned')}}</h1>
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
                                        <b class="mr-4 ">
                                                    <button class="btn btn-warning but mt-2 " href="" data-bs-toggle="modal"
                                                        data-bs-target="#finish{{ $task->id }}"><i
                                                            class="fas fa-check-circle"></i>{{__('menu.finish')}}</button>
                                        </b>
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
                                            <!-- Verbleibende Zeit wird nur angezeigt wenn keine Deadline vorhanden ist -->
                                            @if ($task->deadline)
                                                <h2 class="mt-3">{{__('menu.remainingtime')}}: <span class="h1-color">
                                                        {{ $totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline) }}</span>
                                                </h2>
                                            @endif


                                            <div class="mt-4">
                                                @foreach ($taskOwner as $to)
                                                    @if ($to->tasks_id == $task->id)
                                                        <b>
                                                            <button class="btn btn-danger but" href=""
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteTask{{ $task->id }}"><i
                                                                    class="fas fa-trash-alt"></i>{{__('menu.delete')}}</button>
                                                        </b>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <p class="read-more">
                                                <a href="/Startseite/{{ $task->id }}/edit">{{__('menu.edit')}}</a>
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Modal Delete Task-->
                            @foreach ($taskOwner as $to)
                                @if ($to->tasks_id == $task->id)
                                    <div class="modal fade" id="deleteTask{{ $task->id }}" tabindex="-1"
                                        aria-labelledby="deleteTaskLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteTaskLabel">{{__('menu.delete')}} {{__('menu.task')}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{__('menu.deltaskmodal')}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{__('menu.cancel')}}</button>
                                                    <a type="button" class="btn btn-danger"
                                                        href="/Startseite/{{ $task->id }}/delete">{{__('menu.confirm')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Modal finish Task-->
                            <div class="modal fade" id="finish{{ $task->id }}" tabindex="-1"
                                aria-labelledby="finishLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="finishLabel">{{__('menu.finish')}} {{__('menu.task')}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{__('menu.finishtaskmodal')}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{__('menu.cancel')}}</button>
                                            <a type="button" class="btn btn-danger"
                                                href="/Startseite/{{ $task->id }}/complete">{{__('menu.confirm')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        
                    @endif
                @endif
            @endforeach
        @endforeach
        @if (auth()->user()->isManager())
            <a href="Startseite/PublicTasks">
                <div class="container">
                    <div class="row task">
                        <div class="badge bg-primary">
                            <div class="card-body overflow-auto">
                                <h4>{{__('manager.allTasks')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endif
    </div>
@endsection
