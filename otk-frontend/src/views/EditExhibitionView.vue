<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1 class="d-flex">Kiállítás szerkesztése</h1>
          <div class="instruction text-secondary">
            Válassza ki a kiállítást amelyiket szerkeszteni szeretné!
          </div>
          <table>
            <tr class="header">
              <!-- <td class="text-center">
                <img :src="checkIcon" alt="info" width="20" height="20" />
              </td> -->
              <td class="text-center">Kiállítás neve</td>
              <td class="text-center">Dátum</td>
            </tr>
            <tr
              v-for="(exhibition, index) in this.exhibitions"
              :key="index"
              :class="[
                selectedExhibitionId === exhibition.id
                  ? 'each-entry related-dogs selected'
                  : 'each-entry related-dogs',
              ]"
              @click="select(exhibition.id)"
            >
              <td class="text-center">
                {{ exhibition.name }}
              </td>
              <td class="text-center">
                {{ dateFormatter(exhibition.date) }}
              </td>
            </tr>
          </table>
          <div
            v-if="!loaderActiveForList && !this.exhibitions.length"
            class="text-center m-4"
          >
            Jelenleg nincs Aktív esemény.
          </div>
          <div
            v-if="
              !loaderActiveForList &&
              !loaderActiveForExhibition &&
              !loaderActiveForRings &&
              selectedExhibitionId
            "
            class="mt-4"
          >
            <div class="each-row">
              <div>Név:</div>
              <div>
                {{ selectedExhibition.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Dátum:</div>
              <div>
                {{ dateFormatterWhiteSpace(selectedExhibition.date) }}
              </div>
            </div>
            <div class="each-row">
              <div>Nevezési határidő:</div>
              <div>
                {{ dateFormatterWhiteSpace(selectedExhibition.entry_deadline) }}
              </div>
            </div>
            <div class="each-row">
              <div>Kategóriák:</div>
              <div>
                <div
                  style="text-align: right"
                  v-for="event in selectedExhibitionCategories"
                  :key="event.id"
                >
                  {{ event.categoryType }}
                  <span v-if="event?.hobbyCategoryType">-</span>
                  {{ event?.hobbyCategoryType }}
                </div>
              </div>
            </div>
            <div class="each-row">
              <div>Ringek:</div>
              <clip-loader
                :loading="loaderActiveForRings || loaderActiveForNewRing"
                :color="color"
                class="loader"
              ></clip-loader>
              <div v-if="!loaderActiveForRings && !loaderActiveForNewRing">
                <div style="text-align: right">
                  <div class="d-flex justify-content-end new-ring" v-for="ring in rings" :key="ring.id">
                    <span @click="navigateToRingView(ring.id)">
                      {{ ring.name }} ({{ ring.registeredDogs.length }})
                    </span>
                    <span class="divider">&nbsp;|&nbsp;</span>
                    <UniversalModal
                      class="delete-ring"
                      :dialogOptions="deleteConfirmDialogOptions"
                      @confirm="onDeleteConfirm(ring.id)"
                    />
                  </div>
                  <div class="d-flex new-ring pointer" @click="addNewRing()">
                    <img
                      style="margin-right: 5px"
                      :src="addIcon"
                      alt="info"
                      width="20"
                      height="20"
                    />
                    <div>Új ring hozzáadása</div>
                  </div>
                </div>
              </div>
            </div>
          <button v-if="!selectedExhibition.added_to_homepage" class="save-button" @click="putExhibitionToHomePage(true)">
            Esemény megjelenítése a főoldalon!
          </button>
          <button v-if="selectedExhibition.added_to_homepage" class="reject-button" @click="putExhibitionToHomePage(false)">
            Esemény törlése a főoldalról!
          </button>
          </div>
          <clip-loader
            :loading="
              loaderActiveForList ||
              loaderActiveForExhibition ||
              loaderActiveForRings
            "
            :color="color"
            class="loader"
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
import checkIcon from "../assets/card-checklist.svg";
import addIcon from "../assets/plus-circle.svg";
import { dateFormatterWhiteSpace, dateFormatter } from "@/utils/helpers";
import UniversalModal from "@/components/UniversalModal.vue";

export default defineComponent({
  name: "CreateCatalogueView",
  components: { ClipLoader, UniversalModal },

  data() {
    return {
      deleteConfirmDialogOptions: {
        value: "Törlés",
        title: "Biztosan törölni akarja?",
        confirmButton: "Törlés!",
        cancelButton: "Mégsem",
      },
      catalogueName: "",
      deleteSuccessMessage: "",
      exhibitions: [],
      selectedExhibition: {
        added_to_homepage: false,
      },
      selectedExhibitionCategories: [],
      rings: [],
      selectedExhibitionId: null as null | number,
      loaderActiveForList: false,
      loaderActiveForRings: false,
      loaderActiveForNewRing: false,
      loaderActiveForExhibition: false,
      loaderActive: false,
      color: "#000",
      errorMessage: "",
      successMessage: "",
      checkIcon,
      dateFormatter,
      dateFormatterWhiteSpace,
      addIcon,
    };
  },

  async created() {
    this.getActiveExhibitions();
    if (this.$route.params.selectedExhibitionId) {
      this.selectedExhibitionId = parseInt(
        this.$route.params.selectedExhibitionId as string
      );
      this.select(this.selectedExhibitionId);
    }
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
  },

  methods: {
    putExhibitionToHomePage(addToHomepage: boolean): void {
      const data = JSON.stringify({
        exhibition_id: this.selectedExhibitionId,
        added_to_homepage: addToHomepage,
      });
      axios
        .post("http://localhost:8000/api/exhibitions/addExhibitionToHomePage", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          this.selectedExhibition.added_to_homepage = response.data;

        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
        });
    },

    onDeleteConfirm(ringId: number): void {
      this.loaderActiveForNewRing = true;
      axios
        .delete(`http://localhost:8000/api/rings/deleteRingById/${ringId}`, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          this.getRingsByExhibitionId(true);
          console.log(response);
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForNewRing = false;
        });
    },

    navigateToRingView(ringId: number): void {
      this.$router.push({
        path: "exhibition/" + this.selectedExhibitionId + "/ring/" + ringId,
      });
    },

    select(id: number): void {
      this.selectedExhibitionId = id;
      this.getExhibitionById(id);
      this.getRingsByExhibitionId();
    },

    addNewRing(): void {
      this.loaderActiveForNewRing = true;
      const data = JSON.stringify({
        name: this.rings.length + 1 + ". ring",
        exhibition_id: this.selectedExhibitionId,
      });
      axios
        .post("http://localhost:8000/api/rings/create", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          this.getRingsByExhibitionId(true);
          console.log(response);
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForNewRing = false;
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

    getExhibitionById(exhibitionId: number): void {
      this.loaderActiveForExhibition = true;
      const data = JSON.stringify({
        exhibition_id: exhibitionId,
      });
      axios
        .post("http://localhost:8000/api/exhibitions/getExhibitionById", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          this.selectedExhibition = response.data.exhibition;
          this.selectedExhibitionCategories = response.data.categories;
          console.log(response);
          this.loaderActiveForExhibition = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForExhibition = false;
        });
    },

    getRingsByExhibitionId(shouldHideLoader?: boolean): void {
      if (!shouldHideLoader) {
        this.loaderActiveForRings = true;
      }

      const data = JSON.stringify({
        exhibition_id: this.selectedExhibitionId,
      });
      axios
        .post("http://localhost:8000/api/rings/getRingsByExhibitionId", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          this.rings = response.data;
          this.loaderActiveForRings = false;
          this.loaderActiveForNewRing = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForRings = false;
          this.loaderActiveForNewRing = false;
        });
    },
  },
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
.reject-button {
  margin: 20px 0px 10px 0px;
  background: #e94f4f;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}

.reject-button:hover {
  background: linear-gradient(45deg, rgb(255, 47, 47), dodgerblue);
}

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

.selected {
  color: rgb(66, 77, 233);
  background-color: #efeff1;
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

.new-ring {
  color: #0094ff;
}

.new-ring span {
  cursor: pointer;
}

.delete-ring {
  color: #e94f4f;
  cursor: pointer;
}

.divider {
  color: #909090;
}

.pointer{
  cursor: pointer;
}
</style>