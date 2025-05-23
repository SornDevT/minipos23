import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import Router from './Router';
import SideBarMenu from './Components/SidebarMenu.vue'
import { createPinia } from 'pinia'
const pinia = createPinia()

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


const app = createApp(App);
app.use(VueSweetalert2);
app.use(pinia);
app.component("SideBarMenu",SideBarMenu);
app.use(Router);
app.mount('#app');