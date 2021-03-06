@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/css/passwordchange.css">
@endsection

@section('content')
<div class="container">
        <div class="btn btn-secondary position-relative">
            <h1>{{__('profile.changepwd')}}</h1>
        </div>
    </div>
<div class="container">
    <form method="POST" action="/Profile/update-password">
    @csrf                  
        <div class="card card-1">          
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach 
                <div class="row">
                    <div class="col-lg-6">
                        <label for="password" class=" col-lg-4 col-form-label pl-0 ">{{__('profile.oldpwd')}}</label>
                            <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                        </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="new_password" class=" col-lg-4 col-form-label pl-0 w-100">{{__('profile.newpwd')}}</label>
                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="new_confirm_password" class=" col-lg-8 col-form-label pl-0">{{__('profile.confirmpwd')}}</label>
                        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mt-5">
                        <button type="submit" class="btn btn-primary">{{__('profile.changepwd')}} </button>
                    </div>
                </div>
        </div>
    </form>   
</div>

@endsection

