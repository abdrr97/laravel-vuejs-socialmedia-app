<template>
    <div>
        <div v-if="error !== ''" class="mt-10">{{ error }}</div>
        <div v-if="loading" class="mt-10">Loading ...</div>
        <div v-if="posts">
            <post @comment-posted="post.comments.push($event)" v-for="post in posts.data" :key="post.id" :post="post" />
        </div>
    </div>
</template>

<script>
    import Post from "../SinglePost/Post.vue";
    export default {
        components: {
            Post
        },
        name: "Feed",
        mounted() {
            this.getPosts();

            this.$root.$on("post-created", function (post) {
                this.getPosts();
                if (this.posts === null) {
                    this.getPosts();
                } else {
                    this.posts.data.unshift(post);
                }
            });
        },
        data() {
            return {
                posts: null,
                error: "",
                loading: false,
            };
        },
        methods: {
            getPosts() {
                this.loading = true;
                axios
                    .get(`/api/feed`)
                    .then((response) => {
                        if (response.data) {
                            this.posts = response.data;
                            this.loading = false;
                        }
                    })
                    .catch((e) => {
                        this.error = e.response.data.message;
                    });
                this.loading = false;
            },
        },
    };

</script>

<style scoped>
</style>
