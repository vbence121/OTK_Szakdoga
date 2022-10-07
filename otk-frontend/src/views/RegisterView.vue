<template>
  <div class="register">
    <div class="center">
      <h1>{{ registerLabels.registration }}</h1>
      <form>
        <div class="inputbox">
          <span>{{registerLabels.email}}</span>
          <input
            type="text"
            required="required"
            v-model="email"
          />
        </div>
        <div class="inputbox">
          <span>{{registerLabels.userName}}</span>
          <input
            type="text"
            required="required"
            v-model="username"
          />
        </div>
        <div class="inputbox">
          <span>{{registerLabels.fullName}}</span>
          <input
            type="text"
            required="required"
            v-model="realName"
          />
        </div>
        <div class="inputbox">
          <span>{{registerLabels.phoneNumber}}</span>
          <input
            type="text"
            required="required"
            v-model="phone"
          />
        </div>
        <div class="inputbox">
          <span>{{registerLabels.company}}</span>
          <input
            type="text"
            v-model="company"
          />
        </div>
        <div class="inputbox">
          <span>{{registerLabels.password}}</span>
          <input
            type="text"
            required="required"
            v-model="password"
          />
        </div>
        <div class="inputbox">
          <span>{{registerLabels.passwordAgain}}</span>
          <input
            type="text"
            required="required"
            v-model="passwordAgain"
          />
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
      phone: "",
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
    async submit(): Promise<void> {
      this.errorMessage = "";
      this.loaderActive = true;
      const userData = JSON.stringify({
        email: this.email,
        username: this.username,
        password: this.password,
        password_confirmation: this.passwordAgain,
        name: this.realName,
        phone: this.phone,
        company: this.company,
      });
      axios
        .post("http://127.0.0.1:8000/api/register", userData, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.loaderActive = false;
          store.dispatch("setIsRegistered", { isRegistered: true });
          router.push({ path: "login" });
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            if (error.response.data.errors.email)
              this.errorMessage = error.response.data.errors.email[0];
            else if (error.response.data.errors.password)
              this.errorMessage = error.response.data.errors.password[0];
            else if (error.response.data.errors.name)
              this.errorMessage = error.response.data.errors.name[0];
            else if (error.response.data.errors.username)
              this.errorMessage = error.response.data.errors.username[0];
            else if (error.response.data.errors.phone)
              this.errorMessage = error.response.data.errors.phone[0];
            else this.errorMessage = "Hiba történt...";
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
.flex {
  display: flex;
  justify-content: left;
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

.register {
  display: flex;
  justify-content: center;
  margin: 20px;
}
</style>