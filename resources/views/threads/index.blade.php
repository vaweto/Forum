@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">Forum Threads</h1>
            </div>
        </div>
        @foreach($threads as $thread)
            <div class="row">
                <div class="col-md-12">
                    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-primary">{{$thread->channel->name}}</strong>
                            <h3 class="mb-0"> <a href="{{$thread->path() }}">{{$thread->title}}</a></h3>
                            <div class="mb-1 text-muted"><strong><a href="{{$thread->path() }}">{{$thread->replies_count}} {{Str::plural('reply',$thread->replies_count)}}</a></strong></div>
                            <p class="card-text mb-auto">{{$thread->body}}</p>
                            <a href="{{$thread->path() }}" class="stretched-link">Continue reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
