@extends('layouts.app')

@section('content')
    <style>
        .btn btn-success {
            z-index: -100;
        }

    </style>
    @if (auth()->user()->isAdmin())
        <div class="container">
            

            <body>
                <div class="grid_b">
                    <div>
                        <form class="form_a_u" action="/User/{{ $user->id }}/update" method="POST">
                            @csrf
                            <div>
                                <h3 class="loginuber_b">{{__('admin.update')}}</h3>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-group">
                                        @foreach ($errors->all() as $error)
                                            <li class="list-group-item">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="teil_a_u">
                                <div> <label class="labelinput_b" for="name">Name: </label>
                                    <input class="input_b" type="text" class="form-control" name="name" id="name"
                                        value="" placeholder="{{$user->name}}" readonly onfocus="this.removeAttribute('readonly');">

                                    <label class="labelinput_b" for="email">{{__('profile.email')}}: </label>
                                    <input class="input_b" class="form-control" name="email" id="email" value=""
                                        placeholder="{{$user->email}}" readonly onfocus="this.removeAttribute('readonly');">
                                </div>
                                <div>
                                    <label class="labelinput_b" for="password">{{__('profile.newpwd')}}</label>
                                    <input class="input_b" type="password" class="form-control" name="password"
                                        id="password" value="" placeholder="Neues Passwort" readonly onfocus="this.removeAttribute('readonly');">

                                    <label class="labelinput_b" for="confirmpassword">{{__('profile.confirmpwd')}}</label>
                                    <input class="input_b" type="password" class="form-control"
                                        name="confirmpassword" id="confirmpassword" value=""
                                        placeholder="Neues Paswort wiederholen" readonly onfocus="this.removeAttribute('readonly');">
                                </div>
                                <div>
                                    <label class="labelinput_b" for="role">{{__('admin.roleselect')}}</label>
                                    <select name="role" id="role">
                                        @if($user->role == 'worker')
                                            <option value="worker" selected>{{__('admin.worker')}}</option>
                                            <option value="manager">{{__('admin.manager')}}</option>
                                            <option value="admin">{{__('admin.admin')}}</option>
                                        @elseif($user->role=='admin')
                                            <option value="worker">{{__('admin.worker')}}</option>
                                            <option value="manager">{{__('admin.manager')}}</option>
                                            <option value="admin" selected>{{__('admin.admin')}}</option>
                                        @elseif($user->role=='manager')
                                            <option value="worker">{{__('admin.worker')}}</option>
                                            <option value="manager" selected>{{__('admin.manager')}}</option>
                                            <option value="admin">{{__('admin.admin')}}</option>
                                        @else
                                            <option value="worker">{{__('admin.worker')}}</option>
                                            <option value="manager">{{__('admin.manager')}}</option>
                                            <option value="admin">{{__('admin.admin')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div><button type="submit" class="btn btn-success" id="passwort_button_b">{{__('admin.update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </body>
        </div>
    @endif
@endsection

@section('bottomscripts')
<script>
    $( document ).ready(function() {
    $('input').attr('autocomplete','off');
    });
</script>
@endsection