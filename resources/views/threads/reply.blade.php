<reply :data="{{$reply}}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="/profiles/{{$reply->owner->name}}" class="flex">{{$reply->owner->name}}</a> said
                    {{$reply->created_at->diffForHumans()}}
                </h5>
                @if (Auth::check())
                <div>
                    <favorite :reply="{{$reply}}"></favorite>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-primary" @click="update">Update</button>
                    <button class="btn btn-link" @click="editing=false">Cancel</button>
                </div>
            </div>
            <div v-else v-text="body">
            </div>

        </div>
        @can('update', $reply)
        <div class="card-footer">
            <div class="form-group level">
                <button class="btn btn-sm btn-outline-primary mr-1" @click="editing=true">Edit</button>
                <button class="btn btn-sm btn-outline-danger mr-1" @click="destroy">Delete</button>
            </div>
        </div>
        @endcan
    </div>
</reply>
