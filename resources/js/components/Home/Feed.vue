<template>
  <div>
    <div v-if="this.error !== ''" class="mt-10">{{ this.error }}</div>
    <div v-if="this.posts">
      <post v-for="post in this.posts.data" :key="post.id" :post="post" />

      <mugen-scroll :handler="getPosts" :should-handle="!loading">
        loading...
      </mugen-scroll>
    </div>
  </div>
</template>

<script>
import MugenScroll from "vue-mugen-scroll";
import Post from "../post/SinglePost.vue";
export default {
  components: { Post, MugenScroll },
  name: "Feed",
  mounted() {
    this.getPosts();
  },
  data() {
    return {
      posts: [],
      error: "",
      loading: false,
      page: 1,
    };
  },
  methods: {
    getPosts() {
      this.loading = true;
      axios
        .get(`/api/feed?page=${this.page}`)
        .then((response) => {
          if (response.data) {
            this.posts = response.data;
            this.loading = false;
          }
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
      this.page++;
      this.loading = false;
    },
  },
};
</script>

<style scoped>
</style>

