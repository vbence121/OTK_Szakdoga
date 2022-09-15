<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <div v-if="!isPaymentSubmitted">
            <label class="mb-3"
              >Töltse fel a feladóvevény másolatát vagy az átutalás
              visszaigazolását!</label
            >
            <div v-if="errorFileMessage" class="error">
              {{ errorFileMessage }}
            </div>
            <input
              class="mb-3"
              type="file"
              id="file"
              @change="handleFileUpload($event)"
            />
            <div>Feltöltött fájlok:</div>
            <div
              v-for="file in uploadedFiles"
              :key="file.id"
              class="d-flex justify-content-between"
            >
              <a
                class="link"
                :href="'http://127.0.0.1:8000/files/' + file.generated_name"
                >{{ file.name }}</a
              >
              <img
                :src="xIcon"
                alt="info"
                width="15"
                height="15"
                class="x-icon"
                @click="deleteFile(file.id)"
              />
            </div>
            <div v-if="!uploadedFiles.length" class="mt-3">
              Még nem töltött fel semmit.
            </div>
            <div class="flex-buttons">
              <button class="save-button" @click="submitFile()">
                Feltöltés!
              </button>
              <button class="back-button" @click="backToMyEntryStatusesView()">
                Vissza!
              </button>
            </div>
            <div v-if="uploadedFiles.length">
              <div class="mt-5">
                Amennyiben feltöltötte a másolatot/visszaigazolást kattintson a
                küldés gombra! A szervezők ellenőrzése után automatikusan
                teljesül a nevezés, önnek nincs több dolga.
              </div>
              <button
                class="save-button bg-success"
                @click="submitPaymentCertificate()"
              >
                Küldés!
              </button>
            </div>
          </div>

            <div class="inner-center" v-if="isPaymentSubmitted">
              <div v-if="!loaderActiveForRegister">
                <h4 v-if="successMessage !== ''" class="success text-center">
                  {{ successMessage }}
                </h4>
                <h4 v-if="errorMessage !== ''" class="error text-center">
                  {{ errorMessage }}
                </h4>
                <clip-loader
                  :loading="loaderActive"
                  :color="color"
                  class="loader"
                ></clip-loader>
                <div class="flex-buttons">
                  <button
                    class="back-button"
                    @click="backToMyEntryStatusesView()"
                  >
                    Vissza!
                  </button>
                </div>
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
import xIcon from "../assets/x-lg.svg";

export default defineComponent({
  name: "UploadPaymentCertificateView",
  components: {
    ClipLoader,
  },

  props: {
    deleteSuccess: Boolean,
  },

  data() {
    return {
      uploadedFiles: [],
      isViewChanged: false,
      isFileUploadViewClicked: false,
      isPaymentSubmitted: false,
      file: "",

      errorFileMessage: "",
      errorMessage: "",
      errorDeleteMessage: "",
      successMessage: "",
      loaderActive: false,
      dogDataLoading: false,
      isDeleteLoading: false,
      color: "#000",
      xIcon,
    };
  },

  created() {
    this.getuserUploads();
  },

  methods: {
    backToMyEntryStatusesView(): void {
      this.$router.push({
        name: "MyEntryStatusesView",
      });
    },

    submitPaymentCertificate(): void {
      this.isPaymentSubmitted = true;
      this.loaderActive = true;
      const data = {
        dog_id: this.$route.params.dog_id,
        event_id: this.$route.params.event_id,
        declined_reason: "",
        status: "payment_submitted",
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
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else this.errorMessage = "Hiba történt...";
          console.error("There was an error!", error);
          this.loaderActive = false;
        });
    },

    handleFileUpload(event: any): void {
      this.file = event.target.files[0];
    },

    deleteFile(fileId: number): void {
      this.errorFileMessage = "";
      axios
        .delete(
          `http://localhost:8000/api/dogs/${this.$route.params.dog_id}/paymentCertificateFiles/${fileId}`,
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
            console.log(response);
            this.file = "";
            this.getuserUploads();
          }
          this.dogDataLoading = false;
          this.isDeleteLoading = false;
        })
        .catch((error) => {
          console.log(error);
          if (error.message === "Network Error") {
            this.errorFileMessage = "A törlés nem sikerült!";
          } else this.errorFileMessage = "Hiba történt...";

          this.dogDataLoading = false;
          this.isDeleteLoading = false;
        });
    },

    submitFile() {
      this.errorFileMessage = "";
      let formData = new FormData();
      formData.append("file", this.file);
      axios
        .post(
          `http://localhost:8000/api/dogs/${this.$route.params.dog_id}/events/${this.$route.params.event_id}/PaymentCertificateFiles/upload`,
          formData,
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
            console.log(response);
            this.file = "";
            this.getuserUploads();
          }
          this.dogDataLoading = false;
          this.isDeleteLoading = false;
        })
        .catch((error) => {
          console.log(error);
          if (error.message === "Network Error") {
            this.errorFileMessage = "A feltöltött dokumentum nem megfelelő!";
          } else if (error.response.data.errors !== undefined) {
            if (error.response.data.errors.email)
              this.errorFileMessage = error.response.data.errors.file[0];
            else if (error.response.data.errors.password)
              this.errorFileMessage = error.response.data.errors.name[0];
            else this.errorFileMessage = "Hiba történt...";
          }
          this.dogDataLoading = false;
          this.isDeleteLoading = false;
        });
    },

    getuserUploads(): void {
      axios
        .get(
          `http://localhost:8000/api/dogs/${this.$route.params.dog_id}/events/${this.$route.params.event_id}/getFiles`,
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
            this.uploadedFiles = response.data;
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
  },
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");

.error {
  color: red;
  padding-bottom: 10px;
}
.link {
  text-decoration: underline;
  color: blue;
  cursor: pointer;
}

a {
  margin: 0px;
  color: black;
}

.file-upload {
  text-decoration: none;
  display: flex;
  border-bottom: 1px solid #a7acf1;
  padding: 5px;
  color: #6b74f7;
  font-style: italic;
}

.file-upload:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
  cursor: pointer;
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

.x-icon {
  filter: invert(10%) sepia(39%) saturate(8476%) hue-rotate(330deg)
    brightness(138%) contrast(419%);
  cursor: pointer;
}
</style>