<template>
  <div class="register">
    <div class="center">
    <h1>Adataim</h1>

    <clip-loader
        :loading="userDataLoading"
        :color="color"
        class="loader-data"
    ></clip-loader>
    <form v-if="!userDataLoading">
    <div class="inputbox">
        <input type="text" required="required" v-model="email" />
        <span>{{ registerLabels.email }}</span>
    </div>
    <div class="inputbox">
        <input type="text" required="required" v-model="username" />
        <span>{{ registerLabels.userName }}</span>
    </div>
    <div class="inputbox">
        <input type="text" required="required" v-model="name" />
        <span>{{ registerLabels.fullName }}</span>
    </div>
    <div class="inputbox">
        <input type="text" required="required" v-model="phone" />
        <span>{{ registerLabels.phoneNumber }}</span>
    </div>
    <div class="inputbox">
        <input type="text" v-model="company" />
        <span>{{ registerLabels.company }}</span>
    </div>
    <div class="inputbox flex">
        <input type="button" value="Mentés!" class="submit" @click="submit" />
        <clip-loader
        :loading="loaderActive"
        :color="color"
        class="loader"
        ></clip-loader>
        <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
        <div v-if="successMessage" class="success">{{ successMessage }}</div>
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

export default defineComponent({
  name: "EditProfileView",
  components: { ClipLoader },

  data() {
    return {
      id: -1,
      email: "",
      username: "",
      name: "",
      phone: "",
      company: "",

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      userDataLoading: false,
      color: "#000",
    };
  },

  computed: {
    registerLabels() {
      return REGISTER;
    },
  },

  created() {
    this.isAppLoading = true;
    this.userDataLoading= true;
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        if (response.data.email !== undefined && response.data.email !== "") {
            this.id = response.data.id;
            this.email = response.data.email;
            this.username = response.data.username;
            this.name = response.data.name;
            this.phone = response.data.phone;
            this.company = response.data.company;

            this.isAppLoading = false;
            this.userDataLoading = false;
        } else {
            this.errorMessage = "Hiba történt...";
        }
      })
      .catch((err) => {
            console.log(err);
            this.isAppLoading = false;
            this.userDataLoading = false;
      });
  },

  methods: {
    async submit(): Promise<void> {
      this.errorMessage = '';
      this.successMessage = '';
      this.loaderActive = true;
      const userData = JSON.stringify({
        email: this.email,
        username: this.username,
        name: this.realName,
        phone: this.phone,
        company: this.company,
      });
      axios
        .put(`http://localhost:8000/api/user/modify/${this.id}`, userData, {
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          if(response.status !== undefined && response.status === 200){
            this.successMessage = "Sikeres mentés!";
          }
          this.loaderActive = false;
          
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          }
          else if(error.response.data.errors !== undefined){
              if(error.response.data.errors.email) this.errorMessage = error.response.data.errors.email[0];
            else if(error.response.data.errors.name) this.errorMessage = error.response.data.errors.name[0];
            else if(error.response.data.errors.username) this.errorMessage = error.response.data.errors.username[0];
            else if(error.response.data.errors.phone) this.errorMessage = error.response.data.errors.phone[0];
            else this.errorMessage = "Hiba történt..."
            console.error("There was an error!", error);
          }
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
.success {
  color: green;
  margin: auto;
  font-family: sans-serif;
  margin-left: 20px;
}
.loader {
  margin-left: 30px;
  margin-top: 5px;
}
.loader-data {
  text-align: left;
  margin-left: 120px;
  margin-top: 200px;
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