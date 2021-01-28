<template>
  <div>
    <div v-if="error !== ''" class="mt-10">{{ error }}</div>
    <div v-if="loading" class="mt-10">Loading ...</div>
    <div v-if="posts">
      <post
        v-on:comment-posted="post.comments.push($event)"
        v-for="post in posts.data"
        :key="post.id"
        :post="post"
      />
    </div>
  </div>
</template>

<script>
import Post from "../SinglePost/Post.vue";
export default {
  components: { Post },
  name: "Feed",
  mounted() {
    this.getPosts();
  },
  data() {
    return {
      posts: [],
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
        .catch((error) => {
          this.error = error.response.data.message;
        });
      this.loading = false;
    },
  },
};
</script>

<style scoped>
</style>

