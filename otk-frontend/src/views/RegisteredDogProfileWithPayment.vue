<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container" v-if="!isAcceptOrRejectSubmitClicked">
          <h1>Kutya adatai</h1>
          <clip-loader
            :loading="dogDataLoading"
            :color="color"
            class="loader-for-data"
          ></clip-loader>
          <div v-if="!dogDataLoading">
            <div class="each-row" @click="navigateToUser">
              <div>Tulajdonos:</div>
              <div class="owner text-right">
                {{ owner.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Név:</div>
              <div class="text-right">
                {{ dog.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Fajta:</div>
              <div class="text-right">
                {{ dog.breed }}
              </div>
            </div>
            <div class="each-row">
              <div>Nem:</div>
              <div class="text-right">
                {{ dog.gender }}
              </div>
            </div>
            <div class="each-row">
              <div>hobby:</div>
              <div class="text-right">
                {{ dog.hobby }}
              </div>
            </div>
            <div class="each-row">
              <div>Születési dátuma:</div>
              <div class="text-right">
                {{ dateFormatterWhiteSpace(dog.birthdate) }}
              </div>
            </div>
            <div class="each-row">
              <div>Tenyésztő neve:</div>
              <div class="text-right">
                {{ dog.breederName }}
              </div>
            </div>
            <div class="each-row">
              <div>Anyja neve:</div>
              <div class="text-right">
                {{ dog.motherName }}
              </div>
            </div>
            <div class="each-row">
              <div>Apja neve:</div>
              <div class="text-right">
                {{ dog.fatherName }}
              </div>
            </div>
            <div class="each-row">
              <div>Törzskönyv/Chipszám:</div>
              <div class="text-right">
                {{ dog.registerSernum }}
              </div>
            </div>
            <div class="each-row">
              <div>Törzskönyv típusa:</div>
              <div class="text-right">
                {{ dog.herdBookName }}
              </div>
            </div>
            <div class="each-row">
              <div>Nevezés osztálya:</div>
              <div class="text-right">
                {{ dog.classType }}
              </div>
            </div>
            <div class="each-row">
              <div>Feltöltött dokumentumok:</div>
              <div class="each-file">
                <a v-if="files.length"
                    class="link"
                    :href="'http://127.0.0.1:8000/files/' + files[0].generated_name"
                    >{{ files[0].name }}</a
                  >
                <div v-for="(file, index) in files" :key="file.id">
                  <a v-if="index > 0"
                    class="link"
                    :href="'http://127.0.0.1:8000/files/' + file.generated_name"
                    >{{ file.name }}</a
                  >
                </div>
              </div>
            </div>
            <div class="each-row">
              <div>Nevezési díj visszaigazolás:</div>
              <div class="each-file">
                <a v-if="uploadedPaymentCertificates.length"
                    class="link"
                    :href="'http://127.0.0.1:8000/files/' + uploadedPaymentCertificates[0].generated_name"
                    >{{ uploadedPaymentCertificates[0].name }}</a
                  >
                <div v-for="(file, index) in uploadedPaymentCertificates" :key="file.id">
                  <a v-if="index > 0"
                    class="link"
                    :href="'http://127.0.0.1:8000/files/' + file.generated_name"
                    >{{ file.name }}</a
                  >
                </div>
              </div>
            </div>
            <div
              class="delete-link d-flex justify-content-between"
              @click="rejectClicked = !rejectClicked"
            >
              <div>Nevezés visszautasítása</div>
              <div class="icon-wrapper">
                <img
                  :src="rejectClicked ? downIcon : upIcon"
                  alt="info"
                  width="20"
                  height="20"
                />
              </div>
            </div>
            <div v-if="rejectClicked">
              <div class="p-1">Indoklás (nem kötelező)</div>
              <textarea
                class="m-1"
                id="reason"
                name="reason"
                rows="4"
                cols="30"
                v-model="rejectReason"
              />
            </div>
            <div class="inputbox flex align-items-center">
              <input
                v-if="!rejectClicked"
                type="button"
                value="Elfogadás!"
                class="edit-button"
                @click="
                  acceptOrRejectEntry(dog.dog_id, 'paid')
                "
              />
              <input
                v-if="rejectClicked"
                type="button"
                value="Visszautasítás!"
                class="reject-button"
                @click="
                  acceptOrRejectEntry(dog.dog_id, 'payment_declined')
                "
              />
              <clip-loader
                :loading="loaderActive"
                :color="color"
                class="loader-for-delete"
              ></clip-loader>
            </div>
            <button class="back-button" @click="backToEvent">Vissza!</button>
          </div>
        </div>
        <div class="inner-container" v-if="isAcceptOrRejectSubmitClicked">
          <div>
            <h4 v-if="successMessage !== ''" class="success">
              {{ successMessage }}
            </h4>
            <h4 v-if="errorMessage !== ''" class="error">
              {{ errorMessage }}
            </h4>
            <button class="back-button" @click="backToEvent">Vissza!</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import downIcon from "../assets/caret-down-fill.svg";
import upIcon from "../assets/caret-left-fill.svg";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import {
  Dog,
  User,
  RegisteredDogStatus,
  File,
} from "@/types/types";
import {
  dateFormatterWhiteSpace,
} from "@/utils/helpers";

export default defineComponent({
  name: "RegisteredDogProfileWithPayment",
  components: { ClipLoader },

  props: {
    deleteSuccess: Boolean,
  },

  data() {
    return {
      birthdate: "",
      originalRegisterSernum: "",
      dog: {} as Dog,
      owner: {} as User,
      deleteConfirmDialogOptions: {
        value: "Nevezés visszautasítása",
        title: "Biztosan törölni akarja?",
        confirmButton: "Törlés!",
        cancelButton: "Mégsem",
      },
      files: [] as File[],
      uploadedPaymentCertificates: [],

      errorMessage: "",
      errorDeleteMessage: "",
      successMessage: "",
      loaderActive: false,
      dogDataLoading: false,
      isDeleteLoading: false,
      rejectClicked: false,
      isAcceptOrRejectSubmitClicked: false,
      color: "#000",
      downIcon: downIcon,
      upIcon: upIcon,
      rejectReason: "",
      RegisteredDogStatus,
      dateFormatterWhiteSpace,
    };
  },

  created() {
    this.dogDataLoading = true;
    this.getuserUploads();
    this.getRegisteredDogRecord();
    /* axios
      .get(`http://localhost:8000/api/dogs/${this.$route.params.dog_id}`, {
        withCredentials: true,
      })
      .then((response) => {
        if (response.data !== undefined) {
          console.log(response, "showdata");
          this.dog = response.data.dog;
          this.files = response.data.files;
          this.getUserById(this.dog.user_id);
        } else {
          this.errorMessage = "Hiba történt...";
        }
        this.dogDataLoading = false;
      })
      .catch((err) => {
        console.log(err);
        this.dogDataLoading = false;
      }); */
  },

  methods: {
    backToEvent(): void {
      this.$router.push({
        path: "/paymentsForEvent/" + this.$store.getters.getLastOpenedEventId,
      });
    },

    navigateToUser(): void {
      this.dog.dog_class_id = this.$route.params.dog_class_id;
      this.$store.dispatch("setLastOpenedRegisteredDog", {
        dog: this.dog,
        comesFromPayments: true,
      });
      this.$router.push({
        path: "/userProfile/" + this.dog.user_id,
      });
    },

    acceptOrRejectEntry(dogId: number, status: string): void {
      this.loaderActive = true;
      const data = {
        dog_id: dogId,
        event_category_id: this.$route.params.event_category_id,
        declined_reason:
          status === 'payment_declined' ? this.rejectReason : "",
        status: status,
        dog_class_id: this.$route.params.dog_class_id,
      };
      axios
        .post(`http://localhost:8000/api/registeredDogs/updateStatus/`, data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          if (response.status !== undefined && response.status === 200) {
            this.successMessage = "Sikeres mentés!";
          }
          this.loaderActive = false;
          this.isAcceptOrRejectSubmitClicked = true;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else this.errorMessage = "Hiba történt...";
          console.error("There was an error!", error);
          this.loaderActive = false;
          this.isAcceptOrRejectSubmitClicked = true;
        });
    },

    getUserById(id: number) {
      axios
        .get(`http://localhost:8000/api/users/${id}`, {
          withCredentials: true,
        })
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response, "owner");
            this.owner = response.data;
          } else {
            this.errorMessage = "Hiba történt...";
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },

    getuserUploads(): void {
      axios
        .get(
          `http://localhost:8000/api/dogs/${this.$route.params.dog_id}/events/${this.$route.params.event_category_id}/getFiles`,
          {
            headers: {
              "Content-Type": "multipart/form-data",
              Accept: "multipart/form-data",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response, "files");
            this.uploadedPaymentCertificates = response.data;
          } else {
            this.errorDeleteMessage = "Hiba történt...";
          }
          this.dogDataLoading = false;
          this.isDeleteLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.errorDeleteMessage = "Hiba történt...";
          this.dogDataLoading = false;
          this.isDeleteLoading = false;
        });
    },

    getRegisteredDogRecord() {
      axios
        .get(`http://localhost:8000/api/events/${this.$route.params.event_category_id}/registeredDogsById/${this.$route.params.dog_id}`, {
          withCredentials: true,
        })
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response.data, "registeredDog");
            this.dog = response.data.dog[0];
            this.files = response.data.files;
            this.getUserById(this.dog.user_id);
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

@media screen and (max-width: 500px) {
  .wrapper {
    width: 100%;
  }
  .info-container {
    width: 100%;
  }
}

.files {
  word-break: break-all;
}

.text-right {
  text-align: right;
  word-break: break-all;
}

.each-row > div:first-child {
  margin-right: 10px;
}


.each-file {
  text-align: right;
}

a {
  margin: 0px;
  color: black;
}

.delete-link,
.delete-profile {
  text-decoration: none;
  display: flex;
  border-bottom: 1px solid #e94f4f;
  padding: 5px;
  color: #e94f4f;
  font-style: italic;
  cursor: pointer;
}

.delete-link:hover {
  color: rgb(150, 8, 3);
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
  min-width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px;
}

.edit-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
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
.hobby {
  margin: 20px 0px 30px;
}

.loader-for-delete {
  width: 100%;
  margin-top: 10px;
}

.asd {
  height: 100%;
  width: 60%;
}

.owner {
  color: dodgerblue;
  cursor:pointer;
}
</style>