<template>
    <div>
        <div v-if="error !== ''" class="mt-10">{{ error }}</div>
        <div v-if="loading" class="mt-10">Loading ...</div>
        <div v-if="posts">
            <post @comment-posted="post.comments.push($event)" v-for="post in posts" :key="post.id" :post="post"
                :current-user="currentUser" />
        </div>
    </div>
</template>

<script>
    import Post from "../SinglePost/Post.vue";
    export default {
        name: "Feed",
        components: {
            Post
        },
        mounted() {
            this.getLoggedInUser();
            this.getPosts();
            let vm = this;
            this.$root.$on('post-deleted', function (deleted_post) {
                let i = vm.posts.indexOf(deleted_post);
                vm.posts.splice(i, 1);
            });

            this.$root.$on('post-created', function (post) {
                vm.posts.unshift(post);
            });
        },

        data() {
            return {
                posts: null,
                error: "",
                loading: false,
                currentUser: null,
            };
        },
        methods: {
            getLoggedInUser() {
                axios
                    .get(`/api/user/logged_in_user`)
                    .then((response) => {
                        if (response.status == 200 && response.data) {
                            this.currentUser = response.data.user
                        }
                    })
                    .catch((e) => {
                        this.error = e.response.data.message;
                    });
            },
            async getPosts() {
                this.loading = true;
                await axios
                    .get(`/api/feed`)
                    .then((response) => {
                        if (response.data) {
                            this.posts = response.data.data;
                            this.loading = false;
                        }
                    })
                    .catch((e) => {
                        this.error = e.response.data.message;
                        this.loading = false;
                    });
            },
        },
    };

</script>

<style scoped>
</style>
