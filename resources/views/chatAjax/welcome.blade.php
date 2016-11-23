@extends('layouts.app')
@extends('layouts.flash')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 " id="message-list">

                <h1>Messages</h1>
                @foreach($data['messages'] as $message)
                    <div class="row">
                        <div id="cred{{$message->id}}">
                            <div class="col-md-1 "><h3>{{$message->user->name}}</h3></div>
                            <div class="col-md-2 ">{{$message->published_at}}</div>
                            <div class="col-md-2 ">
                                {{--@if(key_exists('teams',$message))--}}
                                    @foreach($message->teams as $team)
                                    <h4>{{$team->name}}</h4>
                                    @endforeach
                                {{--@endif--}}
                            </div>
                        </div>
                        <div id="mess{{$message->id}}">
                            <div class="col-md-4 ">
                                   <h4>{{$message->message}}</h4>
                            </div>
                            <div class="col-md-3 ">
                                @if($message->user->id==Auth::user()->id)
                                    <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{$message->id}}">Edit</button>
                                    <button class="btn btn-danger btn-xs btn-delete delete-task" value="{{$message->id}}">Delete</button>
                                @endif

                            </div>
                        </div>
            </div>
            @endforeach
        </div>
            <div class="col-md-8 col-lg-offset-2">

                <legend>Your Message</legend>
                <form action="" id="frmMessage">
                    <div class="form-group">

                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="messAdd" placeholder="message" required name="message" id="messAdd">
                            </div>
                            <legend>Choose Team</legend>
                            <div class="col-lg-4">

                                <select multiple class="form-control" id="teams" name="teams[]">

                                    @foreach($data['teams'] as $team)
                                        <option value={{$team->id}}>{{$team->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button class="btn btn-primary " id="btn-add" value="add">Send</button>
                        </div>
                    </div>
                </form>

                @include('errors.list')
                @include('layouts.modal')
                <meta name="_token" content="{!! csrf_token() !!}" />
            </div>
    </div>
    </div>


@stop