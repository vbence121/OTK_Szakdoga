<template>
  <div :class="isAppLoading ? 'loading-container' : ''">
    <div v-if="isAppLoading" class="loading-center">
      <clip-loader :color="`#000`" class="loader"></clip-loader>
    </div>
    <div v-else>
      <CNavbar expand="lg">
        <CContainer fluid>
          <CNavbarToggler
            class="toggler"
            aria-label="Toggle navigation"
            aria-expanded="{visible}"
            @click="visible = !visible"
          />
          <CCollapse class="navbar-collapse" :visible="visible">
            <CNavbarNav class="navcontainer">
              <CNavItem>
                <router-link
                  v-if="isUserLoggedIn || isAdminLoggedIn || isJudgeLoggedIn"
                  to="/"
                  >Home</router-link
                >
              </CNavItem>
              <CNavItem>
                <router-link v-if="isUserLoggedIn" to="/editProfile"
                  >Profilom</router-link
                >
              </CNavItem>
              <CNavItem>
                <router-link v-if="isJudgeLoggedIn" to="/exhibitions"
                  >Kiállítások</router-link
                >
              </CNavItem>

              <CDropdown
                variant="nav-item"
                to="/asd"
                :popper="false"
                v-if="isUserLoggedIn"
              >
                <CDropdownToggle class="dr-head" :href="null"
                  >Kiállítások</CDropdownToggle
                >
                <CDropdownMenu class="dr-down">
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/exhibitions"
                      >Elérhető kiállítások</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/dogEntry"
                      >Nevezés</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/myEntryStatuses"
                      >Nevezéseim állapota</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/catalogueList"
                      >Katalógusok megtekintése</router-link
                    ></CDropdownItem
                  >
                </CDropdownMenu>
              </CDropdown>

              <CDropdown
                variant="nav-item"
                :popper="false"
                v-if="isUserLoggedIn"
              >
                <CDropdownToggle class="dr-head" :href="null"
                  >Kutyáim</CDropdownToggle
                >
                <CDropdownMenu class="dr-down">
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/dogs"
                      >Új kutya hozzáadása</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/myDogs"
                      >Kutyák megtekintése</router-link
                    ></CDropdownItem
                  >
                </CDropdownMenu>
              </CDropdown>

              <CDropdown
                variant="nav-item"
                :popper="false"
                v-if="isAdminLoggedIn"
              >
                <CDropdownToggle>Kiállítások</CDropdownToggle>
                <CDropdownMenu class="dr-down">
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link class="dropdown-item" to="/createEvent"
                      >Létrehozás</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isUserLoggedIn">
                    <router-link class="dropdown-item" to="/myDogs"
                      >Kutyák megtekintése</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link
                      class="dropdown-item"
                      to="/exhibitions"
                      >Kiállítás szerkesztése</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link class="dropdown-item" to="/activeEvents"
                      >Aktív kategóriák</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link class="dropdown-item" to="/entries"
                      >Beérkező nevezések kezelése</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link class="dropdown-item" to="/paymentsForEntries"
                      >Beérkező nevezési díjak kezelése</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link class="dropdown-item" to="/createCatalogue"
                      >Katalógus készítése</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem v-if="isAdminLoggedIn">
                    <router-link class="dropdown-item" to="/catalogueList"
                      >Katalógusok megtekintése</router-link
                    ></CDropdownItem
                  >
                </CDropdownMenu>
              </CDropdown>

              <CDropdown
                variant="nav-item"
                :popper="false"
                v-if="isAdminLoggedIn"
              >
                <CDropdownToggle class="dr-head" :href="null"
                  >Titkárok</CDropdownToggle
                >
                <CDropdownMenu class="dr-down">
                  <CDropdownItem>
                    <router-link
                      class="dropdown-item"
                      v-if="isAdminLoggedIn"
                      to="/createSecretary"
                      >Létrehozás</router-link
                    ></CDropdownItem
                  >
                  <CDropdownItem>
                    <router-link
                      class="dropdown-item"
                      v-if="isUserLoggedIn"
                      to="/myDogs"
                      >Kutyák megtekintése</router-link
                    ></CDropdownItem
                  >
                </CDropdownMenu>
              </CDropdown>

              <CNavItem>
                <a
                  class="logout"
                  v-if="isUserLoggedIn || isAdminLoggedIn || isJudgeLoggedIn"
                  @click="logout"
                  >Kijelentkezés</a
                >
              </CNavItem>
              <CNavItem>
                <router-link
                  v-if="!isUserLoggedIn && !isAdminLoggedIn && !isJudgeLoggedIn"
                  to="/login"
                  >Bejelentkezés</router-link
                >
                <router-link
                  v-if="!isUserLoggedIn && !isAdminLoggedIn && !isJudgeLoggedIn"
                  to="/register"
                  >Regisztráció</router-link
                >
              </CNavItem>
            </CNavbarNav>
          </CCollapse>
        </CContainer>
      </CNavbar>
      <router-view />
    </div>
    <div id="modals"></div>
  </div>
