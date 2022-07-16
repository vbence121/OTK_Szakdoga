<template>
  <div class="login">
    <div class="center">
      <h1>{{ loginLabels.login }}</h1>
      <h2 v-if="isRegistered" class="registered">Sikeres regisztráció!</h2>
      <form>
        <div class="inputbox">
          <input type="text" required="required" v-model="email" />
          <span>{{ loginLabels.email }}</span>
        </div>
        <div class="inputbox">
          <input type="text" required="required" v-model="password" />
          <span>{{ loginLabels.password }}</span>
        </div>
        <div class="inputbox">
          <input type="button" value="Mehet!" class="submit" @click="submit" />
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

export default defineComponent({
  name: "LoginView",
  components: {
  },

  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",

      isRegistered: store.getters.isRegistered
    };
  },

  methods: {
    async submit(): Promise<void> {
      const userData = JSON.stringify({
        email: this.email,
        password: this.password,
      });
      axios.post(
          "http://127.0.0.1:8000/api/login", userData,{
          headers: {
              "Content-Type":'application/json',
              "Accept":'application/json'
          }}
        )
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("There was an error!", error);
        });
    },

    created(){
      store.dispatch("setIsRegistered", {isRegistered: false});
    }
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
/* body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(45deg, greenyellow, dodgerblue);
  font-family: "Sansita Swashed", cursive;
} */

.registered {
  color: green;
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
  position: absolute;
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