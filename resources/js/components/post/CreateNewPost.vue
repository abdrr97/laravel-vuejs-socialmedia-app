<template>
  <div>
    <div class="card">
      <div class="card-header">Create Post</div>
      <div class="card-body">
        <div class="form-group">
          <label for="content">Post Content</label>
          <textarea
            name="content"
            id="content"
            class="form-control"
            cols="30"
            rows="10"
            v-model="content"
            placeholder="Tell us about your day !!"
          ></textarea>
        </div>
      </div>
      <div class="card-footer m-0">
        <div class="row">
          <div class="col-10">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01"
                  >Upload
                </span>
              </div>
              <div class="custom-file">
                <input
                  type="file"
                  class="custom-file-input"
                  id="inputGroupFile01"
                  ref="fileInput"
                  @change="fileAdded"
                  aria-describedby="inputGroupFileAddon01"
                  accept="image/*"
                />
                <label class="custom-file-label" for="inputGroupFile01">
                  Choose file
                </label>
              </div>
            </div>
          </div>
          <div class="col">
            <button @click="createPost" class="btn btn-primary">
              <span v-if="this.creatingPost">Loading ...</span>
              <span v-else>Post</span>
            </button>
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
    return {
      creatingPost: false,
      error: null,
      content: "",
      file: null,
    };
  },
  methods: {
    createPost() {
      this.creatingPost = true;

      let formData = new FormData();
      formData.append("content", this.content);
      if (this.file !== null) {
        formData.append("image", this.file);
      }

      axios
        .post("/api/post/create", formData)
        .then((res) => {
          let post = res.data.data;
          this.$root.$emit("post-created", post);
          this.content = "";

          this.creatingPost = false;
        })
        .catch((error) => {
          this.creatingPost = false;
        });
    },
    fileAdded() {
      this.file = this.$refs.fileInput.files[0];
    },
  },
};
</script>

<style>
</style>
