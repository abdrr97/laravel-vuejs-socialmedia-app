<template>
  <div>
    <create-new-post />
    <list-all-posts />
  </div>
</template>

<script>
import CreateNewPost from "./post/CreateNewPost.vue";
import ListAllPosts from "./post/ListAllPosts.vue";
const default_layout = "default";

export default {
  components: { ListAllPosts, CreateNewPost },
  name: "app",
  mounted() {},
  data() {
    return {};
  },
  methods: {},
};
</script>

<style>
</style>
