<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Felhasználó Adatai</h1>
          <clip-loader
            :loading="userDataLoading"
            :color="color"
            class="loader-for-data"
          ></clip-loader>
          <div v-if="!userDataLoading && !isViewChanged">
            <div class="each-row">
              <div>{{ registerLabels.userName }}:</div>
              <div>
                {{ user.username }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.email }}:</div>
              <div>
                {{ user.email }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.fullName }}:</div>
              <div>
                {{ user.name }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.phoneNumber }}:</div>
              <div>
                {{ user.phone }}
              </div>
            </div>
            <div class="each-row">
              <div>{{ registerLabels.company }}:</div>
              <div>
                {{ user.company }}
              </div>
            </div>
            <button class="back-button" @click="backToRegisteredDogView">
              Vissza!
            </button>
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
import { User } from "../types/types";

export default defineComponent({
  name: "UserProfileView",
  components: { ClipLoader },

  data() {
    return {
      user: {} as User,
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
    lastOpenedRegisteredDog() {
      return this.$store.getters.getLastOpenedRegisteredDog;
    },
  },

  created() {
    this.getUserById();
  },

  methods: {
    backToRegisteredDogView(): void {
      if(this.$store.getters.getLastOpenedRegisteredDogDestination){
        this.$router.push({
          path:
            "/events/" +
            this.$store.getters.getLastOpenedEventId +
            "/registeredDogProfileWithPayment/" +
            this.$store.getters.getLastOpenedRegisteredDog.dog_id +
            "/" +
            this.$store.getters.getLastOpenedRegisteredDog.dog_class_id
        });
      } else {
        this.$router.push({
          path:
            "/events/" +
            this.$store.getters.getLastOpenedEventId +
            "/RegisteredDogProfile/" +
            this.$store.getters.getLastOpenedRegisteredDog.id +
            "/" +
            this.$store.getters.getLastOpenedRegisteredDog.dog_class_id
        });
      }
    },

    getUserById() {
      axios
        .get(`http://localhost:8000/api/users/${this.$route.params.id}`, {
          withCredentials: true,
        })
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response, "owner");
            this.user = response.data;
          } else {
            this.errorMessage = "Hiba történt...";
          }
        })
        .catch((err) => {
          console.log(err);
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
  width: 80%;
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
  width: 50%;
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