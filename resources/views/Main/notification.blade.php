@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="css/notification.css">
@endsection

@section('navbar')
    <div class="container-fluid navcontainer">
        <nav class="navbar navbar-expand-lg navbar-dark back">
            <a class="navbar-brand" href="/Startseite">Tiktasks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto">
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="/Systempanel">Systemverwaltung</a>
                        </li>
                    @endif
                    @if (auth()->user()->isManager())
                        <li class="nav-item">
                            <a class="nav-link" href="/Startseite">Zuweisen</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/Settings">Einstellungen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Startseite">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Ausloggen</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
@endsection

@section('content')
    
    
  <div class="main-content">
  
    <div class="container mt-7">
    <a class="btn btn-primary mb-3" href="/readNotifications">Alle Benachrichtigungen als gelesen markieren</a>
    <a class="btn btn-danger mb-3" href="/notification/delete">Alle Benachrichtigungen löschen</a>
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Benachrichtigungen</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Aufgabe</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Verbliebene Zeit</th>
                    <th scope="col">Priorität</th>
                    <th scope="col">Gelesen</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                
                <tbody>
                @if ($notifications)
                @foreach($notifications as $notification)
                    <?php
                        $noti = DB::table('notifications')->where('id', $notification['taskid'])->get();
                        $task = App\Models\Task::find($notification['taskid']);
                    ?>
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <a class="avatar rounded-circle mr-3" disabled>
                          <img alt="Image placeholder" src="sources/task.png">
                        </a>
                        <div class="media-body">
                          <span class="mb-0 text-sm">{{$notification['taskname']}}</span>
                        </div>
                      </div>
                    </th>
                    <td>
                    {{ $date = date('d-m-Y H:i', strtotime($task->deadline)) }}
                    </td>
                    <td>
                    {{ $notification['diff'] }}
                    </td>
                    <td>
                        {{$task->priority}}
                        @if($task->priority==1)
                        <div class="input-color">
                            <div class="color-box" style="background-color: #4e9f3d;"> 
                        </div>
                        @elseif($task->priority==2)
                        <div class="input-color">
                            <div class="color-box" style="background-color: #fee440;"> 
                        </div>
                        @elseif($task->priority==3)
                        <div class="input-color">
                            <div class="color-box" style="background-color: #ff9300;"> 
                        </div>
                        @elseif($task->priority==4)
                        <div class="input-color">
                            <div class="color-box" style="background-color: #e02401;"> 
                        </div>
                        @elseif($task->priority==5)
                        <div class="input-color">
                            <div class="color-box" style="background-color: #950101;"> 
                        </div>
                        @endif
                    <td>
                    @if ($notification['read_at'] == null)
                        <span class="badge badge-dot mr-4 text-dark">
                        <i class="bg-danger"></i> ungelesen
                      </span>
                    @else
                        <span class="badge badge-dot mr-4 text-dark">
                            <i class="bg-success"></i> gelesen
                        </span>
                    @endif
                    </td>
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="Startseite/{{ $notification['taskid'] }}/edit">Aufgabe ansehen</a>
                          <a class="dropdown-item" href="/notification/{{$notification['id']}}/delete">Benachrichigung löschen</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach 
                @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@endsection
