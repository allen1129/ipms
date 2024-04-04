import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import { createRouter, createWebHistory } from 'vue-router';
import IPList from './components/pages/IPList';
import IPCreate from './components/pages/IPCreate';
import IPEdit from './components/pages/IPEdit';
import IPShow from './components/pages/IPShow';
import LoginForm from './components/pages/LoginForm';

axios.defaults.baseURL = 'http://127.0.0.1:8000';

axios.interceptors.request.use(config => {
  const authToken = localStorage.getItem('authToken');
  if (authToken && config.url !== '/login') {
    config.headers.Authorization = `Bearer ${authToken}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: IPList, meta: { requiresAuth: true } },
    { path: '/create', component: IPCreate, meta: { requiresAuth: true } },
    { path: '/edit/:id', component: IPEdit, meta: { requiresAuth: true } },
    { path: '/show/:id', component: IPShow, meta: { requiresAuth: true } },
    { path: '/login', component: LoginForm },
  ],
});

// Global navigation guard
router.beforeEach((to, from, next) => {
  const authToken = localStorage.getItem('authToken');
  // Check if the route requires authentication
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Redirect to login if authToken does not exist
    if (!authToken) {
      next('/login');
    } else {
      next(); // Proceed to the requested route
    }
  } else {
    next(); // Proceed to the requested route
  }
});

createApp(App).use(router).mount('#app');
