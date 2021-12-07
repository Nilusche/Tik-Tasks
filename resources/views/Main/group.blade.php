@extends('layouts.app')

@section('content')
<div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
         @endif
    <form action="/storeTags" method="GET">
    @csrf
        <div class="form-group">
            <input type="text" name="tag" class="form-control" placeholder="Neuer Gruppenname">
            <button type="submit" class="btn btn-dark form-control">Neu erstellen</button>
        </div>
        <input type="hidden" name="userid" value="{{auth()->user()->id}}">
    </form>

    <form action="/assignTags" method="POST">
        @csrf
        <div class="form-group">
                <select id="selecttag" class="form-control chosen-select" name="tags[]" multiple>
                @foreach($tags as $tag)
                    @if($tag->users_id == auth()->user()->id)
                        <option value="{{$tag->id}}">
                        {{$tag->name}}
                        </option>
                    @endif
                @endforeach
                </select>

        </div>
        <ul class="list-group">
        @foreach($TaskUserPairs as $TaskUserPair)
            @if($TaskUserPair->users_id == auth()->user()->id)
                @foreach($tasks as $task)
                    @if($task->completed==false && $task->id == $TaskUserPair->tasks_id)
                        <li class="list-group-item">
                            <input class="form-check-input me-1" name="tasks[]" type="checkbox" value="{{$task->id}}" aria-label="...">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5>Titel: </h5>{{$task->title}}
                                </div>
                                <div class="col-lg-4">
                                    <h5>Deadline: </h5>{{$task->deadline}}
                                </div>
                                <div class="col-lg-4">
                                    <h5>Gruppen: </h5>
                                    @foreach($tags as $tag)
                                    @if($tag->users_id == auth()->user()->id)
                                        @if($task->hasTag($tag->id))
                                            [{{$tag->name }}]
                                    @endif
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        </ul>
        <button type="submit" class="btn btn-primary">Gruppieren</button>
    </form>



</div>
@endsection
