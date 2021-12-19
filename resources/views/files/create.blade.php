@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bg-light p-5 rounded">
            <h1>Add file</h1>
            
            <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-4">
                <input type="file" name="files[]" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" multiple>
                </div>

                <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Save</button>
            </form>

        </div>
</div>
   
@endsection