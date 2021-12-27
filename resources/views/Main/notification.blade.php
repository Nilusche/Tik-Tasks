@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="css/notification.css">
@endsection

@section('content')
    
    
  <div class="main-content">
  
    <div class="container mt-7">
    <a class="btn btn-primary mb-3" href="/readNotifications">{{__('menu.read_notification')}}</a>
    <a class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#delete" href="">{{__('menu.delete_notification')}}</a>
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">{{__('menu.notifications')}}</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">{{__('menu.task')}}</th>
                    <th scope="col">{{__('menu.deadline')}}</th>
                    <th scope="col">{{__('menu.remainingtime')}}</th>
                    <th scope="col">{{__('menu.priority')}}</th>
                    <th scope="col">{{__('menu.read')}}</th>
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
                        <i class="bg-danger"></i> {{__('menu.unread')}}
                      </span>
                    @else
                        <span class="badge badge-dot mr-4 text-dark">
                            <i class="bg-success"></i> {{__('menu.read')}}
                      </span>
                        </span>
                    @endif
                    </td>
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="/notification/{{$notification['id']}}/read">{{__('menu.read_single_notification')}}</a>
                          <a class="dropdown-item" href="Startseite/{{ $notification['taskid'] }}/edit">{{__('menu.showtask')}}</a>
                          <a class="dropdown-item" href="/notification/{{$notification['id']}}/delete">{{__('menu.delete_single_notification')}}</a>
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

      <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteLabel">{{__('menu.delete_notification')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    {{__('menu.delete_noti_modal')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal">{{__('menu.cancel')}}</button>
                        <a type="button" class="btn btn-danger"href="/notification/delete">{{__('menu.confirm')}}</a>
                    </div>
                </div>
            </div>
        </div>

@endsection
