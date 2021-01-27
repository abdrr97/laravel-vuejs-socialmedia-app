<template>
  <div class="card mt-4" v-if="post">
    <div class="card-header">
      <a :href="`/user/${this.post.user.id}`">
        <h5>{{ this.post.user.name }}</h5>
      </a>
    </div>
    <div class="card-body">
      <div
        v-if="
          this.post.attachment !== null && this.post.attachment.type === 'image'
        "
      >
        <img
          :src="`/storage/${this.post.attachment.path}`"
          :alt="this.post.attachment.name"
          class="image-responsive"
          style="width: 200px"
        />
      </div>
      {{ this.post.content }}
    </div>
    <div class="card-footer text-right">
      <small class="text-muted">
        {{ new Date(this.post.created_at).toDateString() }}
      </small>
    </div>
  </div>
</template>

<script>
export default {
  name: "SinglePost",
  props: ["post"],
  mounted() {},
};
</script>

<style>
</style>
