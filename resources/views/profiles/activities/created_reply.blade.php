@component('profiles.activities.activity')
    @slot('style')
        list-group-item-success
    @endslot
    @slot('heading')
        <h5 class="mb-1">{{$profileUser->name}} replied to <a
                    href="{{$activity->subject->thread->path()}}">"{{$activity->subject->thread->title}}"</a></h5>
        <small>{{$activity->created_at->diffForHumans()}}</small>
    @endslot
    @slot('body')
        Message body:
        {{$activity->subject->body}}
    @endslot
@endcomponent
