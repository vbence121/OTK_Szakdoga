<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Nevezés</h1>
          <div
            class="inner-center"
            v-if="!isEventSelected && !isRegistrationClicked"
          >
            <h4>Aktív kiállítások</h4>
            <div class="instruction">
              Válassza ki a kiállítást amelyikre nevezni szeretne!
            </div>
            <div
              v-if="!activeEvents.length && !loaderActiveForList"
              class="no-dogs"
            >
              Jelenleg nincs egy aktív esemény sem.
            </div>
            <div
              v-for="(event, index) in activeEvents"
              :key="event.id"
              class="list-group-item align-content-center"
              @click="GoToSelectDogView(event.id)"
            >
              <div
                class="
                  d-flex
                  justify-content-between
                  align-content-center
                  event
                "
              >
                <span>{{ index + 1 }}.</span>
                <span>{{ event.name }}</span>
              </div>
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
              <div
                v-for="(dog, index) in myDogs"
                :key="dog.id"
                class="list-group-item align-content-center"
              >
                <RegisterDogConfirmDialog
                  class="
                    d-flex
                    justify-content-between
                    align-content-center
                    dog
                  "
                  :dialogOptions="registerConfirmDialogOptions"
                  :index="index"
                  :name="dog.name"
                  :breed="dog.breed"
                  @confirm="GoToRegistrationLoadingView(dog.id)"
                />
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

          <div class="inner-center" v-if="isRegistrationClicked">
            <!-- <div class="instruction">Válassza ki a nevezni kívánt kutyát!</div> -->
            <div v-if="!loaderActiveForRegister">
              <h4 v-if="successMessage !== ''" class="success">{{ successMessage }}</h4>
              <h4 v-if="errorMessage !== ''" class="error">{{ errorMessage }}</h4>
              <button class="back-button" @click="backToStart">Vissza!</button>
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
import RegisterDogConfirmDialog from "@/components/RegisterDogConfirmDialog.vue";

export default defineComponent({
  name: "DogEntryView",
  components: { ClipLoader, RegisterDogConfirmDialog },
  data() {
    return {
      activeEvents: [],
      myDogs: [],
      selectedEventId: -1,

      errorMessage: "",
      successMessage: "",
      loaderActiveForList: false,
      loaderActiveForDogs: false,
      loaderActiveForRegister: false,
      color: "#000",
      isEventSelected: false,
      isRegistrationClicked: false,

      registerConfirmDialogOptions: {
        value: "Kutya nevezése",
        title: "Biztos, hogy az alábbi kutyát nevezni akarja?",
        confirmButton: "Nevezés!",
        cancelButton: "Mégsem",
      },
    };
  },

  created() {
    this.getActiveEvents();
  },

  methods: {
    backToStart(): void {
      this.isEventSelected = false;
      this.isRegistrationClicked = false;
    },

    GoToRegistrationLoadingView(dogId: number) {
      this.isEventSelected = false;
      this.isRegistrationClicked = true;
      this.registerDogToEvent(dogId);
    },
    GoToSelectDogView(id: number) {
      this.isEventSelected = true;
      this.selectedEventId = id;
      this.getMyDogs();
    },

    backToEventSelection(): void {
      this.isEventSelected = false;
      this.getActiveEvents();
    },

    registerDogToEvent(dogId: number) {
      this.loaderActiveForRegister = true;
      this.successMessage = "";
      this.errorMessage = "";
      const registeredDogData = JSON.stringify({
        dog_id: dogId,
        event_id: this.selectedEventId,
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
        .get("http://localhost:8000/api/mydogs", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          this.myDogs = response.data;
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

    getActiveEvents(): void {
      this.errorMessage = "";
      this.activeEvents = [];
      this.loaderActiveForList = true;
      axios
        .get("http://localhost:8000/api/events/getActiveEvents", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
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
  margin: 0px;
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

.no-dogs {
  text-align: center;
}

.delete-link {
  text-decoration: none;
  display: flex;
  border-bottom: 1px solid #e94f4f;
  padding: 5px;
  color: #e94f4f;
  font-style: italic;
  cursor: pointer;
}
</style>