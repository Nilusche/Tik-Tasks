@extends('layouts.app')

@section('content')
    @if (auth()->user()->isAdmin())
        <div class="container mb-4">
            <div class="btn btn-secondary position-relative">
                <h1>{{ __('admin.export') }}</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <img style="float:right;width:60%; margin-right:150px" src="sources/import_animation.gif"
                        alt="Settings_Picture">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    @if ($errors->any())
                        <div class="alert alert-danger" style="width: 60%;">
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="/CSVAdminImport" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <input style="width: 60%;" name="file" class="form-control form-control-md" type="file">
                        </div>
                        <div class="row" style="padding-top: 20px;">
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" style="padding: 0px;">
                                <button style="width: 70%;" type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-file-import" style="font-size:20px"></i> Import
                                </button>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" style="padding: 0px;">
                                <a href="/CSVAdminExport" style="width: 70%;" class="btn btn-outline-warning"><i
                                        class="fas fa-file-export"></i>Export</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
