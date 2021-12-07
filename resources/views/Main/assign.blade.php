@extends('layouts.app')

@section('content')
@if(auth()->user()->isManager())
    <div>
        <h1>Zuweisung</h1>
        <form action="/assignTasks" method ="POST">
            @csrf
            <div>
                <input type = "text" name ="operator">
            </div>
            <div>
                @foreach($TaskUserPairs as $TaskUserPair)
                    @if($TaskUserPair->users_id == auth()->user()->id)
                        @foreach($tasks as $task)
                            @if($task->completed==false && $task->id == $TaskUserPair->tasks_id)
                                <li class = "list-group-item">
                                    <label>
                                        <input class ="form-check-input me-1" name ="tasks[]" type ="checkbox" value ="{{$task->id}}" aria-label ="...">
                                        {{$task->title}}
                                    </label>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            <div>
                <input id="zuweisenbutton" class="btn btn-info" type ="submit" name = "send">
            </div>
        </form>
    </div>
@endif
@endsection
