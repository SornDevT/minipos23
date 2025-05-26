import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import Router from './Router';
import SideBarMenu from './Components/SidebarMenu.vue'
import { createPinia } from 'pinia'
const pinia = createPinia()

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import Cleave from 'vue-cleave-component';
import Pagination from './Components/Pagination.vue'


const app = createApp(App);
app.component('Pagination', Pagination);
app.use(Cleave);
app.use(VueSweetalert2);
app.use(pinia);
app.component("SideBarMenu",SideBarMenu);
app.use(Router);
app.mount('#app');