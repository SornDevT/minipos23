import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import Router from './Router';
import SideBarMenu from './Components/SidebarMenu.vue'

const app = createApp(App);
app.component("SideBarMenu",SideBarMenu);
app.use(Router);
app.mount('#app');