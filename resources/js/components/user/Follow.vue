<template>
    <div>
        <button v-if="!following" @click="follow()" :disabled="saving" class="btn btn-sm text-sm btn-primary">
            Follow
        </button>
        <!-- @hover="" -->
        <button v-else @click="unFollow()" :disabled="saving" class="btn btn-sm text-sm btn-secondary"
            :class="{'bg_color bg-red-700': backgroundColor }" @mouseover="backgroundColor = true"
            @mouseleave="backgroundColor = false">
            Unfollow
        </button>
    </div>
</template>

<script>
    export default {
        components: {},
        name: "Follow",
        props: ["userId", "isFollowing"],
        mounted() {
            if (this.isFollowing !== undefined) {
                this.following = this.isFollowing;
            }
        },
        data() {
            return {
                saving: false,
                following: false,
                backgroundColor: false
            };
        },
        methods: {
            follow() {
                this.saving = true;
                axios
                    .post("/api/user/" + this.userId + "/follow")
                    .then((reponse) => {
                        this.saving = false;
                        this.following = true;
                    })
                    .catch((error) => {
                        this.saving = false;
                    });
            },
            unFollow() {
                this.saving = true;

                axios
                    .post("/api/user/" + this.userId + "/unfollow")
                    .then((reponse) => {
                        this.saving = false;
                    })
                    .catch((error) => {
                        this.following = false;
                        this.saving = false;
                    });
            },
        },
    };

</script>

<style scoped>
    .bg_color {
        background-color: #B91C1C;
    }

</style>
