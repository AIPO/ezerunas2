<template>
<div>
    <!-- @if(auth()->check()) -->
    <!-- <form method="POST" action="{{$thread->path().'/replies'}}"> -->
    <!-- @csrf -->
    <div class="form-group">
        <label for="body">Reply</label>
        <textarea rows="10" class="form-control" placeholder="Have something to say?" v-model="body" required></textarea>
    </div>
    <button type="submit" class="btn" @click="addReply">
        Post</button>
    <!-- </form> -->
    <!-- @else
        <p class="text-center">Please <a href="{{route('login')}}">sign in</a> to reply to a post</p>
        @endif -->
</div>
</template>

<script>
export default {
    data() {
        return {
            body: "",
            endpoint: '/threads/voluptatem/4/replies'
        }
    },
    methods: {
        addReply() {
            axios.post(this.endpoint, {
                    body: this.body
                })
                .then(response => {
                    this.body = ""; //reset body to emply string
                    flash("Your reply has been posted!");
                    this.$emit('created', response.data);
                })
        }
    }
}
</script>
