@extends('layouts.app')

 @section('content')
 <div class="container">
     <h1>User Export Import</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item">{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    <form action="/CSVNonAdminImport"enctype="multipart/form-data" method="POST">
            @csrf
            <div>
                <input name="file" class="form-control form-control-lg" type="file">
                <button type="submit" class="btn btn-success">Alle Aufgaben importieren</button>
            </div>
            <a href="/CSVNonAdminExport" class="btn btn-warning">Alle Aufgaben exportieren</a>
    </form>

 </div>

 @endsection
