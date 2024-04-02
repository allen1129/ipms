import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import { createRouter, createWebHistory } from 'vue-router';
import IPList from './components/pages/IPList';
import IPCreate from './components/pages/IPCreate';
import IPEdit from './components/pages/IPEdit';
import IPShow from './components/pages/IPShow';
  
axios.defaults.baseURL = 'http://127.0.0.1:8000';
  
const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: IPList },
    { path: '/create', component: IPCreate },
    { path: '/edit/:id', component: IPEdit },
    { path: '/show/:id', component: IPShow },
  ],
});
  
createApp(App).use(router).mount('#app');