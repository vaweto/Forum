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
        @if (auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-offset-2">
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                </div>
            </div>
        @endif
    </div>
@endsection
