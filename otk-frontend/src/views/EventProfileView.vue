<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Esemény Adatai</h1>
          <clip-loader
            :loading="eventDataLoading"
            :color="color"
            class="loader-for-data"
          ></clip-loader>
          <div v-if="!eventDataLoading && !isViewChanged">
            <div class="each-row">
              <div>Név:</div>
              <div>
                {{ event.name }}
              </div>
            </div>
            <div class="each-row">
              <div>Kategória:</div>
              <div>
                {{ actualCategory.type }}
              </div>
            </div>
            <div class="each-row">
              <div>Nevezhető fajtacsoportok:</div>
              <div class="each-file">
                <div v-for="breedGroup in breedGroups" :key="breedGroup.id">
                  {{ breedGroup.name }}
                </div>
              </div>
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
            <button class="back-button" @click="backToActiveEventsView">
              Vissza!
            </button>
          </div>
          <div v-if="isViewChanged" class="center">
            <form>
              <div class="inputbox">
                <input type="text" required="required" v-model="event.name" />
                <span>Esemény neve</span>
              </div>
              <span>Kategória</span>
              <div class="inputbox">
                <select
                  required
                  id="category"
                  name="category"
                  v-model="event.category_id"
                >
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.type }}
                  </option>
                </select>
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
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import UniversalModal from "@/components/UniversalModal.vue";

export default defineComponent({
  name: "EventProfileView",
  components: { ClipLoader, UniversalModal },

  props: {
    deleteSuccess: Boolean,
  },

  data() {
    return {
      event: {
        name: "",
        category_id: -1,
        active: -1,
      },
      breedGroups: [],
      isViewChanged: false,
      deleteConfirmDialogOptions: {
        value: "Esemény törlése",
        title: "Biztosan törölni akarja?",
        confirmButton: "Törlés!",
        cancelButton: "Mégsem",
      },

      errorMessage: "",
      errorDeleteMessage: "",
      successMessage: "",
      loaderActive: false,
      eventDataLoading: false,
      isDeleteLoading: false,
      color: "#000",
    };
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },

    actualCategory() {
      return this.$store.getters.getCategories.find(
        (category: any) => category.id === this.event.category_id
      );
    },
  },

  created() {
    this.$store.dispatch("setCategories");
    this.eventDataLoading = true;
    axios
      .get(`http://localhost:8000/api/events/${this.$route.params.id}`, {
        withCredentials: true,
      })
      .then((response) => {
        if (response.data !== undefined) {
          console.log(response, "api/events");
          this.event = response.data.event;
          this.breedGroups = response.data.breed_groups;
        } else {
          this.errorMessage = "Hiba történt...";
        }
        this.eventDataLoading = false;
      })
      .catch((err) => {
        console.log(err);
        this.eventDataLoading = false;
      });
  },

  methods: {
    changeToEditProfileView(): void {
      this.isViewChanged = !this.isViewChanged;
    },
    dateFormatter(date: string) {
      return date.split("T")[0];
    },

    backToActiveEventsView(): void {
      this.$router.push({
        path: "/activeEvents",
      });
    },

    onDeleteConfirm(): void {
      this.errorDeleteMessage = "";
      this.isDeleteLoading = true;
      axios
        .delete(
          `http://localhost:8000/api/events/delete/${this.$route.params.id}`,
          {
            withCredentials: true,
          }
        )
        .then((response) => {
          if (response.data !== undefined) {
            console.log(response);
            this.$store.dispatch("setIsActiveEventsLoaded", {
              isActiveEventsLoaded: false,
            });
            this.$router.push({
              name: "EventListView",
              params: { deleteSuccessMessage: "Sikeres törlés!" },
            });
          } else {
            this.errorDeleteMessage = "Hiba történt...";
          }
          this.eventDataLoading = false;
          this.isDeleteLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.errorDeleteMessage = "Hiba történt...";
          this.eventDataLoading = false;
          this.isDeleteLoading = false;
        });
    },
    async submit(): Promise<void> {
      this.errorMessage = "";
      this.successMessage = "";
      this.errorDeleteMessage = "";
      this.loaderActive = true;
      const eventData = JSON.stringify({
        name: this.event.name,
        category_id: this.event.category_id,
      });
      axios
        .put(
          `http://localhost:8000/api/events/modify/${this.$route.params.id}`,
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
          if (response.status !== undefined && response.status === 200) {
            console.log(response);
            this.$store.dispatch("setIsActiveEventsLoaded", {
              isActiveEventsLoaded: false,
            });
            this.successMessage = "Sikeres mentés!";
          }
          this.loaderActive = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            if (error.response.data.errors.name)
              this.errorMessage = error.response.data.errors.name[0];
            else if (error.response.data.errors.categoryId)
              this.errorMessage = error.response.data.errors.categoryId[0];
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
.center .inputbox input,
select {
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