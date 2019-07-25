@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="..." class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{$profileUser->name}}</h5>
                            <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    @forelse($threads as $thread)
                        <div class="card-body">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{$thread->path() }}">{{$thread->title}}</a>
                                </h4>
                            </div>
                            <div>{{$thread->body}}</div>
                            <hr>
                        </div>
                    @empty
                        No threads yet
                    @endforelse
                    {{$threads->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection