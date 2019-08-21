@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-header">
        <h1>{{$profileUser->name}}
            <small> prisijungė {{$profileUser->created_at->diffForHumans()}}</small>
        </h1>
    </div>
    <div>
        <ul class="list-group">
            @forelse($activities as $date =>$activity)
            <h3 class="page-header">{{$date}}</h3>
            @foreach($activity as $record)
            @if(view()->exists("profiles.activities.{$record->type}"))
                @include("profiles.activities.{$record->type}",['activity'=> $record])
                    @endif
                    {{-- <li class="list-group-item list-group-item-primary">A simple primary list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-secondary">A simple secondary list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-success">A simple success list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-danger">A simple danger list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-warning">A simple warning list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-info">A simple info list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-light">A simple light list group item</li>--}}
                    {{-- <li class="list-group-item list-group-item-dark">A simple dark list group item</li>--}}
                    @endforeach
                  @empty
                    <p>There is no activity for this time.</p>

                  @endempty
                  @endforelse
        </ul>
    </div>
</div>

@endsection
