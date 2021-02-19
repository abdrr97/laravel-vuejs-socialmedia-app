<template>
    <div>
        <create-new-post />
        <feed />
    </div>
</template>

<script>
    import Feed from "./Home/Feed";
    import CreateNewPost from "./post/CreateNewPost";

    const default_layout = "default";
    export default {
        name: "app",
        components: {
            CreateNewPost,
            Feed
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
