@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$thread->title}}</div>


                </div>
                <div class="card-body">
                        <div>{{$thread->body}}</div>
                        <hr>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            @foreach($thread->replies as $reply)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <a href="">{{$reply->owner->name}} </a>
                            said {{$reply->created_at->diffForHumans()}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div>{{$reply->body}}</div>
                        <hr>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection
