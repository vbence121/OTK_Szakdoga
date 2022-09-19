<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <div class=" d-flex justify-content-between">
            <h1>{{selectedCatalogue?.name}}</h1>
            <button class="back-button" @click="backToCatalogueSelection()">
                Vissza!
              </button>
          </div>

          <div v-for="(dog, index) in catalogue" :key="index">
            <h4
              v-if="dog.categoryName !== catalogue[index - 1]?.categoryName"
              class="text-center underline"
            >
              {{ dog.categoryName }}
            </h4>
            <h5
              v-if="dog.breedGroupName !== catalogue[index - 1]?.breedGroupName"
              class="text-center"
            >
              {{ dog.breedGroupName }}
            </h5>
            <h5
              v-if="dog.breedName !== catalogue[index - 1]?.breedName || dog.categoryName !== catalogue[index - 1]?.categoryName"
              class="text-center"
            >
              {{ dog.breedName }}
            </h5>
            <div class="d-flex justify-content-between">
              <div>
                {{ dog.gender.toUpperCase() }}
              </div>
              <div>
                {{ dog.className }}
              </div>
            </div>
            <table class="textlight">
              <tr>
                <td style="width: 6%">
                  {{ dog.start_number }}
                </td>
                <td style="width: 55%">
                  {{ dog.name }}
                </td>
                <td>
                  {{ dog.registerSernum }}
                </td>
                <td class="text-right">
                  {{ dateFormatterWhiteSpace(dog.birthdate) }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  {{ dog.fatherName ? dog.fatherName : "-" }}/{{
                    dog.motherName ? dog.motherName : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  T:{{ dog.breederName ? dog.breederName : "-" }} t:{{
                    dog.ownerName
                  }}
                </td>
              </tr>
            </table>
          </div>
          <clip-loader
            :loading="loaderActive"
            :color="color"
            class="loader mt-4"
          ></clip-loader>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import { dateFormatterWhiteSpace } from "@/utils/helpers";

export default defineComponent({
  name: "CatalogueView",
  components: {
    ClipLoader,
  },

  data() {
    return {
      catalogue: [],
      selectedCatalogue: {},

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      color: "#000",
      dateFormatterWhiteSpace,
    };
  },

  async created() {
    await this.getCatalogues();
  },

  methods: {
    backToCatalogueSelection(): void {
      this.$router.push({
        path: "/catalogueList",
      });
    },
    getCatalogues(): void {
      this.loaderActive = true;
      axios
        .get(`http://localhost:8000/api/catalogues/${this.$route.params.id}`, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response, "list");
          this.catalogue = response.data.catalogue;
          this.selectedCatalogue = response.data.selectedCatalogue;
          this.loaderActive = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
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

.each-row {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #dfe1e5;
  padding: 5px;
  color: #909090;
}

.registered-dog {
  cursor: pointer;
}

.registered-dog:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
  cursor: pointer;
}

.icon-wrapper {
  color: black;
}

.related-dogs {
  border-bottom: 1px solid rgb(177, 175, 175);
  padding: 2px;
  width: 100%;
}

.related-dogs:hover {
  color: rgb(66, 77, 233);
}

.related-dogs-wrapper {
  margin-left: 20px;
}

.header {
  border-bottom: 1px solid black;
  margin-bottom: 10px;
  font-size: 23px;
}

a {
  margin: 0px;
}

.event-dropdown {
  padding: 5px;
  font-style: italic;
}

.event-dropdown:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
  cursor: pointer;
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
  margin: 15px 0px 15px 0px;
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

.no-events {
  text-align: center;
}

table {
  width: 100%;
}

.underline {
  border-bottom: 1px solid gray;
  padding-bottom: 10px;
}

.text-right {
  text-align: right;
}

.textlight {
  color: #909090;
}
</style>