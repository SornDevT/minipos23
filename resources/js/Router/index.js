import { createRouter,  createWebHistory } from "vue-router";

import Store from "../Pages/Store.vue";
import Category from "../Pages/Category.vue";
import Pos from "../Pages/Pos.vue";
import Transection from "../Pages/Transection.vue";
import Report from "../Pages/Report.vue";
import Page404 from "../Pages/Page404.vue";


const routes = [
    {
        path:'/',
        redirect:'/store'
    },
    {
        name: 'store',
        path: '/store',
        component: Store
    },
    {
        name: 'category',
        path: '/category',
        component: Category
    },
    {
        name: 'pos',
        path: '/pos',
        component: Pos
    },
    {
        name: 'transection',
        path: '/transection',
        component: Transection
    },
    {
        name: 'report',
        path: '/report',
        component: Report
    },
    {
        name: 'Page_404',
        path: '/:pathMatch(.*)*',
        component: Page404
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior () {
        return { to:0 }
    }
});

export default router;