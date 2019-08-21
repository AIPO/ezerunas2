<template>
<div>
    <div v-for="(reply,index) in items">
        <reply :data="reply" @deleted="remove(index)"></reply>
    </div>
    <new-reply @created="add"></new-reply>
</div>
</template>

<script>
import Reply from './ReplyComponent.vue';
import NewReply from './NewReplyComponent.vue'
export default {
    components: {
        Reply,
        NewReply
    },
    props: ['data'],
    data() {
        return {
            items: this.data,
        }
    },
    methods: {
        add(reply) {
            this.items.push(reply);
        },
        remove(index) {
            this.items.splice(index, 1);
            this.$emit('removed');
            flash('Reply deleted!');
        }
    }
}
</script>

<style lang="css" scoped>
</style>
