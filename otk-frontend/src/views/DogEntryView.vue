<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Nevezés</h1>
          <div
            v-if="
              isEventSelected ||
              (!isEventSelected && isDogSelected && !isRegistrationClicked)
            "
          >
            <div class="text-center">Kiállítás adatai</div>
            <div class="each-row">
              <div>Kiállítás neve:</div>
              <div>
                {{ selectedEvent.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Kategória:</div>
              <div>
                {{ selectedEvent.categoryType }} <span v-if="selectedEvent?.hobbyCategoryType">-</span> {{ selectedEvent?.hobbyCategoryType }}
              </div>
            </div>
          </div>
          <div v-if="isDogSelected && !isRegistrationClicked">
            <div class="text-center">Kutya adatai</div>
            <div class="each-row">
              <div>Név:</div>
              <div>
                {{ selectedDog.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Fajta:</div>
              <div>
                {{ selectedDog.breed }}
              </div>
            </div>
          </div>
          <div v-if="isClassSelected && !isRegistrationClicked">
            <div class="text-center">kiválasztott osztály</div>
            <div class="each-row">
              <div>Osztály típusa:</div>
              <div>
                {{ selectedPossibleClass.type }}
              </div>
            </div>
          </div>
          <div
            class="inner-center"
            v-if="!isEventSelected && !isClassSelected && !isDogSelected"
          >
            <h4>Aktív kiállítások</h4>
            <div class="instruction">
              Válassza ki a kiállítást amelyikre nevezni szeretne!
            </div>
            <table>
              <tr class="header">
                <td class="text-center">Kiállítás neve</td>
                <td class="text-center">Kategória</td>
                <td class="text-center">Nevezési határidő</td>
              </tr>
              <tr
                v-for="(event, index) in activeEvents"
                :key="index"
                class="each-entry related-dogs"
                @click="GoToSelectDogView(event)"
              >
                <td class="text-center">
                  {{ event.name }}
                </td>
                <td class="text-center">
                  {{ event.categoryType }} <span v-if="event?.hobbyCategoryType">-</span> {{ event?.hobbyCategoryType }}
                </td>
                <td class="text-center">
                  {{ dateFormatter(event.entry_deadline) }}
                </td>
              </tr>
            </table>
            <div
              v-if="!activeEvents.length && !loaderActiveForList"
              class="no-dogs text-center p-4"
            >
              Jelenleg nincs egy aktív esemény sem.
            </div>
          </div>
          <clip-loader
            :loading="loaderActiveForList"
            :color="color"
            class="loader"
          ></clip-loader>

          <div class="inner-center" v-if="isEventSelected">
            <h4>Kutya kiválasztása</h4>
            <div class="instruction">Válassza ki a nevezni kívánt kutyát!</div>
            <div v-if="!loaderActiveForDogs">
              <table>
                <tr class="header">
                  <td class="text-center">Kutya neve</td>
                  <td class="text-center">Fajta</td>
                  <td class="text-center">létrehozás időpontja</td>
                </tr>
                <tr
                  v-for="dog in myPossibleDogs"
                  :key="dog.id"
                  class="each-entry related-dogs"
                  @click="goToSelectClassView(dog)"
                >
                  <td class="text-center">
                    {{ dog.name }}
                  </td>
                  <td class="text-center">
                    {{ dog.breed }}
                  </td>
                  <td class="text-center">{{ dateFormatter(dog.created_at) }}</td>
                </tr>
              </table>
              <div
                v-if="!Object.keys(myPossibleDogs).length && !loaderActiveForDogs"
                class="no-dogs text-center p-4"
              >
                Jelenleg nincs nevezésre alkalmas kutyája ehhez az eseményhez.
              </div>
              <button class="back-button" @click="backToEventSelection">
                Vissza!
              </button>
            </div>
            <clip-loader
              :loading="loaderActiveForDogs"
              :color="color"
              class="loader"
            ></clip-loader>
          </div>

          <div class="inner-center" v-if="isDogSelected && !isClassSelected">
            <h4>Osztály kiválasztása</h4>
            <div class="instruction">
              Válassza ki a nevezni kívánt kutya osztályát!
            </div>
            <table v-if="!loaderActiveForClasses">
              <tr class="header">
                <td class="text-center">Elérhető osztályok a kutya számára</td>
              </tr>
              <div
                v-if="!Object.keys(myPossibleClasses).length && !loaderActiveForClasses"
                class="no-dogs text-center p-4"
              >
                Jelenleg nincs Elérhető osztály a kutya számára.
              </div>
              <tr
                v-for="possibleClass in myPossibleClasses"
                :key="possibleClass.id"
                class="each-entry related-dogs"
              >
                <td
                  class="text-center"
                  @click="GoToRegistrationLoadingView(possibleClass)"
                >
                  {{ possibleClass.type }}
                </td>
              </tr>
            </table>
            <clip-loader
              :loading="loaderActiveForClasses"
              :color="color"
              class="loader"
            ></clip-loader>
            <button class="back-button" @click="backToEventDogSelection">
              Vissza!
            </button>
          </div>

          <div class="inner-center" v-if="isClassSelected">
            <div v-if="!loaderActiveForRegister">
              <h4 v-if="successMessage !== ''" class="success text-center">
                {{ successMessage }}
              </h4>
              <h4 v-if="errorMessage !== ''" class="error text-center">
                {{ errorMessage }}
              </h4>
              <div class="flex-buttons">
                <button
                  class="back-button"
                  @click="
                    isRegistrationClicked
                      ? backToStart()
                      : backToClassSelection()
                  "
                >
                  Vissza!
                </button>
                <input
                  v-if="!isRegistrationClicked"
                  type="button"
                  value="Nevezés leadása!"
                  class="save-button"
                  @click="registerDogToEvent(selectedPossibleClass.id)"
                />
              </div>
            </div>
            <clip-loader
              :loading="loaderActiveForRegister"
              :color="color"
              class="loader"
            ></clip-loader>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent } from "vue";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import { actualCategory, dateFormatter } from "@/utils/helpers";
import { Event } from "@/types/types";
import { Dog } from "../types/types";

export default defineComponent({
  name: "DogEntryView",
  components: { ClipLoader },
  data() {
    return {
      activeEvents: [],
      myPossibleDogs: [],
      myPossibleClasses: [],
      selectedEvent: {} as Event,
      selectedDog: {} as Dog,
      selectedPossibleClass: "",

      errorMessage: "",
      successMessage: "",
      loaderActiveForList: false,
      loaderActiveForDogs: false,
      loaderActiveForRegister: false,
      loaderActiveForClasses: false,
      color: "#000",
      isEventSelected: false,
      isClassSelected: false,
      isDogSelected: false,
      isRegistrationClicked: false,

      registerConfirmDialogOptions: {
        value: "Kutya nevezése",
        title: "Biztos, hogy az alábbi kutyát nevezni akarja?",
        confirmButton: "Nevezés!",
        cancelButton: "Mégsem",
      },
      actualCategory,
      dateFormatter,
    };
  },

  async created() {
    this.getActiveEvents();
    await this.$store.dispatch("setCategories");
  },

  methods: {
    goToSelectClassView(dog: Dog): void {
      this.isEventSelected = false;
      this.isDogSelected = true;
      this.selectedDog = dog;
      this.getPossibleClasses();
    },

    backToStart(): void {
      this.isEventSelected = false;
      this.isClassSelected = false;
      this.isDogSelected = false;
      this.isRegistrationClicked = false;
      this.successMessage = "";
      this.errorMessage = "";
    },

    backToClassSelection(): void {
      this.isClassSelected = false;
    },

    GoToRegistrationLoadingView(possibleClass: any) {
      this.isEventSelected = false;
      this.isClassSelected = true;
      this.selectedPossibleClass = possibleClass;
    },
    GoToSelectDogView(event: Event) {
      this.isEventSelected = true;
      this.selectedEvent = event;
      this.getMyDogs();
    },

    backToEventSelection(): void {
      this.isEventSelected = false;
      this.getActiveEvents();
    },

    backToEventDogSelection(): void {
      this.isDogSelected = false;
      this.isEventSelected = true;
      this.getMyDogs();
    },

    registerDogToEvent(classId: number) {
      this.isRegistrationClicked = true;
      this.loaderActiveForRegister = true;
      this.successMessage = "";
      this.errorMessage = "";
      const registeredDogData = JSON.stringify({
        dog_id: this.selectedDog.id,
        event_id: this.selectedEvent.id,
        dog_class_id: classId,
      });
      axios
        .post(
          "http://localhost:8000/api/registeredDogs/store",
          registeredDogData,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "respo");
          if (response.status === 201) {
            this.successMessage = "Sikeres nevezés!";
          }
          this.loaderActiveForRegister = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else {
            this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForRegister = false;
        });
    },

    getMyDogs(): void {
      this.loaderActiveForDogs = true;
      axios
        .get(
          `http://localhost:8000/api/mydogs/possibleEntriesForEvent/${this.selectedEvent.id}`,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "POSSIBLE DOGS");
          this.myPossibleDogs = response.data;
          this.loaderActiveForDogs = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForDogs = false;
        });
    },

    getPossibleClasses(): void {
      this.loaderActiveForClasses = true;
      axios
        .get(
          `http://localhost:8000/api/mydogs/possibleEntriesForEvent/${this.selectedEvent.id}/possibleClasses/${this.selectedDog.id}`,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "POSSIBLE CLASSES");
          this.myPossibleClasses = response.data;
          this.loaderActiveForClasses = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForClasses = false;
        });
    },

    getActiveEvents(): void {
      this.errorMessage = "";
      this.activeEvents = [];
      this.loaderActiveForList = true;
      axios
        .get("http://localhost:8000/api/events/getActiveEventsWithDeadlines", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response, "ev");
          this.activeEvents = response.data;
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

.loader {
  margin-top: 30px;
}

.dog {
  background-color: aliceblue;
  padding: 5px 10px;
  border-radius: 5px;
  margin: 5px;
}

.dog:hover {
  background-color: rgb(226, 239, 250);
  cursor: pointer;
}

.event {
  background-color: aliceblue;
  padding: 5px 10px;
  border-radius: 5px;
  margin: 5px;
}

.event:hover {
  background-color: rgb(226, 239, 250);
  cursor: pointer;
}

h4,
.instruction {
  text-align: right;
}

.instruction {
  color: rgb(180, 180, 180);
  font-size: 14px;
  margin-bottom: 30px;
}

.error {
  color: red;
  margin: auto;
}

.wrapper {
  width: 80%;
}
.success {
  color: green;
  margin: auto;
}

.info-container {
  width: 80%;
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

.save-button {
  margin: 20px 0px 10px 0px;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}

.save-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

/* TABLE */

.loader-for-data {
  margin-top: 30px;
}

.related-dogs {
  padding: 2px;
  width: 100%;
}

.related-dogs:hover {
  color: rgb(66, 77, 233);
}

table {
  width: 100%;
}

td {
  padding: 10px;
}

.each-entry:hover {
  cursor: pointer;
  background-color: #efeff1;
}

.header {
  border-bottom: 1px solid rgb(212, 209, 209);
}

.each-row {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #dfe1e5;
  padding: 5px;
  color: #909090;
}

.each-row:last-child {
  margin-bottom: 30px;
}

.flex-buttons {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>