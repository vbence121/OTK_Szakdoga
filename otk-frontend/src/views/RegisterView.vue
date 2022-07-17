<template>
  <div class="register">
    <div class="center">
      <h1>{{ registerLabels.registration }}</h1>
      <form>
        <div class="inputbox">
          <input type="text" required="required" v-model="email" />
          <span>{{ registerLabels.email }}</span>
        </div>
        <div class="inputbox">
          <input type="text" required="required" v-model="username" />
          <span>{{ registerLabels.userName }}</span>
        </div>
        <div class="inputbox">
          <input type="text" required="required" v-model="realName" />
          <span>{{ registerLabels.fullName }}</span>
        </div>
        <div class="inputbox">
          <input type="text" required="required" v-model="phoneNumber" />
          <span>{{ registerLabels.phoneNumber }}</span>
        </div>
        <div class="inputbox">
          <input type="text" v-model="company" />
          <span>{{ registerLabels.company }}</span>
        </div>
        <div class="inputbox">
          <input type="text" required="required" v-model="password" />
          <span>{{ registerLabels.password }}</span>
        </div>
        <div class="inputbox">
          <input type="text" required="required" v-model="passwordAgain" />
          <span>{{ registerLabels.passwordAgain }}</span>
        </div>
        <div class="inputbox flex">
          <input type="button" value="Mehet!" class="submit" @click="submit" />
          <clip-loader
            :loading="loaderActive"
            :color="color"
            class="loader"
          ></clip-loader>
          <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
        </div>
      </form>
    </div>
    <button @click="hide">hide</button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { REGISTER } from "../labels/labels";
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import router from "@/router";
import store from "@/store";

export default defineComponent({
  name: "RegisterView",
  components: { ClipLoader },

  data() {
    return {
      email: "",
      username: "",
      password: "",
      passwordAgain: "",
      realName: "",
      phoneNumber: "",
      company: "",

      errorMessage: "",
      loaderActive: false,
      color: "#000",
    };
  },

  computed: {
    registerLabels() {
      return REGISTER;
    },
  },

  methods: {
    hide(){
      //this.$store.dispatch("setIsRegistered", {isRegistered: !this.$store.getters.isRegistered});
      this.$store.dispatch("setIsLoggedIn", {isLoggedIn: !this.$store.getters.isLoggedIn});
    },

    async submit(): Promise<void> {
      this.errorMessage = '';
      this.loaderActive = true;
      const userData = JSON.stringify({
        email: this.email,
        username: this.username,
        password: this.password,
        password_confirmation: this.passwordAgain,
        name: this.realName,
        phoneNumber: this.phoneNumber,
        company: this.company,
      });
      axios
        .post("http://127.0.0.1:8000/api/register", userData, {
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.loaderActive = false;
          store.dispatch("setIsRegistered", {isRegistered: true});
          router.push({ path: 'login' })
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          }
          else if(error.response.data.errors !== undefined){
            if(error.response.data.errors.email) this.errorMessage = error.response.data.errors.email[0];
            else if(error.response.data.errors.password) this.errorMessage = error.response.data.errors.password[0];
            else if(error.response.data.errors.name) this.errorMessage = error.response.data.errors.name[0];
            else if(error.response.data.errors.username) this.errorMessage = error.response.data.errors.name[0];
            else if(error.response.data.errors.phoneNumber) this.errorMessage = error.response.data.errors.phoneNumber[0];
            else this.errorMessage = "Hiba történt..."
          }
          console.error("There was an error!", error);
          this.loaderActive = false;
        });
    },
  },
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");

.error {
  color: red;
  margin: auto;
  font-family: sans-serif;
  margin-left: 20px;
}
.loader {
  margin-left: 30px;
  margin-top: 5px;
}
.flex {
  display: flex;
  justify-content: left;
}
.center {
  position: relative;
  padding: 50px 50px;
  background: #fff;
  border-radius: 10px;
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
  position: relative;
  width: 300px;
  height: 50px;
  margin-bottom: 25px;
}
.center .inputbox input {
  top: 0;
  left: 0;
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
  position: absolute;
  top: 14px;
  left: 20px;
  font-size: 1em;
  transition: 0.6s;
  font-family: sans-serif;
}
.center .inputbox input:focus ~ span,
.center .inputbox input:valid ~ span {
  transform: translateX(-13px) translateY(-35px);
  font-size: 1em;
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
</style>