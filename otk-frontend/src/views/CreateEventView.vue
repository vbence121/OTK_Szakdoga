<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container center">
          <div class="content-container">
            <div class="form-container">
              <h1>Új kiállítás létrehozása</h1>
              <form>
                <div class="inputbox">
                  <input
                    type="text"
                    required="required"
                    v-model="name"
                    placeholder="Kiállítás neve"
                  />
                </div>
                <div class="inputbox">
                  <select
                    required
                    id="category"
                    name="category"
                    v-model="selectedCategoryId"
                  >
                  <option :value="null" disabled>Kategória</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.type }}
                    </option>
                  </select>
                </div>
                <div class="inputbox flex">
                  <input
                    type="button"
                    value="Létrehozás!"
                    class="submit"
                    @click="submit"
                  />
                  <clip-loader
                    :loading="loaderActive"
                    :color="color"
                    class="loader"
                  ></clip-loader>
                  <div v-if="errorMessage" class="error">
                    {{ errorMessage }}
                  </div>
                  <div v-if="successMessage" class="success">
                    {{ successMessage }}
                  </div>
                </div>
              </form>
            </div>
            <div>
              <div class="inner-center">
                <h1>Aktív események</h1>
                <span
                  class="success"
                  v-if="this.$route.params.deleteSuccessMessage"
                >
                  {{ this.$route.params.deleteSuccessMessage }}
                </span>
                <div
                  v-if="
                    !this.$store.getters.getMyActiveEvents.length &&
                    !loaderActiveForList
                  "
                  class="no-dogs"
                >
                  Jelenleg nincs egy aktív esemény sem.
                </div>
                <div
                  v-for="(event, index) in this.$store.getters
                    .getMyActiveEvents"
                  :key="event.id"
                  class="list-group-item align-content-center"
                >
                  <router-link
                    class="
                      event
                      d-flex
                      justify-content-between
                      align-content-center
                    "
                    :to="{ path: '/eventProfile/' + event.id }"
                  >
                    <span>{{ index + 1 }}.</span>
                    <span>{{ event.name }}</span>
                  </router-link>
                </div>
                <clip-loader
                  :loading="loaderActiveForList"
                  :color="color"
                  class="loader"
                ></clip-loader>
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

export default defineComponent({
  name: "CreateEventView",
  components: { ClipLoader },

  data() {
    return {
      name: "",
      show: true,

      myEvents: [],

      selectedCategoryId: null,
      errorMessage: "",
      successMessage: "",
      deleteSuccessMessage: "",
      loaderActive: false,
      loaderActiveForList: false,
      color: "#000",
    };
  },

  async created() {
    this.getActiveEvents();
    await this.$store.dispatch("setCategories");
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
  },

  methods: {
    getActiveEvents(): void {
      if (
        !this.$store.getters.getIsActiveEventsLoaded ||
        this.$route.params.deleteSuccessMessage !== undefined
      ) {
        this.errorMessage = "";
        this.loaderActiveForList = true;
        this.$store.dispatch("setMyActiveEvents", { myActiveEvents: [] });
        this.$store.dispatch("setIsActiveEventsLoaded", {
          isActiveEventsLoaded: false,
        });
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
            this.$store.dispatch("setMyActiveEvents", {
              myActiveEvents: response.data,
            });
            this.$store.dispatch("setIsActiveEventsLoaded", {
              isActiveEventsLoaded: true,
            });
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
      }
    },
    async submit(): Promise<void> {
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      const eventData = JSON.stringify({
        name: this.name,
        categoryId: this.selectedCategoryId,
      });
      axios
        .post("http://localhost:8000/api/events/store", eventData, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          if (response.status !== undefined && response.status === 201) {
            this.successMessage = "Sikeres mentés!";
            this.$store.dispatch("setIsActiveEventsLoaded", {
              isActiveEventsLoaded: false,
            });
            this.getActiveEvents();
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
.event {
  text-decoration: none;
  display: flex;
  border-bottom: 1px solid dodgerblue;
  padding: 5px;
  color: dodgerblue;
  font-style: italic;
}

.event:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
  cursor: pointer;
}

.list-group-item:hover {
  transform: scaleX(1.1);
}

.list-group-item:hover .check {
  opacity: 1;
}
.list-group-item {
  margin-top: 10px;
  border-radius: none;

  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

body {
  margin: 0px;
  height: 100vh;
  background-color: #f1f3f7;
}
.form-container {
  border-right: 1px solid gray;
  padding-right: 20px;
}
.inner-container {
  padding: 20px;
  display: flex;
}
.outer-container {
  display: flex;
  justify-content: center;
}

.content-container {
  justify-content: space-between;
  display: flex;
}

.info-container {
  background-color: #fff;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  margin: 20px;
}

.wrapper {
  width: 80%;
  display: flex;
}
.container {
  display: flex;
  justify-content: space-between;
}
.hobby {
  margin: 20px 0px;
}
.success {
  color: green;
  margin: auto;
  margin-left: 20px;
}
.error {
  color: red;
  margin: auto;
  margin-left: 20px;
}
.loader {
  margin-left: 30px;
  margin-top: 5px;
}
.flex {
  display: flex;
  justify-content: left;
}

.center {
  /* position: relative; */
  padding: 50px 0px;
  background: #fff;
  border-radius: 10px;
}
.center h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}
.center .inputbox {
  position: relative;
  width: 300px;
  height: 50px;
  margin-bottom: 25px;
}
.center .inputbox input, select {
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
.center .inputbox [type="button"]:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.submit:hover {
  cursor: pointer;
}

.no-dogs {
  text-align: center;
}

.inner-center {
  position: relative;
  padding: 0px 50px;
  background: #fff;
  border-radius: 10px;
  width: 400px;
}
</style>