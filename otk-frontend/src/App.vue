<template>
  <div :class="isAppLoading ? 'loading-container' : ''">
    <div v-if="isAppLoading" class="loading-center">
      <clip-loader :color="`#000`" class="loader"></clip-loader>
    </div>
    <div v-else>
      <nav class="d-flex align-items-center">
        <!-- USER -->
        <router-link v-if="isUserLoggedIn || isAdminLoggedIn" to="/"
          >Home</router-link
        >
        <router-link v-if="isUserLoggedIn" to="/editProfile"
          >Profilom</router-link
        >
        <div v-if="isUserLoggedIn" ref="eventsDropDown">
          <a
            @click="toggleDropDown"
            :class="[
              dropDownIsVisible
                ? 'dropdown-toggle show'
                : 'dropdown-toggle',
            ]"
            role="button"
            id="dropdownMenuLink"
            data-bs-toggle="dropdown"
            :aria-expanded="dropDownIsVisible"
          >
            Kiállítások
          </a>
          <ul
            :class="[
              dropDownIsVisible ? 'dropdown-menu show' : 'dropdown-menu',
            ]"
            aria-labelledby="dropdownMenuLink"
          >
            <li>
              <router-link
                class="dropdown-item"
                v-if="isUserLoggedIn"
                to="/dogEntry"
                @click="toggleDropDown"
                >Nevezés</router-link
              >
            </li>
            <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
          </ul>
        </div>

        <!-- ADMIN -->
        <div v-if="isAdminLoggedIn" ref="AdminEventsDropDown">
          <a
            @click="toggleDropDown"
            :class="[
              dropDownIsVisible
                ? 'dropdown-toggle show'
                : 'dropdown-toggle',
            ]"
            role="button"
            id="dropdownMenuLink"
            data-bs-toggle="dropdown"
            :aria-expanded="dropDownIsVisible"
          >
            Kiállítások
          </a>
          <ul
            :class="[
              dropDownIsVisible ? 'dropdown-menu show' : 'dropdown-menu',
            ]"
            aria-labelledby="dropdownMenuLink"
          >
            <li>
              <router-link
                class="dropdown-item"
                v-if="isAdminLoggedIn"
                to="/createEvent"
                @click="toggleDropDown"
                >Létrehozás/Megtekintés</router-link
              >
            </li>
            <li>
              <router-link
                class="dropdown-item"
                v-if="isAdminLoggedIn"
                to="/entries"
                @click="toggleDropDown"
                >Beérkező nevezések kezelése</router-link
              >
            </li>
          </ul>
        </div>
        <!-- <router-link v-if="isAdminLoggedIn" to="/createEvent"
          >Kiállítások</router-link
        > -->
        <router-link v-if="isUserLoggedIn" to="/dogs">Kutyáim</router-link>
        <a
          class="logout"
          v-if="isUserLoggedIn || isAdminLoggedIn"
          @click="logout"
          >Kijelentkezés</a
        >
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
    <div id="modals"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import axios from "axios";
import store from "@/store";
import router from "@/router";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

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

  mounted(){
    document.addEventListener('click', (e)=> {
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      if (this.$refs.eventsDropDown !==undefined && this.$refs.eventsDropDown?.contains(e.target)===false) {
        this.dropDownIsVisible = false;
      }
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      if (this.$refs.AdminEventsDropDown !==undefined && this.$refs.AdminEventsDropDown?.contains(e.target)===false) {
        this.dropDownIsVisible = false;
      }
    })
  },

  created() {
    this.isAppLoading = true;
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        console.log(response)
        if (response.data.user.email !== undefined && response.data.user.email !== "") {
          store.dispatch("setUserEmail", {
            email: response.data.user.email,
            userType: response.data.user.user_type,
          });
          if (response.data.user.user_type === 1) {
            this.$store.dispatch("setUserData", { userData: response.data.user });
            this.$store.dispatch("setIsUserLoaded", { isUserLoaded: true });
          }
          router.push({ path: "/" });
          console.log(response);
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

    toggleDropDown(): void {
      this.dropDownIsVisible = !this.dropDownIsVisible;
    },
  },

  data() {
    return {
      isAppLoading: false,
      errorMessage: "",

      dropDownIsVisible: false,
      show: false,
    };
  },
});
</script>



<style>
@import url("https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@1,700;1,800&family=Roboto+Condensed:ital,wght@1,700&display=swap");
.loading-center {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

li a {
  margin: 0px 0px;
}

body {
  font-family: "Fira Sans", sans-serif;
}

.loading-container {
  margin: 0px;
  height: 100vh;
}

.loader {
  margin-left: 30px;
  margin-top: 5px;
}

.logout {
  color: white;
}

a {
  margin: 0px 15px;
  cursor: pointer;
  text-decoration: none;
  color: black;
}

a:hover {
  color: dodgerblue;
}

#app {
  font-family: "Fira Sans", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  width: 100%;
  height: 100%;
}

body {
  margin: 0px;
  background-color: #f1f3f7;
  background-image: url("@/assets/background.jpg");
  background-repeat: initial;
}

nav {
  padding: 30px;
  /* border-bottom: 1px solid #dfe1e5; */
  box-shadow: 0 4px 6px -8px #222;
  background-color: black;
}

nav a {
  font-weight: bold;
  color: white;
  text-decoration: none;
}

nav a.router-link-exact-active {
  color: dodgerblue;
}
</style>
