<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Jelszó módosítása</h1>
          <form>
            <div class="inputbox">
              <input
                type="text"
                v-model="oldPassword"
                placeholder="Régi jelszó"
              />
              <input
                type="text"
                v-model="password"
                placeholder="Új jelszó"
              />
              <input
                type="text"
                v-model="password_confirmation"
                placeholder="Új jelszó újra"
              />
              <clip-loader
                :loading="loaderActive"
                :color="color"
                class="loader-password"
              ></clip-loader>
              <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
              <div v-if="successMessage" class="success">
                {{ successMessage }}
              </div>
              <button class="save-button" @click="changePassword">
                Módosít!
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent } from "vue";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";

export default defineComponent({
  name: "ChangePasswordView",
  components: { ClipLoader },
  data() {
    return {
      oldPassword: "",
      password: "",
      password_confirmation: "",

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      userDataLoading: false,
      color: "#000",
    };
  },

  methods: {
    changePassword(): void {
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      const userData = JSON.stringify({
        oldPassword: this.oldPassword,
        password: this.password,
        password_confirmation: this.password_confirmation,
        user_type: this.$store.getters.getUserData.user_type,
      });
      axios
        .post("http://localhost:8000/api/changePassword", userData, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          this.successMessage = "Sikeres mentés!";
          this.loaderActive = false;
        })
        .catch((error) => {
          console.log(error);
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          }
          else if(error.response.status === 401) {
            this.errorMessage = error.response.data.password;
          }
          else if(error.response.data.errors !== undefined){
            if(error.response.data.errors.oldPassword) this.errorMessage = error.response.data.errors.oldPassword[0];
            else if(error.response.data.errors.password) this.errorMessage = error.response.data.errors.password[0];
            else if(error.response.data.errors.user_type) this.errorMessage = error.response.data.errors.user_type[0];
            else this.errorMessage = "Hiba történt..."
          }
          this.loaderActive = false;
        });
    },
  },
});
</script>

<style scoped>
.error {
  color: red;
  margin: auto;
  font-family: sans-serif;
}
.success {
  color: green;
  margin: auto;
  font-family: sans-serif;
}
.loader-password {
  margin-top: 10px;
}

.info-container {
  width: 500px;
  display: flex;
  justify-content: center;
  margin: 20px;
}

.inner-container {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
}

.outer-container {
  display: flex;
  justify-content: center;
}

h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 20px;
  font-weight: bold;
  padding-left: 10px;
}

.inputbox input {
  top: 0;
  left: 0;
  width: 100%;
  border: 2px solid #000;
  outline: none;
  background: none;
  padding: 10px;
  border-radius: 10px;
  font-size: 1.2em;
  margin: 10px 0px;
}

.save-button {
  margin: 20px 0px 10px 0px;
  width: 100%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}

.save-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}
</style>