<template>
    <div class="card mt-4" v-if="post">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <a :href="`/user/${post.user.id}`">
                    <h5>{{ post.user.name }}</h5>
                </a>
                <button @click="deletePost()" v-if="currentUser.id == post.user.id " class="btn btn-danger btn-sm">
                    {{ deleting ? 'deleting ...' : 'delete' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-if="
          post.attachment !== null && post.attachment.type === 'image'
        ">
                <img :src="`/storage/${post.attachment.path}`" :alt="post.attachment.name" class="img-responsive"
                    style="width: 100%" />
            </div>
            {{ post.content }}
            <small class="text-muted">
                {{ new Date(post.created_at).toDateString() }}
            </small>
        </div>
        <div class="card-body border-top bg-light">
            <ul class="d-inline list-inline list-unstyled mb-0">
                <li>
                    <div>
                        {{ post.total_likes }}
                        {{ post.total_likes <= 1 ? 'person has liked this post' : 'people have liked this post' }}
                    </div>
                    <a href="javascript:;" @click="toggleLike(post)" v-if="post.like === null">
                        <i class="fa fa-thumbs-up fa-2x"></i>
                    </a>
                    <a href="javascript:;" @click="toggleLike(post)" v-else>
                        <i class="text-muted fa fa-thumbs-down fa-2x"></i>
                    </a>
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
        name: "SinglePost",
        components: {
            PostComment,
        },
        props: {
            post: Object,
            currentUser: Object
        },
        mounted() {
            console.log(this.currentUser.id);
        },
        data() {
            return {
                input: "",
                deleting: false
            };
        },
        methods: {
            deletePost() {
                this.deleting = true
                setTimeout(() => {
                    axios
                        .post(`/api/post/${this.post.id}/delete`)
                        .then((response) => {
                            this.$emit("post-deleted");
                            this.deleting = false
                        })
                        .catch((error) => {
                            console.error(e.response.errors);
                            this.deleting = false
                        });
                }, 1000);
            },
            comment() {
                axios
                    .post(`/api/post/${this.post.id}/comments`, {
                        content: this.input,
                    })
                    .then((response) => {
                        this.$emit("comment-posted", response.data);
                        this.input = "";
                    })
                    .catch((error) => {
                        console.error(e.response.errors);
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
