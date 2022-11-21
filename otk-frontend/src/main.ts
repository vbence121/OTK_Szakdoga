import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "vue-universal-modal/dist/index.css";
import VueUniversalModal from "vue-universal-modal";

import Echo from "laravel-echo";

import Pusher from "pusher-js";
// @ts-ignore
window.Pusher = Pusher;
// @ts-ignore
window.Echo = new Echo({
  broadcaster: "pusher",
  key: process.env.VUE_APP_WEBSOCKETS_KEY,
  wsHost: process.env.VUE_APP_WEBSOCKETS_SERVER,
  wsPort: 6001,
  forceTLS: false,
  disableStats: true,
});

createApp(App)
  .use(store)
  .use(router)
  .use(VueUniversalModal, {
    teleportTarget: "#modals",
  })
  .mount("#app");
