<template>
    <div class="card mt-4" v-if="post">
        <div class="card-header">
            <a :href="`/user/${this.post.user.id}`">
                <h5>{{ this.post.user.name }}</h5>
            </a>
        </div>
        <div class="card-body">
            <div v-if="
          this.post.attachment !== null && this.post.attachment.type === 'image'
        ">
                <img :src="`/storage/${this.post.attachment.path}`" :alt="this.post.attachment.name"
                    class="img-responsive" style="width: 100%" />
            </div>
            {{ this.post.content }}
            <small class="text-muted">
                {{ new Date(this.post.created_at).toDateString() }}
            </small>
        </div>
        <div class="card-body border-top bg-light">
            <ul class="d-inline list-inline list-unstyled mb-0">
                <li>
                    <div>
                        {{ post.total_likes }}
                        {{ post.total_likes <= 1 ? 'person has liked this post' : 'people have liked this post' }}
                    </div>
                    <a href="javascript:;" @click="toggleLike(post)" v-if="post.like === null">Like</a>
                    <a href="javascript:;" @click="toggleLike(post)" v-else>Dislike</a>
                </li>
            </ul>
        </div>

        <div style="max-height: 300px; overflow-y: auto" class="card-body"
            v-if="post.comments && post.comments.length > 0">
            <post-comment class="border-top" v-for="comment in post.comments" :key="comment.id" :comment="comment" />
        </div>

        <div class="card-body border-top">
            <input type="text" class="form-control" v-model="input" @change="comment()"
                :placeholder="`Comment on ${post.user.name}'s post`" />
        </div>
    </div>
</template>

<script>
    import PostComment from "./PostComment.vue";
    export default {
        components: {
            PostComment,
        },
        name: "SinglePost",
        props: {
            post: Object,
        },
        mounted() {},
        data() {
            return {
                input: "",
                loading: false,
                busy: false,
            };
        },
        methods: {
            comment() {
                this.busy = true;
                axios
                    .post(`/api/post/${this.post.id}/comments`, {
                        content: this.input,
                    })
                    .then((response) => {
                        this.$emit("comment-posted", response.data);
                        this.input = "";
                        this.busy = false;
                    })
                    .catch((error) => {
                        this.busy = false;
                    });
            },
            toggleLike(post) {
                axios.
                post(`/api/post/${post.id}/like`)
                    .then(response => {
                        post.like = response.data.like;
                        post.total_likes = response.data.total_likes;
                    }).catch((e) => {
                        console.error(e.response.errors);
                    });
            }
        },
    };

</script>

<style>
</style>
