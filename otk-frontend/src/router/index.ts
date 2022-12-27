import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import HomeView from '../views/HomeView.vue';
import store from "@/store";

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { both: true }
  },
  {
    path: '/editProfile',
    name: 'editProfile',
    component: () => import('../views/EditProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/dogs',
    name: 'MyDogsView',
    props: true,
    component: () => import('../views/MyDogsView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../views/RegisterView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/login',
    name: 'login',
    props: true,
    component: () => import('../views/LoginView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/passwordChange',
    name: 'passwordChange',
    props: true,
    component: () => import('../views/ChangePasswordView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/deleteProfile',
    name: 'deleteProfile',
    props: true,
    component: () => import('../views/DeleteProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/myDogs',
    name: 'MyListOfDogs',
    props: true,
    component: () => import('../components/MyListOfDogs.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/dogProfile/:id',
    name: 'dogProfile',
    props: true,
    component: () => import('../views/DogProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/dogEntry',
    name: 'dogEntry',
    props: true,
    component: () => import('../views/DogEntryView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/myEntryStatuses',
    name: 'MyEntryStatusesView',
    props: true,
    component: () => import('../views/MyEntryStatusesView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/events/:event_category_id/registeredDogProfile/:dog_id/uploadPaymentCertificate',
    name: 'UploadPaymentCertificateView',
    props: true,
    component: () => import('../views/UploadPaymentCertificateView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  },
  {
    path: '/events/:event_category_id/registeredDogProfile/:dog_id/:dog_class_id',
    name: 'RegisteredDogProfileView',
    props: true,
    component: () => import('../views/RegisteredDogProfileView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/events/:event_category_id/registeredDogProfileWithPayment/:dog_id/:dog_class_id',
    name: 'RegisteredDogProfileWithPayment',
    props: true,
    component: () => import('../views/RegisteredDogProfileWithPayment.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/createEvent',
    name: 'CreateEventView',
    props: true,
    component: () => import('../views/CreateEventView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/activeEvents',
    name: 'EventListView',
    props: true,
    component: () => import('../views/EventListView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/entries',
    name: 'entries',
    props: true,
    component: () => import('../views/AdminEntriesView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/paymentsForEntries',
    name: 'AdminEntriesForPaymentsView',
    props: true,
    component: () => import('../views/AdminEntriesForPaymentsView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/paymentsForEvent/:id',
    name: 'PaymentsForCurrentEventView',
    props: true,
    component: () => import('../views/PaymentsForCurrentEventView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/entriesForEvent/:id',
    name: 'EntriesForEventView',
    props: true,
    component: () => import('../views/EntriesForCurrentEventView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/eventCategory/:id',
    name: 'EventProfileView',
    props: true,
    component: () => import('../views/EventProfileView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedIn: true }
  },
  {
    path: '/eventCategory/:event_category_id/finalEntries',
    name: 'FinalEventEntriesView',
    props: true,
    component: () => import('../views/FinalEventEntriesView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/userProfile/:id',
    name: 'UserProfileView',
    props: true,
    component: () => import('../views/UserProfileView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/createCatalogue',
    name: 'CreateCatalogueView',
    props: true,
    component: () => import('../views/CreateCatalogueView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/catalogueList',
    name: 'CatalogueListView',
    props: true,
    component: () => import('../views/CatalogueListView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/catalogue/:id',
    name: 'CatalogueView',
    props: true,
    component: () => import('../views/CatalogueView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/exhibitions',
    name: 'EditExhibitionView',
    props: true,
    component: () => import('../views/EditExhibitionView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedIn: true }
  },
  {
    path: '/exhibition/:exhibition_id/ring/:ring_id',
    name: 'RingView',
    props: true,
    component: () => import('../views/RingView.vue'),
    meta: { isUserLoggedIn: true, isAdminLoggedIn: true, isJudgeLoggedIn: true }
  },
  {
    path: '/createSecretary',
    name: 'CreateSecretaryView',
    props: true,
    component: () => import('../views/CreateSecretaryView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/createPost',
    name: 'CreatePostView',
    props: true,
    component: () => import('../views/CreatePostView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: true, isJudgeLoggedIn: false }
  },
  {
    path: '/:catchAll(.*)',
    name: 'notFound',
    component: () => import('../views/NotFoundView.vue'),
    meta: { isUserLoggedIn: false, isAdminLoggedIn: false, isJudgeLoggedIn: false }
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  if (to.name === 'home') {
    next();
  }
  //ha bejelentkezett útvonal van de nincs bejelentkezve senki
  else if ((to.meta.isUserLoggedIn || to.meta.isAdminLoggedIn || to.meta.isJudgeLoggedIn) && (!store.getters.isUserLoggedIn && !store.getters.isAdminLoggedIn && !store.getters.isJudgeLoggedIn)) {
    next('/login');
    console.log('yo')
  }
  else if (!to.meta.isUserLoggedIn && store.getters.isUserLoggedIn) {
    next('/exhibitions');
  }
  else if (!to.meta.isAdminLoggedIn && store.getters.isAdminLoggedIn) {
    next('/exhibitions');
  }
  else if (!to.meta.isJudgeLoggedIn && store.getters.isJudgeLoggedIn) {
    next('/exhibitions');
  }
  else {
    next();
  }
  // @ts-ignore
  window.Echo.leave('channel');
})


export default router
