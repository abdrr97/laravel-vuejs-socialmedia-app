require('./bootstrap');




import Vue from "vue";
import App from './components/App';
import ListAllPosts from './components/post/ListAllPosts';
import Follow from './components/user/Follow';


Vue.component('create-new-post', require('./components/post/CreateNewPost'));
Vue.component('list-all-posts', require('./components/post/ListAllPosts'));
Vue.component('follow', require('./components/user/Follow'));
Vue.component('feed', require('./components/Home/Feed'));
Vue.component('post', require('./components/SinglePost/Post'));
Vue.component('post-comment', require('./components/SinglePost/PostComment'));

import Skeleton from "vue-loading-skeleton";
Vue.use(Skeleton);

const app = new Vue({
    el: '#app',
    components: { App, ListAllPosts, Follow }
});
