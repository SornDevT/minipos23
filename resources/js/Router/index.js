import { createRouter,  createWebHistory } from "vue-router";

import Store from "../Pages/Store.vue";
// import Category from "../Pages/Category.vue";
// import Pos from "../Pages/Pos.vue";
// import Transection from "../Pages/Transection.vue";
// import Report from "../Pages/Report.vue";
// import Page404 from "../Pages/Page404.vue";
import Login from "../Pages/Login.vue";
// import Register from "../Pages/Register.vue";

import { useStore } from "../Store/Auth";

// ສ້າງ middleware 
const AuthMiddleware = (to, from, next) => {
    
    // ດຶງ token ຈາກ localStorage
    const user = localStorage.getItem('web_user'); 
    const token = localStorage.getItem('web_token');
    const store = useStore();

    if(token){
        store.setToken(token);
        store.setUser(user);
        next();
    } else {
        next({
            path: '/login',
            replace: true,
        });
    }
};



const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: () => import('../Pages/Register.vue'),
    },
    {
        path:'/',
        redirect:'/store',
        
    },
    {
        name: 'store',
        path: '/store',
        component: Store,
        meta:{
            middleware: [AuthMiddleware]
        }
    },
    {
        name: 'category',
        path: '/category',
        component: () => import('../Pages/Category.vue'),
        meta:{
            middleware: [AuthMiddleware]
        }
    },
    {
        name: 'pos',
        path: '/pos',
        component: () => import('../Pages/Pos.vue'),
        meta:{
            middleware: [AuthMiddleware]
        }
    },
    {
        name: 'transection',
        path: '/transection',
        component: () => import('../Pages/Transection.vue'),
        meta:{
            middleware: [AuthMiddleware]
        }
    },
    {
        name: 'report',
        path: '/report',
        component: () => import('../Pages/Report.vue'),
        meta:{
            middleware: [AuthMiddleware]
        }
    },
    {
        name: 'Page_404',
        path: '/:pathMatch(.*)*',
        component: () => import('../Pages/Page404.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior () {
        return { to:0 }
    }
});



router.beforeEach((to, from, next) => {
    // ສ້າງ middleware ສໍາລັບການເຂົ້າໄປສູ່ໜ້າທີ່
    const token = localStorage.getItem('web_token');

    if (to.meta.middleware) {
       to.meta.middleware.forEach(middleware => {
            middleware(to, from, next);
        });
    } else {
        if(to.path === '/login' || to.path === '/'){
            if(token){
                next({
                    path: '/store',
                    replace: true,
                });
            } else {
                next();
            }
        } else {
            next();
        }
    }
});


export default router;