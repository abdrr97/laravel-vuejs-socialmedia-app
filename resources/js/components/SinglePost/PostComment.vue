<template>
  <div class="card-body">
    <h6 class="row">
      <b class="col-auto mr-auto">{{ comment.user.name }}</b>
      <small class="text-muted col-auto">
        {{ new Date(comment.created_at).toDateString() }}
      </small>
    </h6>
    <p class="mb-0">{{ comment.content }}</p>
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
