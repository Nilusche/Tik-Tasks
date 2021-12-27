@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/css/passwordchange.css">
@endsection

@section('content')
    <div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>{{__('profile.editprofile')}}</h1>
        </div>
    </div>
    <div class="container">
        <form action="{{ route('users.update-profile') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card card-2">          
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach 
                <div class="row">
                    <div class="col-lg-6 mt-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mt-3">
                        <label for="email">{{__('profile.email')}}</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" @if (!auth()->user()->isAdmin())
                        readonly
                        @endif
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mt-3">
                        <label for="about">{{__('profile.aboutme')}}</label>
                        <textarea name="about" id="about" cols="5" rows="5" class="form-control">{{ $user->about }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mt-5">
                        <button type="submit" class="btn btn-primary">{{__('profile.update-profile')}} </button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
