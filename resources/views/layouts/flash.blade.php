<div class="container">
    @include('flash::message')
    @if(Session::has('flash_message'))

        <div class="alert alert-success">
            {{Session::get('flash_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
        </div>
    @endif
</div>