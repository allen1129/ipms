import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import { createRouter, createWebHistory } from 'vue-router';
import IPList from './components/pages/IPList';
import IPCreate from './components/pages/IPCreate';.
import IPEdit from './components/pages/IPEdit';.
import IPShow from './components/pages/IPShow';.
  
axios.defaults.baseURL = process.env.VUE_APP_API_URL
axios.interceptors.request.use(function (config) {
  return config;
});
  
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