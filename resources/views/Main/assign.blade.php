@extends('layouts.app')

@section('content')
    @if (auth()->user()->isManager())
        <div class="container">
            <div class="btn btn-secondary position-relative">
                <h1>{{ __('manager.assign') }}</h1>
            </div>
        </div>

        <div class="container">
            <div class="assignpanel">
                <img src="sources/assignTask.svg" alt="assignTask Picture">
                @if ($TaskUserPairs->first())
                    <form id="zuweisen" action="/assignTasks" method="POST">
                        @csrf
                        <label class="labelinput_b" for="Benutzer">{{ __('admin.selectuser') }}</label>
                        <select name="operator" id="Benutzer">
                            <option value="" selected></option>
                            @foreach ($users as $user)
                                <option value="{{ $user->email }}">{{ $user->name }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                        <div id="zuweisen-list">
                            @foreach ($TaskUserPairs as $TaskUserPair)
                                @if ($TaskUserPair->users_id == auth()->user()->id)
                                    @foreach ($tasks as $task)
                                        @if ($task->completed == false && $task->id == $TaskUserPair->tasks_id)
                                            <li id="zuweisen-item" class="list-group-item">
                                                <label>
                                                    <input class="form-check-input me-1" name="tasks[]" type="checkbox"
                                                        value="{{ $task->id }}" aria-label="...">
                                                    {{ $task->title }}
                                                </label>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        <div>
                            <input id="zuweisenbutton" class="btn btn-secondary" type="submit" name="send"
                                value="{{ __('manager.send') }}">
                        </div>
                    </form>
                @else
                    <div class="container">
                        <h4 class="EmptyWebsite">{{ __('manager.notask') }}</h4>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
