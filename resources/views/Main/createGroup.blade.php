@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="css/select.css">
@endsection

@section('content')
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
        <form action="/storeTags" method="GET">
            @csrf
            <div class="form-group">
                <input type="text" name="tag" class="form-control" placeholder="Neuer Gruppenname">
                <button type="submit" class="btn btn-dark form-control">Neu erstellen</button>
            </div>
            <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
        </form>
    </div>



@endsection
