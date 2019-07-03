@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="">{{$thread->owner->name}}</a>
                        {{$thread->title}}
                    </div>


                </div>
                <div class="card-body">
                        <div>{{$thread->body}}</div>
                        <hr>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>
    </div>
@endsection
