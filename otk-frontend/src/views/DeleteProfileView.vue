<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Profil törlése</h1>
          <form>
            <div class="inputbox">
              <input
                type="text"
                v-model="password"
                placeholder="A törléshez írja be a jelszavát."
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
              <button class="save-button" @click="deleteProfile">
                Törlés!
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
import router from "@/router";

export default defineComponent({
  name: "DeleteProfileView",
  components: { ClipLoader },
  data() {
    return {
      password: "",

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      userDataLoading: false,
      color: "#000",
    };
  },

  methods: {
    deleteProfile(): void {
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      const userData = JSON.stringify({
        password: this.password,
      });
      axios
        .post("http://localhost:8000/api/user/delete", userData, {
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
          this.$store.dispatch("setAllUsersLoggedOut");
          router.push({ path: '/login' })
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
            if(error.response.data.errors.password) this.errorMessage = error.response.data.errors.password[0];
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
}

.wrapper {
    width: 400px;
}
.success {
  color: green;
  margin: auto;
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