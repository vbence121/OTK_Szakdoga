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
    props: true,
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
    path: '/myDogs',
    name: 'MyListOfDogs',
    props: true,
    component: () => import('../components/MyListOfDogs.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/dogProfile/:id',
    name: 'dogProfile',
    props: true,
    component: () => import('../views/DogProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/dogEntry',
    name: 'dogEntry',
    props: true,
    component: () => import('../views/DogEntryView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/myEntryStatuses',
    name: 'MyEntryStatusesView',
    props: true,
    component: () => import('../views/MyEntryStatusesView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/events/:event_id/registeredDogProfile/:dog_id/uploadPaymentCertificate',
    name: 'UploadPaymentCertificateView',
    props: true,
    component: () => import('../views/UploadPaymentCertificateView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedin: false }
  },
  {
    path: '/events/:event_id/registeredDogProfile/:dog_id/:dog_class_id',
    name: 'RegisteredDogProfileView',
    props: true,
    component: () => import('../views/RegisteredDogProfileView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/events/:event_id/registeredDogProfileWithPayment/:dog_id/:dog_class_id',
    name: 'RegisteredDogProfileWithPayment',
    props: true,
    component: () => import('../views/RegisteredDogProfileWithPayment.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/createEvent',
    name: 'CreateEventView',
    props: true,
    component: () => import('../views/CreateEventView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/activeEvents',
    name: 'EventListView',
    props: true,
    component: () => import('../views/EventListView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/entries',
    name: 'entries',
    props: true,
    component: () => import('../views/AdminEntriesView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/paymentsForEntries',
    name: 'AdminEntriesForPaymentsView',
    props: true,
    component: () => import('../views/AdminEntriesForPaymentsView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/paymentsForEvent/:id',
    name: 'PaymentsForCurrentEventView',
    props: true,
    component: () => import('../views/PaymentsForCurrentEventView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/entriesForEvent/:id',
    name: 'EntriesForEventView',
    props: true,
    component: () => import('../views/EntriesForCurrentEventView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/eventProfile/:id',
    name: 'EventProfileView',
    props: true,
    component: () => import('../views/EventProfileView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/eventProfile/:event_id/finalEntries',
    name: 'FinalEventEntriesView',
    props: true,
    component: () => import('../views/FinalEventEntriesView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
  },
  {
    path: '/userProfile/:id',
    name: 'UserProfileView',
    props: true,
    component: () => import('../views/UserProfileView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedin: false }
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
