<script>
import Replies from '../components/RepliesComponent.vue';
export default {
    name: 'thread-view',
    props: ['initialRepliesCount'],
    components: {
        'replies': Replies,
    },
    data(){
      return{
        repliesCount: this.initialRepliesCount
      }
    }
}
</script>
