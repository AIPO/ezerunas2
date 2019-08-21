@component('profiles.activities.activity')
    @slot('style')
        list-group-item-success
    @endslot
    @slot('heading')
        <h5 class="mb-1">{{$profileUser->name}} favorited a
            <a href="{{$activity->subject->favorited->path()}}">
                {{-- "{{$activity->subject->favorited}}" --}}reply
            </a></h5>
        <small>{{$activity->created_at->diffForHumans()}}</small>
    @endslot
    @slot('body')
        Message body:
        {{$activity->subject->favorited->body}}
    @endslot
@endcomponent
