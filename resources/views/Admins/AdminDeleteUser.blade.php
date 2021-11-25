@extends('layouts.app')
@section('navbar')
    <div class="container-fluid navcontainer">
        <nav class="navbar navbar-expand-lg navbar-dark back">
            <a class="navbar-brand" href="/Startseite">Tiktasks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto">
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="/Startseite">Systemverwaltung</a>
                        </li>
                    @endif
                    @if (auth()->user()->isManager())
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
    @if (auth()->user()->isAdmin())
        <div class="container">
            <h1>Delete User</h1>
            <form action="/DeleteUser/action" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Addresse</label>
                    <input type="email" class="form-control" name="femail" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Email Adresse wiederholen</label>
                    <input type="email" name="semail" class="form-control" id="exampleInputPassword1" required>
                </div>
                <div>
                    <input id="confirmCheckbox" name="checkbox" value="true" class="form-check-input" type="checkbox"
                        required>
                    <label class="form-check-label" for="confirmCheckbox">Eingabe bestätigen</label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    @endif
@endsection