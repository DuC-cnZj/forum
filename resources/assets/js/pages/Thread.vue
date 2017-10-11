<script>
    import Replies from '../components/Replies.vue'

    export default {
        props: ['initialRepliesCount'],
        // child component
        components: { Replies },

        data() {
            return {
                repliesCount: this.initialRepliesCount
            }
        }
    }
</script>