</template>

<script lang="ts">
import {
  CCollapse,
  CNavbarNav,
  CNavItem,
  CNavbar,
  CContainer,
  CDropdown,
  CDropdownToggle,
  CDropdownMenu,
  CDropdownItem,
  CNavbarToggler,
} from "@coreui/vue";
import { defineComponent } from "vue";
import axios from "axios";
import store from "@/store";
import router from "@/router";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "@coreui/coreui/dist/css/coreui.min.css";
import "bootstrap/dist/css/bootstrap.min.css";

export default defineComponent({
  name: "App",

  components: {
    ClipLoader,
    CCollapse,
    CNavbarNav,
    CNavItem,
    CNavbar,
    CContainer,
    CDropdown,
    CDropdownToggle,
    CDropdownMenu,
    CDropdownItem,
    CNavbarToggler,
  },

  computed: {
    isUserLoggedIn(): boolean {
      return this.$store.getters.isUserLoggedIn;
    },
    isAdminLoggedIn(): boolean {
      return this.$store.getters.isAdminLoggedIn;
    },
    isJudgeLoggedIn(): boolean {
      return this.$store.getters.isJudgeLoggedIn;
    },
  },

  created() {
    this.isAppLoading = true;
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        console.log(response);
        if (
          response.data.user.email !== undefined &&
          response.data.user.email !== ""
        ) {
          store.dispatch("setUserEmail", {
            email: response.data.user.email,
            userType: response.data.user.user_type,
          });
          if (response.data.user.user_type === 1) {
            this.$store.dispatch("setUserData", {
              userData: response.data.user,
            });
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
  },

  data() {
    return {
      isAppLoading: false,
      errorMessage: "",
      visible: false,
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

.nav-item a {
  color: white;
}

.show {
  color: white !important;
}

.dr-down a {
  color: black;
}

.dropdown-menu a {
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
  background-color: #e5e6e9;
  /* background-image: url("@/assets/background.jpg"); */
  background-repeat: initial;
}

.navbar {
  padding: 30px;
  box-shadow: 0 4px 6px -8px #222;
  background-color: black;
}

.navbar a {
  font-weight: bold;
  text-decoration: none;
}

.navbar a.router-link-exact-active {
  color: dodgerblue;
}

.router-link-exact-active {
  color: dodgerblue !important;
}
.dr-head {
  color: white !important;
  background-attachment: fixed;
}
.toggler {
  color: white;
  background-color: dodgerblue;
}

.container-fluid {
  display: flex;
  justify-content: center;
}

.navcontainer {
  display: flex;
  align-items: center;
}

.nav-link:focus {
  color: white;
}

@media (max-width: 992px) {
  .navcontainer {
    align-items: initial;
  }

  li {
    margin-top: 10px;
  }

  a {
    margin-left: 0px;
  }
}
</style>
