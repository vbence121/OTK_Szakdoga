<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Kutya adatai</h1>
          <clip-loader
            :loading="dogDataLoading"
            :color="color"
            class="loader-for-data"
          ></clip-loader>
          <div
            v-if="!dogDataLoading && !isViewChanged && !isFileUploadViewClicked"
          >
            <div class="each-row">
              <div>Név:</div>
              <div>
                {{ dog.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Fajta:</div>
              <div>
                {{ dog.breed }}
              </div>
            </div>
            <div class="each-row">
              <div>hobby:</div>
              <div>
                {{ dog.hobby }}
              </div>
            </div>
            <div class="each-row">
              <div>Születési dátuma:</div>
              <div>
                {{ dateFormatter(dog.birthdate) }}
              </div>
            </div>
            <div class="each-row">
              <div>Tenyésztő neve:</div>
              <div>
                {{ dog.breederName }}
              </div>
            </div>
            <div class="each-row">
              <div>Anyja neve:</div>
              <div>
                {{ dog.motherName }}
              </div>
            </div>
            <div class="each-row">
              <div>Apja neve:</div>
              <div>
                {{ dog.fatherName }}
              </div>
            </div>
            <div class="each-row">
              <div>Törzskönyv/Chipszám:</div>
              <div>
                {{ dog.registerSernum }}
              </div>
            </div>
            <div class="file-upload" @click="goToFileUploadView">
              Dokumentumok feltöltése
            </div>
            <UniversalModal
              class="delete-link"
              :dialogOptions="deleteConfirmDialogOptions"
              @confirm="onDeleteConfirm"
            />
            <div class="inputbox flex align-items-center">
              <input
                type="button"
                value="Adatok módosítása"
                class="edit-button"
                @click="changeToEditProfileView"
              />
              <clip-loader
                :loading="isDeleteLoading"
                :color="color"
                class="loader-for-delete"
              ></clip-loader>
              <div v-if="errorDeleteMessage" class="error">
                {{ errorDeleteMessage }}
              </div>
            </div>
            <button class="back-button" @click="backToMyDogsView">
              Vissza!
            </button>
          </div>
          <div v-if="isFileUploadViewClicked">
            <label class="mb-3">Válassza ki a feltölteni kívánt fájlt!</label>
            <div v-if="errorFileMessage" class="error">
              {{ errorFileMessage }}
            </div>
            <input
              class="mb-3"
              type="file"
              id="file"
              @change="handleFileUpload($event)"
            />
            <div v-if="uploadedFiles.length">Feltöltött dokumentumok:</div>
            <div v-for="file in uploadedFiles" :key="file.id">
              <a
                class="link"
                :href="'http://127.0.0.1:8000/files/' + file.generated_name"
                >{{ file.name }}</a
              >
            </div>
            <div class="flex-buttons">
              <button class="save-button" @click="submitFile()">
                Feltöltés!
              </button>
              <button class="back-button" @click="goToFileUploadView">
                Vissza!
              </button>
            </div>
          </div>
          <div v-if="isViewChanged && !isFileUploadViewClicked" class="center">
            <form>
              <div class="inputbox">
                <input type="text" required="required" v-model="dog.name" />
                <span>Kutya neve</span>
              </div>
              <div class="inputbox">
                <input type="text" required="required" v-model="dog.breed" />
                <span>Fajta</span>
              </div>
              <div class="hobby">
                <input type="checkbox" v-model="dog.hobby" />
                <span> Hobbi (pipálja ki ha igen)</span>
              </div>
              <div class="inputbox">
                <input
                  type="date"
                  required="required"
                  :value="dateFormatter(dog.birthdate)"
                  @input="birthdate = $event.target.value"
                />
                <span>Születési dátuma</span>
              </div>
              <div class="inputbox">
                <input
                  type="text"
                  required="required"
                  v-model="dog.breederName"
                />
                <span>Tenyésztő neve</span>
              </div>
              <div class="inputbox">
                <input
                  type="text"
                  required="required"
                  v-model="dog.motherName"
                />
                <span>Anyja neve</span>
              </div>
              <div class="inputbox">
                <input
                  type="text"
                  required="required"
                  v-model="dog.fatherName"
                />
                <span>Apja neve</span>
              </div>
              <div class="inputbox">
                <input
                  type="text"
                  required="required"
                  v-model="dog.registerSernum"
                />
                <span>Törzskönyv/Chipszám</span>
              </div>
              <div class="inputbox">
                <input
                  type="text"
                  required="required"
                  v-model="dog.herd_book_type_id"
                />
                <span>Regisztráció típusa</span>
              </div>
              <div class="inputbox">
                <input
                  type="textarea"
                  required="required"
                  v-model="dog.description"
                />
                <span>Egyéb leírás</span>
              </div>
              <div class="flex-buttons">
                <input
                  type="button"
                  value="Mentés!"
                  class="save-button"
                  @click="submit"
                />
                <clip-loader
                  :loading="loaderActive"
                  :color="color"
                  class="loader-for-save"
                ></clip-loader>
                <button class="back-button" @click="changeToEditProfileView">
                  Vissza!
                </button>
              </div>
              <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
              <div v-if="successMessage" class="success">
                {{ successMessage }}
              </div>
            </form>
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
import UniversalModal from "@/components/UniversalModal.vue";

export default defineComponent({
  name: "DogProfileView",
  components: { ClipLoader, UniversalModal },

  props: {
    deleteSuccess: Boolean,
  },

  data() {
    return {
      birthdate: "",
      originalRegisterSernum: "",
      dog: {
        name: "",
        breed: "",
        hobby: "",
        birthdate: "",
        breederName: "",
        motherName: "",
        fatherName: "",
        category: "",
        registerSernum: "",
        herd_book_type_id: "",
        description: "",
      },
      uploadedFiles: [],
      isViewChanged: false,
      isFileUploadViewClicked: false,
      deleteConfirmDialogOptions: {
        value: "Kutya törlése",
        title: "Biztosan törölni akarja?",
        confirmButton: "Törlés!",
        cancelButton: "Mégsem",
      },
      file: "",

      errorFileMessage: "",
      errorMessage: "",
      errorDeleteMessage: "",
      successMessage: "",
      loaderActive: false,
      dogDataLoading: false,
      isDeleteLoading: false,
      color: "#000",
    };
  },

  computed: {
    registerLabels() {
      return REGISTER;
    },
  },

  created() {
    this.getDogData();
    this.getuserUploads();
  },

  methods: {
    changeToEditProfileView(): void {
      this.isViewChanged = !this.isViewChanged;
    },
    dateFormatter(date: string) {
      return date.split("T")[0];
    },

    backToMyDogsView(): void {
      this.$router.push({
        name: "MyListOfDogs",
      });
    },

    goToFileUploadView(): void {
      this.isFileUploadViewClicked = !this.isFileUploadViewClicked;
    },

    handleFileUpload(event: any) {
      this.file = event.target.files[0];
    },

    submitFile() {
      this.errorFileMessage = "";
      let formData = new FormData();
      formData.append("file", this.file);
      axios
        .post(
          `http://localhost:8000/api/dogs/uploadFile/${this.$route.params.id}`,
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

    getDogData(): void {
      this.dogDataLoading = true;
      axios
        .get(`http://localhost:8000/api/dogs/${this.$route.params.id}`, {
          withCredentials: true,
        })
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response);
            this.dog = response.data.dog;
            this.originalRegisterSernum = response.data.dog.registerSernum;
          } else {
            this.errorMessage = "Hiba történt...";
          }
          this.dogDataLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.dogDataLoading = false;
        });
    },

    getuserUploads(): void {
      axios
        .get(
          `http://localhost:8000/api/dogs/getFiles/${this.$route.params.id}`,
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

    onDeleteConfirm(): void {
      this.errorDeleteMessage = "";
      this.isDeleteLoading = true;
      axios
        .delete(
          `http://localhost:8000/api/dogs/delete/${this.$route.params.id}`,
          {
            withCredentials: true,
          }
        )
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response);
            this.$router.push({
              name: "MyListOfDogs",
              params: { deleteSuccessMessage: "Sikeres törlés!" },
            });
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
    async submit(): Promise<void> {
      this.errorMessage = "";
      this.successMessage = "";
      this.errorDeleteMessage = "";
      this.loaderActive = true;
      const dogData = JSON.stringify({
        name: this.dog.name,
        breed: this.dog.breed,
        hobby: this.dog.hobby,
        birthdate: this.birthdate === "" ? this.dog.birthdate : this.birthdate,
        breederName: this.dog.breederName,
        motherName: this.dog.motherName,
        fatherName: this.dog.fatherName,
        category: this.dog.category,
        registerSernum:
          this.dog.registerSernum !== this.originalRegisterSernum ||
          this.dog.registerSernum === ""
            ? this.dog.registerSernum
            : undefined,
        herd_book_type_id: this.dog.herd_book_type_id,
        description: this.dog.description,
      });
      axios
        .put(
          `http://localhost:8000/api/dogs/modify/${this.$route.params.id}`,
          dogData,
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
          if (response.status !== undefined && response.status === 200) {
            console.log(response);
            this.originalRegisterSernum = response.data.registerSernum;
            this.successMessage = "Sikeres mentés!";
            this.$store.dispatch('setIsDogsLoaded', { isDogsLoaded: false });
          }
          this.loaderActive = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            if (error.response.data.errors.name)
              this.errorMessage = error.response.data.errors.name[0];
            else if (error.response.data.errors.breed)
              this.errorMessage = error.response.data.errors.breed[0];
            else if (error.response.data.errors.birthdate)
              this.errorMessage = error.response.data.errors.birthdate[0];
            else if (error.response.data.errors.breederName)
              this.errorMessage = error.response.data.errors.breederName[0];
            else if (error.response.data.errors.motherName)
              this.errorMessage = error.response.data.errors.motherName[0];
            else if (error.response.data.errors.fatherName)
              this.errorMessage = error.response.data.errors.fatherName[0];
            else if (error.response.data.errors.category)
              this.errorMessage = error.response.data.errors.category[0];
            else if (error.response.data.errors.registerSernum)
              this.errorMessage = error.response.data.errors.registerSernum[0];
            else if (error.response.data.errors.herd_book_type_id)
              this.errorMessage = error.response.data.errors.herd_book_type_id[0];
            else this.errorMessage = "Hiba történt...";
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
</style>