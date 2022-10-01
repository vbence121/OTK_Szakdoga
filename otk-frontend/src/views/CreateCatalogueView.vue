<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1 class="d-flex">Katalógus készítése</h1>
          <div class="instruction text-secondary">
            Válassza ki a kiállítást amelyikhez katalógust szeretne
            összeállítani!
          </div>
          <table>
            <tr class="header">
              <td class="text-center">
                <img :src="checkIcon" alt="info" width="20" height="20" />
              </td>
              <td class="text-center">Kiállítás neve</td>
              <td class="text-center">Dátum</td>
            </tr>
            <tr
              v-for="(exhibition, index) in this.exhibitions"
              :key="index"
              class="each-entry related-dogs"
            >
              <td class="text-center">
                <input
                  type="checkbox"
                  :value="exhibition.id"
                  :id="exhibition.id"
                  v-model="checkboxes"
                  @change="select(exhibition.id)"
                />
              </td>
              <td class="text-center">
                {{ exhibition.name }}
              </td>
              <td class="text-center">
                {{ dateFormatter(exhibition.date) }}
              </td>
            </tr>
          </table>
          <div
            class="inputbox"
            v-if="
              !loaderActiveForList &&
              this.exhibitions.length
            "
          >
            <div>Katalógus neve</div>
            <input type="text" v-model="catalogueName" />
          </div>
          <div
            v-if="
              !loaderActiveForList &&
              !this.exhibitions.length
            "
            class="text-center m-4"
          >
            Jelenleg nincs Aktív esemény.
          </div>
          <clip-loader
            :loading="loaderActiveForList"
            :color="color"
            class="loader"
          ></clip-loader>
          <div class="inputbox flex">
            <button class="save-button" @click="generateCatalogue()">
              Mehet!
            </button>
            <div class="d-flex align-items-center">
              <clip-loader :loading="loaderActive" :color="color"></clip-loader>
            </div>
            <div v-if="errorMessage" class="error">
              {{ errorMessage }}
            </div>
            <div v-if="successMessage" class="success">
              {{ successMessage }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import checkIcon from "../assets/card-checklist.svg";
import { dateFormatter } from "@/utils/helpers";

export default defineComponent({
  name: "CreateCatalogueView",
  components: { ClipLoader },

  data() {
    return {
      catalogueName: "",
      deleteSuccessMessage: "",
      exhibitions: [],
      checkboxes: [],
      selectedExhibitionId: null as null | number,
      loaderActiveForList: false,
      loaderActive: false,
      color: "#000",
      errorMessage: "",
      successMessage: "",
      checkIcon,
      dateFormatter,
    };
  },

  async created() {
    this.getActiveExhibitions();
    await this.$store.dispatch("setCategories");
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
  },

  methods: {
    navigateToEventView(eventId: number): void {
      this.$store.dispatch("setLastOpenedEventId", {
        id: eventId,
      });
      this.$router.push({
        path: "/eventCategory/" + eventId,
      });
    },

    select(id: number): void {
      this.checkboxes = this.checkboxes.filter(checkbox => checkbox === id)
      this.selectedExhibitionId = id;
    },

    generateCatalogue() {
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      const eventData = JSON.stringify({
        name: this.catalogueName,
        selectedExhibitionId: this.selectedExhibitionId
      });
      axios
        .post(
          "http://localhost:8000/api/registeredDogs/generateCatalogue",
          eventData,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response);
          if (response.status === 200) {
            this.successMessage = "Sikeresen létrehozva!";
            this.$router.push({
              name: "CatalogueListView",
              params: { successMessage: "Sikeres létrehozás!" },
            });
          }
          this.loaderActive = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          this.errorMessage = "Hibás adatok!";
          console.error("There was an error!", error);
          this.loaderActive = false;
        });
    },

    getActiveExhibitions(): void {
      this.loaderActiveForList = true;
      axios
        .get("http://localhost:8000/api/exhibitions/getAll", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          this.exhibitions = response.data;
          console.log(response);
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
    },
  },
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
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
.inputbox {
  width: 300px;
  margin-bottom: 25px;
  margin-top: 25px;
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
}
.inputbox:last-child {
  margin-bottom: 0;
}
.inputbox span {
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
.inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.inputbox:hover [type="button"] {
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
  margin: 20px 20px 20px 0px;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px 20px;
}

.save-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

/* DROPDOWN */

.dropdown-check-list {
  display: inline-block;
}

.dropdown-check-list .anchor {
  position: relative;
  cursor: pointer;
  display: inline-block;
  padding: 5px 50px 5px 10px;
  border: 1px solid #ccc;
}

.dropdown-check-list .anchor:after {
  position: absolute;
  content: "";
  border-left: 2px solid black;
  border-top: 2px solid black;
  padding: 5px;
  right: 10px;
  top: 20%;
  -moz-transform: rotate(-135deg);
  -ms-transform: rotate(-135deg);
  -o-transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
  transform: rotate(-135deg);
}

.dropdown-check-list .anchor:active:after {
  right: 8px;
  top: 21%;
}

.dropdown-check-list ul.items {
  padding: 2px;
  display: none;
  margin: 0;
  border: 1px solid #ccc;
  border-top: none;
}

.dropdown-check-list ul.items li {
  list-style: none;
}

.dropdown-check-list.visible .anchor {
  color: #0094ff;
}

.dropdown-check-list.visible .items {
  display: block;
}

h4,
.instruction {
  text-align: right;
  margin-bottom: 20px;
}

[type="checkbox"] {
  width: 20px;
  height: 20px;
  cursor: pointer;
}
</style>