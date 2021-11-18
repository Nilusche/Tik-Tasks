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
    <div class="container">
        <h1>Edit Profile</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('users.update-profile')}}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
            
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}"
            @if(!auth()->user()->isAdmin()) 
                readonly
            @endif
            >
        </div>
        <div class="form-group">
            <label for="about">About Me</label>
            <textarea name="about" id="about" cols="5" rows="5" class="form-control">{{$user->about}}</textarea>
        </div>
        <button class="btn btn-success">Update Profile</button>
        </form>
    </div>
    

 @endsection