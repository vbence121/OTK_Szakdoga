import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import HomeView from '../views/HomeView.vue';
import store from "@/store";

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/editProfile',
    name: 'editProfile',
    component: () => import('../views/EditProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/dogs',
    name: 'MyDogsView',
    component: () => import('../views/MyDogsView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../views/RegisterView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/login',
    name: 'login',
    props: true,
    component: () => import('../views/LoginView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/passwordChange',
    name: 'passwordChange',
    props: true,
    component: () => import('../views/ChangePasswordView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/deleteProfile',
    name: 'deleteProfile',
    props: true,
    component: () => import('../views/DeleteProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/:catchAll(.*)',
    name: 'notFound',
    component: () => import('../views/NotFoundView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: false, isJudgeLoggedin: false }
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  //ha bejelentkezett útvonal van de nincs bejelentkezve senki
  if ((to.meta.isUserLoggedIn || to.meta.isAdminLoggedIn) && (!store.getters.isUserLoggedIn && !store.getters.isAdminLoggedIn && !store.getters.isJudgeLoggedIn)) {
    next('/login');
  } else if (!to.meta.isUserLoggedIn && store.getters.isUserLoggedIn) {
    next('/');
  }
  else if (!to.meta.isAdminLoggedIn && store.getters.isAdminLoggedIn) {
    next('/');
  }
  else if (!to.meta.isJudgeLoggedIn && store.getters.isJudgeLoggedIn) {
    next('/');
  }
  else {
    next();
  }
})


export default router
