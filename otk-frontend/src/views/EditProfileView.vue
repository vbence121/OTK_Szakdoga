<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Adataim</h1>
          <clip-loader
            :loading="userDataLoading"
            :color="color"
            class="loader-for-data"
          ></clip-loader>
          <div v-if="!userDataLoading && !isViewChanged">
            <div class="each-row">
              <div>{{ registerLabels.userName }}:</div>
              <div class="user-value">
                {{ username }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.email }}:</div>
              <div class="user-value">
                {{ email }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.fullName }}:</div>
              <div class="user-value">
                {{ name }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.phoneNumber }}:</div>
              <div class="user-value">
                {{ phone }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.company }}:</div>
              <div class="user-value">
                {{ company }}
              </div>
            </div>
            <router-link class="password-link" to="/passwordChange">
              Jelszó módosítása
            </router-link>
            <router-link class="password-link" to="/deleteProfile"
              >Profilom törlése</router-link
            >
            <div class="inputbox flex">
              <input
                type="button"
                value="Adatok módosítása"
                class="edit-button"
                @click="changeToEditProfileView"
              />
            </div>
          </div>
          <div v-if="isViewChanged" class="center">
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
              <div class="flex-buttons">
                <input
                  type="button"
                  value="Mentés!"
                  class="save-button"
                  @click="submit"
                />
                <clip-loader
                  :loading="loaderActive"
                  :color="color"
                  class="loader-for-save"
                ></clip-loader>
                <button class="back-button" @click="changeToEditProfileView">
                  Vissza!
                </button>
              </div>
              <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
              <div v-if="successMessage" class="success">
                {{ successMessage }}
              </div>
            </form>
          </div>
        </div>
      </div>
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
      isViewChanged: false,

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
    if (!this.$store.getters.getIsUserLoaded) {
      this.userDataLoading = true;
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

            this.userDataLoading = false;
          } else {
            this.errorMessage = "Hiba történt...";
          }
        })
        .catch((err) => {
          console.log(err);
          this.userDataLoading = false;
        });
    } else {
      this.id = this.$store.getters.getUserData.id;
      this.email = this.$store.getters.getUserData.email;
      this.username = this.$store.getters.getUserData.username;
      this.name = this.$store.getters.getUserData.name;
      this.phone = this.$store.getters.getUserData.phone;
      this.company = this.$store.getters.getUserData.company;
    }
  },

  methods: {
    changeToEditProfileView(): void {
      this.isViewChanged = !this.isViewChanged;
    },

    async submit(): Promise<void> {
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      let userData: any;

      userData = JSON.stringify({
        email:
          this.email !== this.$store.getters.getUserData.email
            ? this.email
            : undefined,
        username:
          this.username !== this.$store.getters.getUserData.username
            ? this.username
            : undefined,
        name: this.name,
        phone: this.phone,
        company: this.company,
      });
      axios
        .put(`http://localhost:8000/api/user/modify/${this.id}`, userData, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          if (response.status !== undefined && response.status === 200) {
            this.$store.dispatch("setUserData", { userData: response.data });
            this.$store.dispatch("setIsUserLoaded", { isUserLoaded: true });
            this.successMessage = "Sikeres mentés!";
          }
          this.loaderActive = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            if (error.response.data.errors.email)
              this.errorMessage = error.response.data.errors.email[0];
            else if (error.response.data.errors.name)
              this.errorMessage = error.response.data.errors.name[0];
            else if (error.response.data.errors.username)
              this.errorMessage = error.response.data.errors.username[0];
            else if (error.response.data.errors.phone)
              this.errorMessage = error.response.data.errors.phone[0];
            else this.errorMessage = "Hiba történt...";
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

a {
  margin: 0px;
}

.each-row > div:first-child {
  margin-right: 10px;
}

.user-value {
  word-break: break-all;
}

.password-link,
.delete-profile {
  text-decoration: none;
  display: flex;
  border-bottom: 1px solid #a7acf1;
  padding: 5px;
  color: #6b74f7;
  font-style: italic;
}

.password-link:hover,
.delete-profile:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
}

.password-button {
  margin: 0px 0px 10px 0px;
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}
.password-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.inner-container {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
}

h2 {
  color: black;
}

.outer-container {
  display: flex;
  justify-content: center;
}

.info-container {
  width: 600px;
  display: flex;
  justify-content: center;
  margin: 20px;
}

.wrapper {
  min-width: 80%;
}

.each-row {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #dfe1e5;
  padding: 5px;
  color: #909090;
}

.error {
  color: red;
  margin: auto;
}
.success {
  color: green;
  margin: auto;
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
  padding: 30px 50px;
  background: #fff;
  border-radius: 10px;
  padding-bottom: 20px;
  height: 510px;
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

.edit-button {
  margin: 20px 0px 10px 0px;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}

.edit-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.back-button {
  margin: 20px 0px 10px 0px;
  background: rgb(134, 135, 136);
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px 20px;
}

.back-button:hover {
  background: linear-gradient(45deg, rgb(93, 94, 92), dodgerblue);
}

.flex-buttons {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.save-button {
  margin: 20px 0px 10px 0px;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px 20px;
}

.save-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}
</style>