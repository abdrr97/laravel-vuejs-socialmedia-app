<template>
  <div>
    <div class="card">
      <div class="card-header">
        Create Post
        <div class="body">
          <div class="form-group">
            <label for="content">Post Content</label>
            <textarea
              name="content"
              id="content"
              class="form-control"
              cols="30"
              rows="10"
              placeholder="tell us"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CreateNewPost",
  mounted() {},
  data() {
    return {};
  },
  methods: {},
};
</script>

<style>
</style>
