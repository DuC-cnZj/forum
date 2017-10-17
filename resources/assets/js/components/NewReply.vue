<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body"
                          rows="5"
                          id="body"
                          v-model="body"
                          class="form-control"
                          placeholder="have something to say?"
                          required
                ></textarea>
            </div>

            <button type="submit"
                    class="btn btn-default"
                    @click="addReply">Post
            </button>
        </div>

        <p class="text-center" v-else>
            请 <a href="/login">登陆</a> 之后再发表评论
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';

                        flash('your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>