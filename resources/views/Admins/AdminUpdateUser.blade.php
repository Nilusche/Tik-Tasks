@extends('layouts.app')

@section('content')
    <style>.btn btn-success{
            z-index: -100;
        }</style>
    @if(auth()->user()->isAdmin())
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
            <body>
            <div class="grid_b">
                <div>
                    <div class="background_user_änd">
                        <div id="bluesphere_a_u" class="sphere_g"></div>
                        <div id="redsphere_a_u" class="sphere_g"></div>
                    </div>
                    <form class="form_a_u" action="/User/{{$user->id}}/update" method="POST">
                        @csrf
                        <div >
                            <h3   class="loginuber_b">Benutzerdaten ändern</h3>
                        </div>

                        <div class="teil_a_u" >
                            <div> <label class="labelinput_b" for="name">Name: </label>
                                <input class="input_b" type="text" class="form-control" name="name" id="name" value="" placeholder="Neuer Name">

                                <label class="labelinput_b" for="email">E-mail: </label>
                                <input class="input_b" class="form-control" name="email" id="email" value="" placeholder="Neue Email">
                            </div>
                            <div >
                                <label class="labelinput_b" for="password">Password</label>
                                <input class="input_b" type="password" class="form-control" name="password" id="password" value="" placeholder="Neues Passwort">

                                <label class="labelinput_b" for="confirmpassword">Confirm password</label>
                                <input class="input_b" type="password" class="form-control" name="confirmpassword" id="confirmpassword" value="" placeholder="Neues Paswort wiederholen">
                            </div>
                        </div>

                        <div  ><button type="submit" class="btn btn-success" id="passwort_button_b">Update User</button></div>
                    </form>
                </div>
            </div>
            </body>
        </div>
    @endif
@endsection
