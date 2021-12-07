@extends('layouts.app')

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
