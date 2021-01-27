<template>
  <div>
    <div v-if="this.error !== ''" class="mt-10">{{ this.error }}</div>
    <div v-if="this.loading" class="mt-10">Loading ...</div>
    <div v-if="this.posts">
      <post v-for="post in this.posts.data" :key="post.id" :post="post" />
    </div>
  </div>
</template>

<script>
import Post from "../post/SinglePost.vue";
export default {
  components: { Post },
  name: "Feed",
  mounted() {
    this.getPosts();
  },
  data() {
    return {
      loading: false,
      posts: null,
      error: "",
    };
  },
  methods: {
    getPosts() {
      this.loading = true;
      axios
        .get("/api/feed")
        .then((response) => {
          this.posts = response.data;
          this.loading = false;
          this.error = "";
        })
        .catch((error) => {
          this.error = error.response.data.message;
          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
</style>

