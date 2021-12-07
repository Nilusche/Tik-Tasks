@extends('layouts.app')

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
    <form action="/FindUser" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Input Usermail</label>
            <input type="text" name="email" id="email" class="form-control">
            <button type="submit" class="btn btn-warning">Edit User</button>
        </div>
    </form>
 </div>
 @endif
 @endsection
