@extends('layouts.app')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #e62755;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }
        .tag-wrapper {
            max-height: 100px;
            max-width: 27em;
            overflow-x: auto;
            overflow-y: auto;
            display:inline-block;
        }
        .links{
            max-height: 100px;
            max-width: 27em;
            overflow-x: auto;
            overflow-y: auto;
            display:inline-block;
        }

        .btn-outline-danger:hover{
            background-color:#e62755;
        }
        .btn{
            background-color:white;
        }
    </style>
@endsection
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
        <form action="/Startseite/{{ $task->id }}/Update-tasks-limited" method="POST">
            @csrf
            <div class="row">
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="title">{{__('crud.title')}} *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}"
                            placeholder="Titel der Aufgabe" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">{{__('crud.description')}}</label>
                        <textarea class="form-control" name="description" id="description" cols="30"
                            rows="9" readonly>{{ $task->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="comment">{{__('crud.comment')}}</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="{{ $task->comment }}"
                            placeholder="{{__('crud.comment')}}" >
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="alarm" class="">{{__('crud.alarm')}}</label>
                        <select class="form-select" id="alarm" name="alarm" aria-label="Default select example">
                            @if ($task->alarmdateInteger == 0)
                                <option value="0" selected>{{__('crud.due')}}</option>
                                <option value="1">{{__('crud.1hr')}}</option>
                                <option value="2">{{__('crud.1d')}}</option>
                                <option value="3">{{__('crud.deadline-effort')}}</option>
                                <option value="4">{{__('crud.never')}}</option>
                            @elseif($task->alarmdateInteger==1)
                                <option value="0" >{{__('crud.due')}}</option>
                                <option value="1" selected>{{__('crud.1hr')}}</option>
                                <option value="2">{{__('crud.1d')}}</option>
                                <option value="3">{{__('crud.deadline-effort')}}</option>
                                <option value="4">{{__('crud.never')}}</option>
                            @elseif($task->alarmdateInteger==2)
                                <option value="0">{{__('crud.due')}}</option>
                                <option value="1">{{__('crud.1hr')}}</option>
                                <option value="2" selected>{{__('crud.1d')}}</option>
                                <option value="3">{{__('crud.deadline-effort')}}</option>
                                <option value="4">{{__('crud.never')}}</option>
                            @elseif($task->alarmdateInteger==3)
                                <option value="0">{{__('crud.due')}}</option>
                                <option value="1">{{__('crud.1hr')}}</option>
                                <option value="2">{{__('crud.1d')}}</option>
                                <option value="3"selected>{{__('crud.deadline-effort')}}</option>
                                <option value="4">{{__('crud.never')}}</option>
                            @elseif($task->alarmdateInteger==4)
                                <option value="0">{{__('crud.due')}}</option>
                                <option value="1">{{__('crud.1hr')}}</option>
                                <option value="2">{{__('crud.1d')}}</option>
                                <option value="3">{{__('crud.deadline-effort')}}</option>
                                <option value="4" selected>{{__('crud.never')}}</option>
                            @else
                                <option value="0">{{__('crud.due')}}</option>
                                <option value="1">{{__('crud.1hr')}}</option>
                                <option value="2">{{__('crud.1d')}}</option>
                                <option value="3">{{__('crud.deadline-effort')}}</option>
                                <option value="4" selected>{{__('crud.never')}}</option>
                            @endif

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="effort" class="form-label">{{__('crud.estimated_effort')}}</label>
                        <input type="number" class="form-control" id="effort" name="effort" min="0"
                            value="{{ $task->estimatedEffort }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="effort2" class="form-label">{{__('crud.total_effort')}}</label>
                        <input type="number" class="form-control" id="effort2" name="effort2" min="0"
                            value="{{ $task->totalEffort }}" placeholder="3.5">
                    </div>
                    <div class="form-group"></div><br>
                    <div class="form-group">
                        <p>{{__('crud.requiredfields')}}</p>
                    </div>
                    <div class="form-group">
                        <span id=speicher><a id=speichern onclick="this.closest('form').submit();return false;"></a></span>
                    </div>
                </div>
                <div class="createform col-lg-4 col-md-4 col-sm-4">
                    <div class="links">
                        <div class="form-group">
                            <label for="links" class="form-label">{{__('crud.avaLinks')}}</label>
                            <div class="form-item" id="links">
                                @foreach($task->links as $link)
                                    <a class=" btn btn-outline-danger"href="https://{{ $link->name }}">{{ $link->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div><br>
                
                    <div class="form-group tag-wrapper">
                        <label for="links" class="form-label">{{__('crud.links')}}</label>
                        <input class="form-control" type="text" data-role="tagsinput" id="links" name="links" value="{{old('links')}}">
                    </div>
                    <br>
                    <img class="createTaskpic" src="/sources/editTask.svg" alt="taskpicture" style="height:20em; width:auto;">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('bottomscripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
@endsection
