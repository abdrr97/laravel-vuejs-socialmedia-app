require('./bootstrap');




import Vue from "vue";
import App from './components/App.vue';
import ListAllPosts from './components/post/ListAllPosts.vue';
import Follow from './components/user/Follow.vue';
Vue.component('create-new-post', require('./components/post/CreateNewPost'));
Vue.component('list-all-posts', require('./components/post/ListAllPosts'));
Vue.component('follow', require('./components/user/Follow'));

const app = new Vue({
    el: '#app',
    components: { App , ListAllPosts ,Follow}
});
