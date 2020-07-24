import './bootstrap';
import Vue from 'vue';
import router from './router';

import App from './App.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';

Vue.use(VueAxios, axios);

const app = new Vue(Vue.util.extend({
    router
}, App)).$mount('#app');
// new Vue({
//     router,
//     el: '#app',
//     render: h => h(App)
// });
