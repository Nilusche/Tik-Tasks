@extends('layouts.app')
 @section('navbar')
    <div class="container-fluid navcontainer">
        <nav class="navbar navbar-expand-lg navbar-dark back">
        <a class="navbar-brand" href="/Startseite">Tiktasks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto">
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="/Startseite">Systemverwaltung</a>
                </li>
                @endif
                @if(auth()->user()->isManager())
                <li class="nav-item">
                    <a class="nav-link" href="/Startseite">Zuweisen</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/Settings">Einstellungen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Startseite">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Ausloggen</a>
                </li>
                </ul>
            </div>
        </nav>
    </div>
 @endsection

 @section('content')

 @if(auth()->user()->isAdmin())
 <div class="container">
    <h1>Edit User</h1>
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
                </ul>
            </div>
    @endif
    <form action="/User/{{$user->id}}/update" method="POST"> 
        @csrf
        <div class="form-group">
            <label for="name">Name: {{$user->name}}</label>
            <input type="text" class="form-control" name="name" id="name" value="" placeholder="Neuer Name">
            
        </div>
        <div class="form-group">
            <label for="email">E-mail: {{$user->email}}</label>
            <input type="text" class="form-control" name="email" id="email" value="" placeholder="Neue Email">
        </div>
        <div class="form-group">
            <label for="password">Passwords</label>
            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Neues Passwort">
        </div>
        <div class="form-group">
            <label for="confirmpassword">Confirm password</label>
            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" value="" placeholder="Neues Paswort wiederholen">
        </div>
        <button type="submit" class="btn btn-success">Update User</button>
    </form>

 </div>
 @endif
 @endsection