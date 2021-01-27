<template>
  <div class="">
    <div v-if="this.error !== ''" class="mt-10">{{ this.error }}</div>
    <div v-if="this.loading" class="mt-10">Loading ...</div>
    <div v-if="this.posts">
      <div class="card mt-4" v-for="post in posts.data" :key="post.id">
        <div class="card-header">
          <h5>{{ post.user.name }}</h5>
        </div>
        <div class="card-body">
          <div
            class=""
            v-if="post.attachment !== null && post.attachment.type === 'image'"
          >
            <img
              :src="`/storage/${post.attachment.path}`"
              :alt="post.attachment.name"
              class="image-responsive"
              style="width: 200px"
            />
          </div>
          {{ post.content }}
        </div>
        <div class="card-footer text-right">
          <small class="text-muted">
            {{ new Date(post.created_at).toDateString() }}
          </small>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "ListAllPosts",
  mounted() {
    this.$root.$on("post-created", (post) => {
      if (this.posts === null) {
        this.getPosts();
      } else {
        this.posts.data.push(post);
      }
    });
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
        .get("/api/post/list")
        .then((response) => {
          this.posts = response.data;
          this.loading = false;
        })
        .catch((error) => {
          this.error = error.response.data.message;
          this.loading = false;
        });
    },
  },
};
</script>

<style>
</style>
