@extends('layouts.app')

@section('content')
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
                border: 1px solid #08D9D6;
            }
            .list{
                overflow: scroll;;
            }
        </style>

        <div class="grid_b">
            
            <div>
                <form class="form_a_d" action="/DeleteUser/action" method="POST">
                    @csrf
                    <h3 class="loginuber_b">Benutzer löschen</h3>
                    <h5>Vorhandene Benutzer</h5>
                    <ul class="list">
                    @foreach($users as $user)
                        <li style="margin-bottom:-2px">{{$user->email}}</li> 
                    @endforeach
                    </ul>
                    
                    <label for="exampleInputEmail1" class="labelinput_b">Email Addresse</label>
                    <input class="input_b" type="email" class="form-control" name="femail" id="exampleInputEmail1"
                        placeholder="Email Adresse eingeben" aria-describedby="emailHelp" required>
                    <label for="exampleInputEmail2" class="labelinput_b">Email Addresse</label>
                    <input class="input_b" type="email" class="form-control" name="semail" id="exampleInputEmail2"
                        placeholder="Email Adresse wiederholen" aria-describedby="emailHelp" required>

                    <div class="labelinput_b">
                        <input id="confirmCheckbox" name="checkbox" value="true" class="form-check-input" type="checkbox"
                            required>
                        <label class="form-check-label" for="confirmCheckbox">Eingabe bestätigen</label>
                    </div>


                    <button type="submit" class="btn btn-success" name="submit" class="btn btn-success"
                        id="passwort_button_b">User löschen</button>
                    <!-- <div class="social">
                                        <div class="go"><i class="fab fa-google"></i>  Google</div>
                                        <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
                                    </div> -->
                </form>

            </div>
        <div>
            
                    


            </div>
        </div>
    @endif
@endsection
