<template>
  <div class="card-body">
    <h6 class="row align-items-center">
      <b>{{ comment.user.name }}</b>
      <small class="text-muted float-right">
        {{ new Date(comment.created_at).toDateString() }}
      </small>
    </h6>
    <p>{{ comment.content }}</p>
  </div>
</template>

<script>
export default {
  name: "PostComment",
  props: {
    comment: Object,
  },
  mounted() {},
  data() {
    return {};
  },
  methods: {},
};
</script>

<style>
</style>

