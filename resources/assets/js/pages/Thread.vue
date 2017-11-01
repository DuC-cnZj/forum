<script>
    import Replies from '../components/Replies.vue'
    import SubscribeButton from '../components/SubscribeButton.vue'

    export default {
        props: ['thread'],
        // child component
        components: { Replies, SubscribeButton },

        data () {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {}
            }
        },

        created () {
            this.resetForm();
        },

        methods: {
            toggleLock () {
                let uri = `/locked-threads/${this.thread.slug}`;
                axios[this.locked ? 'delete' : 'post'](uri);

                this.locked = !this.locked;
            },

            update () {
                let uri = `/thread/${this.thread.channel.slug}/${this.thread.slug}`;
                axios.patch(uri, this.form).then(() => {
                    this.editing = false;

                    flash('your thread updated!')
                })
            },

            resetForm () {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body,
                };

                this.editing = false;
            }
        }
    }
</script>