@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @forelse($threads as $thread)
                    <div class="card">
                        <div class="card-body">
                            <div class="level">
                                <h4 class="card-title flex">
                                    {{$thread->id}} <a href="{{$thread->path()}}">{{$thread->title}}</a>
                                </h4>
                                <a href="{{$thread->path()}}">
                                    <strong>{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</strong>
                                </a>
                            </div>
                            <div class="card-text">{!!$thread->body!!}</div>
                        </div>
                    </div>
                    @empty
                    <p> No threads in this channel.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
