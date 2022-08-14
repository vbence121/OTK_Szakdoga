
<template>
  <div :class="isAppLoading ? 'loading-container' : ''">
    <div v-if="isAppLoading" class="loading-center">
      <clip-loader :color="`#000`" class="loader"></clip-loader>
    </div>
    <div v-else>
      <nav>
        <router-link v-if="isUserLoggedIn || isAdminLoggedIn" to="/">Home</router-link>
        <router-link v-if="isUserLoggedIn" to="/editProfile"
          >Profilom</router-link
        >
        <router-link v-if="isUserLoggedIn" to="/dogs"
          >Kutyáim</router-link
        >
        <a v-if="isUserLoggedIn || isAdminLoggedIn" @click="logout">Kijelentkezés</a>
        <div>
          <router-link v-if="!isUserLoggedIn && !isAdminLoggedIn" to="/login"
            >Bejelentkezés</router-link
          >
          <router-link v-if="!isUserLoggedIn && !isAdminLoggedIn" to="/register"
            >Regisztráció</router-link
          >
        </div>
      </nav>
      <router-view />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import store from "@/store";
import router from "@/router";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";

export default defineComponent({
  name: "App",

  components: { ClipLoader },

  computed: {
    isUserLoggedIn(): boolean {
      return this.$store.getters.isUserLoggedIn;
    },
    isAdminLoggedIn(): boolean {
      return this.$store.getters.isAdminLoggedIn;
    },
  },

  created() {
    this.isAppLoading = true;
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        if (response.data.email !== undefined && response.data.email !== "") {
          store.dispatch("setUserEmail", {
            email: response.data.email,
            userType: response.data.user_type,
          });
          router.push({ path: "/" });
          console.log(response)
          this.isAppLoading = false;
        } else {
          this.errorMessage = "Hiba történt...";
        }
      })
      .catch((err) => {
        console.log(err);
        this.isAppLoading = false;
      });
  },

  methods: {
    async logout(): Promise<void> {
      await fetch("http://localhost:8000/api/logout", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        credentials: "include",
      }).then((response) => {
        if (response.ok) {
          store.dispatch("setAllUsersLoggedOut");
          router.push({ path: "/login" });
        }
      });
    },
  },

  data() {
    return {
      isAppLoading: false,
      errorMessage: "",
    };
  },
});
</script>

<style>
.loading-center{
  display:flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.loading-container{
  margin: 0px;
  height: 100vh;
}

.loader {
  margin-left: 30px;
  margin-top: 5px;
}

a {
  margin: 0px 15px;
  cursor: pointer;
}

a:hover {
  color: dodgerblue;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  width:100%;
  height: 100%;
}

body {
  margin: 0px;
  height: 100vh;
}

nav {
  padding: 30px;
  border-bottom: 1px solid #dfe1e5;
  box-shadow: 0 4px 6px -8px #222;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
  text-decoration: none;
}

nav a.router-link-exact-active {
  color: dodgerblue;
}
</style>
