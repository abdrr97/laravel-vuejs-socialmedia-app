require('./bootstrap');




import Vue from "vue";
import App from './components/App.vue';
import ListAllPosts from './components/post/ListAllPosts.vue';
Vue.component('create-new-post', require('./components/post/CreateNewPost.vue'));
Vue.component('list-all-posts', require('./components/post/ListAllPosts.vue'));

const app = new Vue({
    el: '#app',
    components: { App , ListAllPosts }
});
