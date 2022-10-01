<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <div class="d-flex justify-content-between">
            <h1 v-if="!isUserLoggedIn">Ring szerkesztése</h1>
            <h1 v-else>Ring adatai</h1>
            <button class="back-button" @click="backToeditExhibitionView()">
              Vissza!
            </button>
          </div>
          <div v-if="!loaderActiveForGetRingName && !loaderActiveForExhibition">
            <div class="each-row">
              <div>Kiállítás neve:</div>
              <div>
                {{ selectedExhibition.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Kiválasztott ring neve:</div>
              <div>{{ selectedRing.name }}</div>
            </div>
            <div class="instruction text-center mt-5">
              A ringbe eddig beosztott kutyák listája
            </div>
          </div>
          <clip-loader
            :loading="loaderActiveForGetRingName || loaderActiveForExhibition"
            :color="color"
            class="loader"
          ></clip-loader>
          <table>
            <tr class="header">
              <td class="text-center" v-if="!isUserLoggedIn">
                <img :src="checkIcon" alt="info" width="20" height="20" />
              </td>
              <td class="text-center">Rajtszám</td>
              <td class="text-center">Nem</td>
              <td class="text-center">Fajta</td>
              <td class="text-center">Kategória</td>
              <td class="text-center">Osztály</td>
            </tr>
            <tr
              v-for="(addedDog, index) in this.addedDogs"
              :key="index"
              class="each-entry related-dogs"
            >
              <td class="text-center" v-if="!isUserLoggedIn">
                <input type="checkbox" v-model="dogsToRemove[addedDog.id]" />
              </td>
              <td class="text-center">
                {{ addedDog.start_number }}
              </td>
              <td class="text-center">
                {{ addedDog.gender }}
              </td>
              <td class="text-center">
                {{ addedDog.breedName }}
              </td>
              <td class="text-center">
                {{ addedDog.categoryType }}
                <span v-if="addedDog?.hobbyCategoryType">-</span>
                {{ addedDog?.hobbyCategoryType }}
              </td>
              <td class="text-center">
                {{ addedDog.classType }}
              </td>
            </tr>
          </table>
          <div
            v-if="!loaderActiveForList && !this.addedDogs.length"
            class="text-center m-4"
          >
            Még nincs egyetlen hozzáadott kutya sem.
          </div>
          <clip-loader
            :loading="loaderActiveForList"
            :color="color"
            class="loader"
          ></clip-loader>
          <div
            class="inputbox flex"
            v-if="!loaderActiveForList && this.addedDogs.length && !isUserLoggedIn"
          >
            <button
              class="reject-button mr-4"
              :disabled="loaderActiveForRemove"
              @click="removeDogsFromRing()"
            >
              Kijelölt elemek Törlése!
            </button>
            <div class="d-flex align-items-center">
              <clip-loader
                :loading="loaderActiveForRemove"
                :color="color"
              ></clip-loader>
            </div>
          </div>
          <div v-if="!isUserLoggedIn" class="instruction text-center mt-5">
            Még be nem osztott kutyák listája
          </div>
          <table v-if="!isUserLoggedIn">
            <tr class="header">
              <td class="text-center">
                <img :src="checkIcon" alt="info" width="20" height="20" />
              </td>
              <td class="text-center">Rajtszám</td>
              <td class="text-center">Nem</td>
              <td class="text-center">Fajta</td>
              <td class="text-center">Kategória</td>
              <td class="text-center">Osztály</td>
            </tr>
            <tr
              v-for="(possibleDog, index) in this.possibleDogs"
              :key="index"
              class="each-entry related-dogs"
            >
              <td class="text-center">
                <input type="checkbox" v-model="selectedDogs[possibleDog.id]" />
              </td>
              <td class="text-center">
                {{ possibleDog.start_number }}
              </td>
              <td class="text-center">
                {{ possibleDog.gender }}
              </td>
              <td class="text-center">
                {{ possibleDog.breedName }}
              </td>
              <td class="text-center">
                {{ possibleDog.categoryType }}
                <span v-if="possibleDog?.hobbyCategoryType">-</span>
                {{ possibleDog?.hobbyCategoryType }}
              </td>
              <td class="text-center">
                {{ possibleDog.classType }}
              </td>
            </tr>
          </table>
          <clip-loader
            :loading="loaderActiveForPossibleDogs"
            :color="color"
            class="loader"
          ></clip-loader>
          <div
            v-if="!loaderActiveForPossibleDogs && !this.possibleDogs.length && !isUserLoggedIn"
            class="text-center m-4"
          >
            Nincs több beosztható kutya!
          </div>
          <div
            class="inputbox flex"
            v-if="!loaderActiveForPossibleDogs && this.possibleDogs.length && !isUserLoggedIn"
          >
            <button
              class="save-button"
              :disabled="loaderActiveForAdd"
              @click="addDogsToRing()"
            >
              Kijelölt elemek hozzáadása!
            </button>
            <div class="d-flex align-items-center">
              <clip-loader
                :loading="loaderActiveForAdd"
                :color="color"
              ></clip-loader>
            </div>
            <div v-if="errorMessage" class="error">
              {{ errorMessage }}
            </div>
            <div v-if="successMessage" class="success">
              {{ successMessage }}
            </div>
          </div>
          <div v-if="selectedExhibition.added_to_homepage && !isUserLoggedIn">
            <div class="dog-in-ring header text-center">
              Kutya megjelenítése a ringben
            </div>
            <div class="rings-container">
              <button
                v-if="actualDog.length"
                class="next-button"
                @click="sendDogChangeEvent(false)"
              >
                Előző
              </button>
              <div class="bg-gray">
                <div v-if="actualDog.length && !loaderActiveForDogChange">
                  <h2 class="text-center">{{ selectedRing.name }}</h2>
                  <div class="ring-row">
                    <div>Rajtszám:</div>
                    <div>{{ actualDog[0].start_number }}</div>
                  </div>
                  <div class="ring-row">
                    <div>Nem:</div>
                    <div>{{ actualDog[0].gender }}</div>
                  </div>
                  <div class="ring-row">
                    <div>Fajta:</div>
                    <div>{{ actualDog[0].breedName }}</div>
                  </div>
                  <div class="ring-row">
                    <div>Kategória:</div>
                    <div>
                      {{ actualDog[0].categoryType }}
                      <span v-if="actualDog[0]?.hobbyCategoryType">-</span>
                      {{ actualDog[0]?.hobbyCategoryType }}
                    </div>
                  </div>
                  <div class="ring-row">
                    <div>Osztály:</div>
                    <div>{{ actualDog[0].classType }}</div>
                  </div>
                </div>
                <div
                  v-if="loaderActiveForDogChange"
                  class="d-flex align-items-center justify-content-center"
                  style="min-height: 166px"
                >
                  <clip-loader :color="color"></clip-loader>
                </div>
                <div
                  v-if="!loaderActiveForDogChange && !actualDog.length"
                  class="d-flex align-items-center justify-content-center"
                  style="height: 170px"
                >
                  <button class="next-button" @click="sendDogChangeEvent(true)">
                    Kezdés!
                  </button>
                </div>
              </div>
              <button
                v-if="actualDog.length"
                class="next-button"
                @click="sendDogChangeEvent(true)"
              >
                Következő
              </button>
            </div>
            <div
              v-if="actualDog.length"
              class="d-flex align-items-center justify-content-center"
            >
              <button
                class="next-button"
                @click="sendDogChangeEvent(true, true)"
              >
                Tábla törlése!
              </button>
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
import addIcon from "../assets/plus-circle.svg";
import { dateFormatterWhiteSpace, dateFormatter } from "@/utils/helpers";

export default defineComponent({
  name: "CreateCatalogueView",
  components: { ClipLoader },

  data() {
    return {
      catalogueName: "",
      deleteSuccessMessage: "",
      selectedExhibition: {},
      selectedExhibitionCategories: [],
      selectedDogs: [],
      dogsToRemove: [],
      addedDogs: [],
      actualDog: [],
      selectedRing: {},
      possibleDogs: [],
      loaderActiveForList: false,
      loaderActiveForRings: false,
      loaderActiveForPossibleDogs: false,
      loaderActiveForAdd: false,
      loaderActiveForGetRingName: false,
      loaderActiveForExhibition: false,
      loaderActiveForRemove: false,
      loaderActiveForDogChange: false,
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
    this.getExhibitionById(
      parseInt(this.$route.params.exhibition_id as string)
    );
    this.getRingById();
    this.getDogsForRingById();
    if(!this.isUserLoggedIn){
      this.getSelectedDogInRing();
      this.getPossibleDogsForRing();
    }
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
    isUserLoggedIn(): boolean {
      return this.$store.getters.isUserLoggedIn;
    },
  },

  methods: {
    getSelectedDogInRing(): void {
      this.loaderActiveForDogChange = true;
      const data = JSON.stringify({
        ring_id: this.$route.params.ring_id,
      });
      axios
        .post("http://localhost:8000/api/rings/getSelectedDogInRing", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response, "selectedDogInRing");
          this.actualDog = response.data;
          this.loaderActiveForDogChange = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForDogChange = false;
        });
    },

    sendDogChangeEvent(moveToNext: boolean, unselect?: boolean): void {
      const data = JSON.stringify({
        ring_id: this.$route.params.ring_id,
        move_to_next: moveToNext,
        unselect: unselect ? unselect : null,
      });
      axios
        .post("http://localhost:8000/api/rings/moveToNext", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response, "DONE");
          this.getSelectedDogInRing();
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

    backToeditExhibitionView(): void {
      this.$router.push({
        name: "EditExhibitionView",
        params: { selectedExhibitionId: this.$route.params.exhibition_id },
      });
    },

    getDogsForRingById() {
      this.loaderActiveForList = true;
      axios
        .get(
          `http://localhost:8000/api/rings/getDogsForRingById/${this.$route.params.ring_id}`,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "got_dogs");
          this.addedDogs = response.data;
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

    removeDogsFromRing(): void {
      if (!this.getCheckedIdsToRemove().length) {
        return;
      }
      this.loaderActiveForRemove = true;
      const data = JSON.stringify({
        dog_ids: this.getCheckedIdsToRemove(),
        ring_id: this.$route.params.ring_id,
      });
      this.selectedDogs = [];
      this.dogsToRemove = [];
      axios
        .post("http://localhost:8000/api/rings/removeDogsFromRing", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response, "added");
          this.getDogsForRingById();
          this.getPossibleDogsForRing();
          this.loaderActiveForRemove = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForRemove = false;
        });
    },

    addDogsToRing(): void {
      if (!this.getCheckedDogIds().length) {
        return;
      }
      this.loaderActiveForAdd = true;
      const data = JSON.stringify({
        exhibition_id: this.$route.params.exhibition_id,
        dog_ids: this.getCheckedDogIds(),
        ring_id: this.$route.params.ring_id,
      });
      this.selectedDogs = [];
      this.dogsToRemove = [];
      axios
        .post("http://localhost:8000/api/rings/addSelectedDogsToRing", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response, "added");
          this.getDogsForRingById();
          this.getPossibleDogsForRing();
          this.loaderActiveForAdd = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForAdd = false;
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

    getRingById(): void {
      this.loaderActiveForGetRingName = true;
      axios
        .get(
          `http://localhost:8000/api/rings/getRingById/${this.$route.params.ring_id}`,
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
          this.selectedRing = response.data;
          this.loaderActiveForGetRingName = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForGetRingName = false;
        });
    },

    getPossibleDogsForRing(): void {
      this.loaderActiveForPossibleDogs = true;
      axios
        .get(
          `http://localhost:8000/api/exhibitions/${this.$route.params.exhibition_id}/rings/${this.$route.params.ring_id}/getpossibleDogsForRing`,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "possible_dogs");
          this.possibleDogs = response.data;

          this.loaderActiveForPossibleDogs = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForPossibleDogs = false;
        });
    },

    getCheckedDogIds(): number[] {
      const checkedIds = [];
      for (let i = 0; i < this.selectedDogs.length; i++) {
        if (this.selectedDogs[i]) {
          checkedIds.push(i);
        }
      }
      return checkedIds;
    },
    getCheckedIdsToRemove(): number[] {
      const checkedIds = [];
      for (let i = 0; i < this.dogsToRemove.length; i++) {
        if (this.dogsToRemove[i]) {
          checkedIds.push(i);
        }
      }
      return checkedIds;
    },
  },
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
.dog-in-ring {
  margin-top: 100px;
  border-bottom: 1px solid gray;
  padding: 10px;
  margin-bottom: 20px;
  color: #0094ff;
}

.next-button {
  height: 45px;
  width: 120px;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
}

.next-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.bg-gray {
  background-color: #dddddd;
  border-radius: 10px;
  width: 40%;
  min-width: 250px;
  padding: 20px;
  margin: 20px;
  min-height: 210px;
}

.rings-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  align-items: center;
}

.ring-row {
  display: flex;
  justify-content: space-between;
  text-align: center;
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
  text-align: left;
  margin-bottom: 20px;
  margin-top: 20px;
  color: #0094ff;
}

[type="checkbox"] {
  width: 20px;
  height: 20px;
  cursor: pointer;
}

.new-ring {
  cursor: pointer;
  color: #0094ff;
}

.reject-button {
  margin: 20px 0px 10px 0px;
  min-width: 50%;
  background: #e94f4f;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}

.reject-button:hover {
  background: linear-gradient(45deg, rgb(255, 47, 47), dodgerblue);
}
</style>