@extends('layouts.app')
@extends('layouts.flash')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">

                <h1>Messages</h1>
                @foreach($data['messages'] as $message)
                    <div class="row">
                        <div class="col-md-3 "><h3>{{$message->user->name}}</h3></div>
                        <div class="col-md-3 ">{{$message->published_at}}</div>
                        <div class="col-md-3 ">
                            @if($message->user->id==Auth::user()->id)
                            <a href="chat/{{$message->id}}?id={{$message->id}}"><h2>{{$message->message}}</h2></a></div>
                            @else
                            <a href=""><h2>{{$message->message}}</h2></a></div>
                            @endif
                        <div class="col-md-3 ">
                            @if($message->user->id==Auth::user()->id)
                                <form action="chat/{{$message->id}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>

                             @endif

                        </div>
                    </div>
                @endforeach
                <div class="col-md-5 col-md-offset-3">
                    <form class="form-horizontal" action="\chat/{{$data['message']->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if($data['method']=="PUT")
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" value={{$data['message']->id}}>
                        @endif
                        <fieldset>
                            <legend>Your Message</legend>

                            <div class="form-group">
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="message" placeholder="message" required name="message" value="{{$data['message']->message}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button class="btn btn-primary">Send</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                    @include('errors.list')
                </div>
            </div>
        </div>
    </div>


@stop
