<template>
  <div>
    <create-new-post />
    <feed />
  </div>
</template>

<script>
import Feed from "./Home/Feed.vue";
import CreateNewPost from "./post/CreateNewPost.vue";

const default_layout = "default";
export default {
  components: { CreateNewPost, Feed },
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
