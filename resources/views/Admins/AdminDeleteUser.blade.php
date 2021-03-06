@extends('layouts.app')

@section('content')
    <div class="container">
        @if (auth()->user()->isAdmin())
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <style>
                    [type="checkbox"] {
                        margin-right: 2em;
                        position: relative;
                        z-index: 0;
                        -webkit-appearance: none;
                        border: 1px solid #e62755;
                    }
                    .list{
                        overflow-Y: scroll;
                        height: 120px;
                    }
                </style>
                <form class="form_a_d" action="/DeleteUser/action" method="POST">
                    @csrf
                    <h3 class="loginuber_b">{{__('admin.delUser')}}</h3>
                    <h5>{{__('admin.avaiUser')}}</h5>
                    <ul class="list">
                        @foreach($users as $user)
                            <li style="margin-bottom:-2px">{{$user->email}}</li>
                        @endforeach
                    </ul>

                    <label for="exampleInputEmail1" class="labelinput_b">{{__('profile.email')}}</label>
                    <input class="input_b" type="email" class="form-control" name="femail" id="exampleInputEmail1"
                           placeholder="Email Adresse eingeben" aria-describedby="emailHelp" required>
                    <label for="exampleInputEmail2" class="labelinput_b">{{__('profile.email')}}</label>
                    <input class="input_b" type="email" class="form-control" name="semail" id="exampleInputEmail2"
                           placeholder="Email Adresse wiederholen" aria-describedby="emailHelp" required>

                    <div class="labelinput_b">
                        <input id="confirmCheckbox" name="checkbox" value="true" class="form-check-input" type="checkbox"
                               required>
                        <label class="form-check-label" for="confirmCheckbox">{{__('admin.confirm')}}</label>
                    </div>


                    <button type="submit" class="btn btn-success" name="submit" class="btn btn-success"
                            id="passwort_button_b">{{__('admin.delUser')}}</button>
                </form>
        @endif
    </div>
@endsection
