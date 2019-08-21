@component('profiles.activities.activity')
    @slot('style')
        list-group-item-primary
    @endslot
    @slot('heading')
        <h5 class="mb-1">Created thread <a href="{{$activity->subject->path()}}">"{{$activity->subject->title}}"</a></h5>
        <small>{{$activity->created_at->diffForHumans()}}</small>
    @endslot
    @slot('body')
        Thread:
        {{$activity->subject->body}}
    @endslot
@endcomponent

