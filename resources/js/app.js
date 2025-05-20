import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import Router from './Router';
import SideBarMenu from './Components/SidebarMenu.vue'
import { createPinia } from 'pinia'
const pinia = createPinia()


const app = createApp(App);
app.use(pinia);
app.component("SideBarMenu",SideBarMenu);
app.use(Router);
app.mount('#app');