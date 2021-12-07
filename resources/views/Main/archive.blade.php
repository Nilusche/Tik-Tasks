@extends('layouts.app')

 @section('content')
 <div class="container">
     <h1>Aufgabenarchiv</h1>
 </div>
 <div class="container">

    <span id=leere ><a id=leeren href="/deleteArchive" ></a></span>
            @foreach($TaskUserPairs as $TaskUserPair)
                @if($TaskUserPair->users_id == auth()->user()->id)
                    @foreach($tasks as $task)
                        @if($task->completed==true && $task->id == $TaskUserPair->tasks_id)
                            <div class="container">
                                <div class="row task">
                                    <div class="col-lg-11 col-md-11 col-sm-11">
                                        <div class="card tabsize">
                                            <div class="card-header text-center aufgabenwrapper">
                                                <h4 class="card-title">
                                                    @if(!empty($task->deadline))
                                                        {{$date = date("d-m-Y", strtotime($task->deadline));}}
                                                    @endif
                                                </h4>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <p class="text">Erstellt am: {{$date = date("d-m-Y H:i", strtotime($task->created_at));}}<br><br></p>
                                                <h4 class="card-title text-center">{{$task->title}}</h4><br>
                                                <p class="text"><h5 class="card-title">Beschreibung</h5>{{$task->description}}</p>
                                                <p class="text"><h5 class="card-title">Kommentare</h5>{{$task->comment}}<br><br></p>
                                            </div>
                                            <div class="card-footer text-muted text-center">
                                                {{$totalDuration = Carbon\Carbon::now()->diffForHumans($task->deadline);}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
 @endsection
