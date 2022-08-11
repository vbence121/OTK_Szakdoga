import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import HomeView from '../views/HomeView.vue';
import store from "@/store";

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { auth: true }
  },
  {
    path: '/editProfile',
    name: 'editProfile',
    component: () => import('../views/EditProfileView.vue'),
    meta: { auth: true }
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../views/RegisterView.vue'),
    meta: { auth: false }
  },
  {
    path: '/login',
    name: 'login',
    props: true,
    component: () => import('../views/LoginView.vue'),
    meta: { auth: false }
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  if(to.meta.auth && store.getters.getUserEmail === ''){
    next('/login');
  }else if (!to.meta.auth && store.getters.getUserEmail !== ''){
    next('/');
  }
  else{
    next();
  }
})


export default router
