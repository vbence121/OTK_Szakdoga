<template>
  <div class="login">
    <div class="center">
      <h1>{{ loginLabels.login }}</h1>
      <h2 v-if="isRegistered" class="registered">Sikeres regisztráció!</h2>
      <form>
        <div class="inputbox">
          <span>{{ loginLabels.email }}</span>
          <input type="text" required="required" v-model="email" />
        </div>
        <div class="inputbox">
          <span>{{ loginLabels.password }}</span>
          <input type="text" required="required" v-model="password" />
        </div>
        <div class="inputbox flex">
          <input type="button" value="Mehet!" class="submit" @click="submit" />
          <div class="loader-container">
            <clip-loader
              :loading="loaderActive"
              :color="color"
              class="mt-2"
            ></clip-loader>
          <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { LOGIN } from "../labels/labels";
import axios from "axios";
import store from "@/store";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import router from "@/router";

export default defineComponent({
  name: "LoginView",
  components: { ClipLoader },

  data() {
    return {
      email: "",
      password: "",

      errorMessage: "",
      loaderActive: false,
      color: "#000",
      isRegistered: store.getters.isRegistered,
    };
  },

  methods: {
    async submit(): Promise<void> {
      axios.defaults.withCredentials = true;
      this.errorMessage = "";
      this.loaderActive = true;
      const userData = JSON.stringify({
        email: this.email,
        password: this.password,
      });
      fetch("http://localhost:8000/api/login", {
        method: "POST",
        body: userData,
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        credentials: "include",
      })
        .then(async (response) => {
          console.log('res', response);
          if (
            response.status === 401 ||
            response.status === 500 ||
            response.status === 422
          ) {
            this.loaderActive = false;
            throw Error("Hibás bejelentkezési adatok!");
          } else if (response.status)
            if (response.ok) {
              const content = await response.json();
              console.log("yesss", content);
              if (
                content.user.email !== undefined &&
                content.user.email !== "" &&
                content.user.user_type !== undefined
              ) {
                await store.dispatch("setUserEmail", {
                  email: content.user.email,
                  userType: content.user.user_type,
                });
                if(content.user.user_type === 1){
                  this.$store.dispatch("setUserData", { userData: content.user });
                  this.$store.dispatch("setIsUserLoaded", { isUserLoaded: true });
                }
                store.dispatch("setIsRegistered", { isRegistered: false });
                router.push({ path: "/" });
              } else {
                this.errorMessage = "Hiba történt...";
              }
              this.loaderActive = false;
            }
        })
        .catch((error) => {
          if (error.message === "Failed to fetch")
            this.errorMessage = "Nincs kapcsolat!";
          else this.errorMessage = error.message;
          this.loaderActive = false;
          console.error("There was an error!", error);
        });
    },

    created() {
      store.dispatch("setIsRegistered", { isRegistered: false });
    },
  },

  computed: {
    loginLabels() {
      return LOGIN;
    },
  },
});
</script>

<style scoped>
.login {
  text-align: left;
}

@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");

@media screen and (max-width: 500px) {
  .center {
    width: 100%;
  }

  h1 {
    word-break: break-all;
  }

  .flex {
    flex-direction: column-reverse;
  }

  .submit {
    width: 100% !important;
  }

  .loader-container {
    margin-bottom: 10px;
  }
}

.flex {
  display: flex;
}

.loader-container {
  width: 100%;
}

.error {
  color: red;
  margin: auto;
  margin-left: 20px;
}

.loader {
  margin-top: 5px;
}

.registered {
  color: green;
}

.center {
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
  width: 400px;
}
.center h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}
.center .inputbox {
  max-width: 300px;
  margin-bottom: 15px;
}
.center .inputbox input {
  width: 100%;
  border: 2px solid #000;
  outline: none;
  background: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 1.2em;
}
.center .inputbox:last-child {
  margin-bottom: 0;
}
.center .inputbox span {
  /* position: absolute; */
  font-size: 1em;
  transition: 0.6s;
}

.center .inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.center .inputbox:hover [type="button"] {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.submit:hover {
  cursor: pointer;
}

.login {
  display: flex;
  justify-content: center;
  margin: 20px;
}
</style>