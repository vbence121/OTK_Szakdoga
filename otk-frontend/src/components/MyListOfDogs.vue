<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1 class="d-flex">
            Saját kutyáim
            <div v-if="this.$route.params.deleteSuccessMessage" class="success">
              {{ this.$route.params.deleteSuccessMessage }}
            </div>
          </h1>
          <table>
            <tr class="header">
              <td class="text-center">Kutya neve</td>
              <td class="text-center">Fajtája</td>
              <td class="text-center">létrehozás időpontja</td>
            </tr>
            <tr
              v-for="(dog, index) in this.$store.getters.getMyDogs"
              :key="index"
              class="each-entry related-dogs"
              @click="navigateToDogView(dog.id)"
            >
              <td class="text-center">
                {{ dog.name }}
              </td>
              <td class="text-center">
                {{ dog.breed }}
              </td>
              <td class="text-center">
                {{ dateFormatter(dog.created_at) }}
              </td>
            </tr>
          </table>
          <clip-loader
            :loading="loaderActiveForList"
            :color="color"
            class="loader"
          ></clip-loader>
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
  name: "MyListOfDogs",
  components: { ClipLoader },

  data() {
    return {
      errorMessage: "",
      color: "#000",
      loaderActiveForList: false,
      deleteSuccessMessage: "",
    };
  },

  computed: {
    myDogs() {
      return this.$store.getters.getMyDogs;
    },
  },

  created() {
    this.getUserDogs();
  },

  methods: {
    dateFormatter(date: string) {
      return date.split("T")[0];
    },

    navigateToDogView(dogId: number): void {
      this.$router.push({
        path: "/dogProfile/" + dogId,
      });
    },

    getUserDogs() {
      if (
        !this.$store.getters.getIsDogsLoaded ||
        this.$route.params.deleteSuccessMessage !== undefined
      ) {
        this.errorMessage = "";
        this.loaderActiveForList = true;
        this.$store.dispatch("setMyDogs", { myDogs: [] });
        this.$store.dispatch("setIsDogsLoaded", { isDogsLoaded: false });
        axios
          .get("http://localhost:8000/api/mydogs", {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          })
          .then((response) => {
            console.log(response);
            //this.myDogs = response.data;
            this.$store.dispatch("setMyDogs", { myDogs: response.data });
            this.$store.dispatch("setIsDogsLoaded", { isDogsLoaded: true });
            this.loaderActiveForList = false;
          })
          .catch((error) => {
            if (error.message === "Network Error") {
              //this.errorMessage = "Nincs kapcsolat!";
            } else if (error.response.data.errors !== undefined) {
              //this.errorMessage = "Hiba történt...";
            }
            console.error("There was an error!", error);
            this.loaderActiveForList = false;
          });
      }
    },
  },
});
</script>

<style scoped>
.loader-for-data {
  margin-top: 30px;
}

.related-dogs {
  /* border-bottom: 1px solid rgb(177, 175, 175); */
  padding: 2px;
  width: 100%;
}

.related-dogs:hover {
  color: rgb(66, 77, 233);
}

tr {
  /* border: 1px solid black; */
}

table {
  width: 100%;
}

td {
  padding: 10px;
}

.each-entry {
  /* border-bottom: 1px solid black; */
}

.each-entry:hover {
  cursor: pointer;
  background-color: #efeff1;
}

.header {
  border-bottom: 1px solid rgb(212, 209, 209);
}

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
  width: 80%;
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
  margin-top: 25px;
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