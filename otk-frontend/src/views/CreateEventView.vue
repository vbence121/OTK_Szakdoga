<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container center">
          <div class="content-container">
            <div class="">
              <h1>Új kiállítás létrehozása</h1>
              <form>
                <div class="inputbox">
                  <div>Kiállítás neve</div>
                  <input
                    type="text"
                    required="required"
                    v-model="name"
                    placeholder="Kiállítás neve"
                  />
                </div>
                <div class="inputbox">
                  <div>Kiállítás dátuma</div>
                  <input
                    class="input-style"
                    type="date"
                    required="required"
                    v-model="eventDate"
                  />
                </div>
                <div class="inputbox">
                  <div>Nevezési határidő dátuma</div>
                  <input
                    class="input-style"
                    type="date"
                    required="required"
                    v-model="entry_deadline"
                  />
                </div>
                <div class="inputbox">
                  <div>Kategória</div>
                  <select
                    required
                    id="category"
                    name="category"
                    v-model="selectedCategoryId"
                  >
                    <option :value="null" disabled>
                      Válasszon kategóriát!
                    </option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.type }}
                    </option>
                  </select>
                </div>
                <div class="inputbox" v-if="isSelectedCategoryisHobby()">
                  <div>Hobby alkategória</div>
                  <select
                    required
                    id="category"
                    name="category"
                    v-model="selectedHobbyCategoryId"
                  >
                    <option :value="null" disabled>
                      Válasszon Hobby kategóriát!
                    </option>
                    <option
                      v-for="category in hobbyCategories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.type }}
                    </option>
                  </select>
                </div>
                <div class="inputbox" style="width: 300px">
                  <div>Nevezhető fajtacsoportok</div>
                  <div
                    :class="[
                      dropDownIsVisible
                        ? 'dropdown-check-list visible'
                        : 'dropdown-check-list',
                    ]"
                  >
                    <span @click="toggleDropDown" class="anchor"
                      >Válassza ki a fajtacsoportokat</span
                    >
                    <ul class="items">
                      <li
                        v-for="breedGroup in breedGroups"
                        :key="breedGroup.id"
                      >
                        {{ breedGroup.name
                        }}<input
                          type="checkbox"
                          v-model="selectedBreedGroups[breedGroup.id]"
                        />
                      </li>
                    </ul>
                  </div>
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
import { Category } from "../types/types";

export default defineComponent({
  name: "CreateEventView",
  components: { ClipLoader },

  data() {
    return {
      name: "",
      selectedCategoryId: null,
      selectedHobbyCategoryId: null,
      errorMessage: "",
      successMessage: "",
      deleteSuccessMessage: "",
      eventDate: "",
      entry_deadline: "",
      loaderActive: false,
      loaderActiveForList: false,
      color: "#000",

      dropDownIsVisible: false,
      selectedBreedGroups: [],
    };
  },

  async created() {
    await this.$store.dispatch("setCategories");
    await this.$store.dispatch("setDataForCreatingNewDog");
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
    hobbyCategories() {
      return this.$store.getters.getHobbyCategories;
    },
    breedGroups() {
      return this.$store.getters.getBreedGroupsWithBreeds;
    },
  },

  methods: {
    isSelectedCategoryisHobby(): boolean {
      if (
        this.$store.getters.getHobbyCategories &&
        this.selectedCategoryId ===
        this.$store.getters.getHobbyCategories[0]?.category_id
      ) {
        return true;
      }
      this.selectedHobbyCategoryId = null;
      return false;
    },
    toggleDropDown(): void {
      this.dropDownIsVisible = !this.dropDownIsVisible;
    },

    async submit(): Promise<void> {
      console.log(this.eventDate);
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      const eventData = JSON.stringify({
        name: this.name,
        categoryId: this.selectedCategoryId,
        selectedBreedGroupIds: this.getCheckedBreedGroupIds(),
        eventDate: this.eventDate,
        entry_deadline: this.entry_deadline,
        hobby_category_id: this.selectedHobbyCategoryId, 
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
            this.$router.push({
              name: "EventListView",
              params: { deleteSuccessMessage: "Sikeres létrehozás!" },
            });
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
            else if (error.response.data.errors.eventDate)
              this.errorMessage = error.response.data.errors.eventDate[0];
            else if (error.response.data.errors.selectedBreedGroupIds)
              this.errorMessage =
                error.response.data.errors.selectedBreedGroupIds[0];
            else this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActive = false;
        });
    },
    getCheckedBreedGroupIds(): number[] {
      const checkedIds = [];
      for (let i = 0; i < this.selectedBreedGroups.length; i++) {
        if (this.selectedBreedGroups[i]) {
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

body {
  margin: 0px;
  height: 100vh;
  background-color: #f1f3f7;
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
  width: 300px;
  margin-bottom: 25px;
}
input,
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
  cursor: pointer;
}

.center .inputbox:last-child {
  margin-bottom: 0;
}

.center .inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.center .inputbox [type="button"]:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
  cursor: pointer;
}

/* DROPDOWN */

.dropdown-check-list {
  display: inline-block;
  width: 100%;
  border: 2px solid #000;
  border-radius: 10px;
  padding-top: 5px;
  padding-bottom: 5px;
}

.dropdown-check-list .anchor {
  position: relative;
  cursor: pointer;
  display: inline-block;
  padding: 5px 50px 5px 10px;
  /* border: 2px solid #000; */
  width: 300px;
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

.dropdown-check-list.visible .items {
  display: block;
}

.items li {
  display: flex;
  justify-content: space-between;
  margin-right: 20px;
  margin-left: 20px;
}

.inputbox [type="checkbox"] {
  width: 20px;
  height: 20px;
}
</style>