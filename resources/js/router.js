import Vue from 'vue';
import VueRouter from 'vue-router';

import IndexComponent from './components/posts/Index.vue';
import CreateComponent from './components/posts/Create.vue';
import EditComponent from './components/posts/Edit.vue';
import DashboardComponent from './components/Dashboard.vue';
import TransaksiComponent from './components/Transaksi.vue';

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [{
            name: 'posts',
            path: '/post',
            component: IndexComponent
        },
        {
            name: 'create',
            path: '/post/create',
            component: CreateComponent
        },
        {
            name: 'edit',
            path: '/post/edit/:id',
            component: EditComponent
        },
        {
            name: 'dashboard',
            path: '/dashboard',
            component: DashboardComponent
        },
        {
            name: 'transaksi',
            path: '/transaksi',
            component: TransaksiComponent
        }
    ]
});

export default router;
