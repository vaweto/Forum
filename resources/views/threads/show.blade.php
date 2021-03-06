@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="/profiles/{{$thread->owner->name}}">{{$thread->owner->name}}</a>
                                {{$thread->title}}
                            </span>
                            @can('delete', $thread)
                                <form action="{{$thread->path()}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn  btn-danger">DELETE</button>
                                </form>
                            @endcan
                        </div>

                    </div>
                    <div class="card-body">
                        <div>{{$thread->body}}</div>
                        <hr>
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{$replies->links()}}

                @if (auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{$thread->created_at->diffForHumans() }}
                            by <a href="#">{{$thread->owner->name}}</a> and
                            has {{$thread->replies_count}} {{Str::plural('comment', $thread->replies_count)}}
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
