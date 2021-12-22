@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/css/register.css">
@endsection

@section('content')
<form  method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="container w-50 registerform">
    <h4>Benutzer Registrieren</h4>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6">
                <label for="registerusername" class="loginlabel">Benutzername</label>
                <input type="text" name="name" placeholder="Max Musterman" id="registerusername"  class="loginput @error('name') is-invalid @enderror input"  required autocomplete="name" autofocus>
                <label for="registeremail"  class="loginlabel">E-Mail</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong style="color:red;">{{ $message }}</strong>
                    </span>
                @enderror
                <input type="text" placeholder="name@example.net" id="registeremail" name="email" class="loginput @error('email') is-invalid @enderror input" required autocomplete="email">
                <div id="fehlermeldung">

                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <label for="registerpassword" class="loginlabel"  name="password">Geben sie das neue Passwort ein</label>
                <input type="password" placeholder="Neues Passwort" id="registerpassword" name="password" class="loginput  @error('password') is-invalid @enderror input" required autocomplete="new-password">
                <label for="registerpasswordconfirm" class="loginlabel">Best&auml;tigen sie das Passwort</label>
                <input type="password" placeholder="Passwort bestätigen" id="registerpasswordconfirm"  class="loginput input"  name="password_confirmation" required autocomplete="new-password">

                <label for="auswahlrolle" class="loginlabel">Geben sie die Rolle des Benutzers ein</label>
                <select class="auswahlrolle input" name="roleSelect">
                    <option value="1">Mitarbeiter</option>
                    <option value="2">Vorgesetzter</option>
                    <option value="3">Administrator</option>
                </select>


            </div>
            <button id="registerbutton">Registrieren</button>
        </div>
    </div>
    
</form>
@endsection
