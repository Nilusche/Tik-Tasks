@extends('layouts.app')

@section('content')

    @if (auth()->user()->isAdmin())
        <div class="container">

            

            <div class="grid_b">

                <div>
                    <!--
                                <div class="background_b_bearb">
                                    <div id="redsphere_a_eu" class="sphere_g" style="left: 400px; bottom: -300px;"></div>
                                    <div id="bluesphere_a_eu" class="sphere_g" style="left: -100px;top: 100px;"></div>

                                </div>
                            -->
                        
                    <form class="form_b_b" action="/FindUser" method="POST">
                        
                        <h3 class="loginuber_b">Benutzer bearbeiten</h3>
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-group">
                                        @foreach ($errors->all() as $error)
                                            <li class="list-group-item">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @csrf
                        <label class="labelinput_b" for="Benutzer">Benutzer auswählen</label>
                        <select name="Benutzer" id="Benutzer">
                            <option value="" selected>Auswählen</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->email}}</option>
                            @endforeach
                        </select>
                        

                        <button type="submit" class="btn btn-warning" name="submit" id="passwort_button_b">Edit
                            User</button>
                        <!-- <div class="social">
                                        <div class="go"><i class="fab fa-google"></i>  Google</div>
                                        <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
                                    </div> -->
                    </form>
                </div>
                <div class="logo">


                </div>
            </div>

        </div>


    @endif

@endsection
