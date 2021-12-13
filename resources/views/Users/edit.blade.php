@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>Profil bearbeiten</h1>
        </div>
    </div>

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

        <form action="{{ route('users.update-profile') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">

            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" @if (!auth()->user()->isAdmin())
                readonly
                @endif
                >
            </div>
            <div class="form-group">
                <label for="about">About Me</label>
                <textarea name="about" id="about" cols="5" rows="5" class="form-control">{{ $user->about }}</textarea>
            </div>
            <button class="btn btn-success">Update Profile</button>
        </form>
    </div>


@endsection
