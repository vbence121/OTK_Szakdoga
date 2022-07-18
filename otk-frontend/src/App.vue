
<template>
  <div>
    <nav>
      <router-link v-if="isLoggedIn" to="/">Home</router-link>
      <div v-if="isLoggedIn" @click="logout">Kijelentkezés</div>
      <div>
        <router-link v-if="!isLoggedIn" to="/login">Bejelentkezés</router-link>
        <router-link v-if="!isLoggedIn" to="/register"
          >Regisztráció</router-link
        >
      </div>
    </nav>
    <router-view />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import store from "@/store";
import router from "@/router";

export default defineComponent({
  name: "App",

  computed: {
    isLoggedIn(): boolean {
      return this.$store.getters.isLoggedIn;
    },
  },

  created() {
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        console.log(response);
        if (response.data.email !== undefined && response.data.email !== "") {
          store.dispatch("setUserEmail", {
            email: response.data.email,
            isLoggedIn: true,
          });
          router.push({ path: "/" });
        } else {
          this.errorMessage = "Hiba történt...";
        }
      })
      .catch((err) => {
        console.log(err);
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
          store.dispatch("setUserEmail", { email: "", isLoggedIn: false });
          router.push({ path: "/login" });
        }
      });
    },
  },

  data() {
    return {
      errorMessage: "",
    };
  },
});
</script>

<style>
a {
  margin: 0px 15px;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

body {
  margin: 0px;
  padding: 0px;
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
