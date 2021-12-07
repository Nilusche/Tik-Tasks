@extends('layouts.app')

 @section('content')
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
    <form action="/CSVAdminImport"enctype="multipart/form-data" method="POST">
            @csrf
            <div>
                <input name="file" class="form-control form-control-lg" type="file">
                <button type="submit" class="btn btn-success">Alle Aufgaben importieren</button>
            </div>
            <a href="/CSVAdminExport" class="btn btn-warning">Alle Aufgaben exportieren</a>
    </form>

 </div>
 @endif
 @endsection
