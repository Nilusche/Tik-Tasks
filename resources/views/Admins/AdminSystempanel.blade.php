@extends('layouts.app')

 @section('content')
 @if(auth()->user()->isAdmin())
 <div class="container">
    <a href="/EditUser" class="btn btn-primary">Benutzer bearbeiten</a>
    <a href="{{route('register')}}" class="btn btn-warning">Benutzer registrieren</a>
    <a href="/DeleteUser" class="btn btn-warning">Benutzer löschen</a>
    <a href="/AdminExportImport" class="btn btn-danger">Sämtliche Aufgaben exportieren und importieren</a>

</div>
 @endif
 @endsection
