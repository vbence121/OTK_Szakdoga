<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1 class="d-flex">Véglegesített nevezések</h1>
          <div class="each-row">
            <div>Kiállítás neve:</div>
            <div>
              {{ eventName }}
            </div>
          </div>
          <div v-if="conuterOfAllDogs && !loaderActive" class="mt-3 p-2 text-center">Fajtacsoportok szerint</div>
          <div v-if="!conuterOfAllDogs && !loaderActive" class="m-4 text-center">
            Még nincs egy véglegesített nevezés sem!
          </div>
          
          <div v-for="breedGroup in eventData" :key="breedGroup.id" class="m-4">
            <div v-if="breedGroup.dogCounterInBreedGroup" class="header p-2 light">
              <img
                  :src="breedGroup.isBreedGroupButtonOpen ? downIcon : upIcon"
                  alt="info"
                  width="20"
                  height="20"
                  @click="breedGroup.isBreedGroupButtonOpen = !breedGroup.isBreedGroupButtonOpen"
                />
              {{ breedGroup.name }} ({{breedGroup.dogCounterInBreedGroup}})
            </div>
            <div v-if="breedGroup.isBreedGroupButtonOpen">
              <div v-for="breed in breedGroup.breeds" :key="breed.id">
                <div v-if="breed.dogCounterInBreed" class="indent-1 header p-2 lighter">
                  <img
                    :src="breed.isBreedButtonOpen ? downIcon : upIcon"
                    alt="info"
                    width="20"
                    height="20"
                    @click="breed.isBreedButtonOpen = !breed.isBreedButtonOpen"
                  />
                  {{ breed.name }} ({{breed.dogCounterInBreed}})
                </div>
                <div v-if="breed.isBreedButtonOpen" class="indent-2">
                  <div v-for="dog_class in breed.dog_classes" :key="dog_class.id">
                    <div v-if="dog_class.dogCounterInClass" class="underline most-light p-2">
                      <img
                        :src="dog_class.isClassButtonOpen ? downIcon : upIcon"
                        alt="info"
                        width="20"
                        height="20"
                        @click="dog_class.isClassButtonOpen = !dog_class.isClassButtonOpen"
                      />
                      {{ dog_class.type }} ({{dog_class.dogCounterInClass}})
                    </div>
                    <div v-if="dog_class.isClassButtonOpen" class="">
                      <table>
                        <tr
                          v-for="dog in dog_class.registeredDogs"
                          :key="dog.id"
                          class="each-entry related-dogs"
                        >
                          <td class="text-center">
                            {{ dog.name }}
                          </td>
                          <td class="text-center">
                            {{ dog.breedName }}
                          </td>
                          <td class="text-center">{{ dog.email }}</td>
                        </tr>
                      </table>

                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <clip-loader
            :loading="loaderActive"
            :color="color"
            class="loader"
          ></clip-loader>
          <button class="back-button" @click="backToEventProfile">
            Vissza!
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import downIcon from "../assets/caret-down-fill.svg";
import upIcon from "../assets/caret-right-fill.svg";
import { BreedGroupData } from "../types/types";

export default defineComponent({
  name: "FinalEventEntriesView",
  components: { ClipLoader },

  data() {
    return {
      eventName: "myEvent",
      eventData: [] as BreedGroupData[],
      dogCounterInBreedGroup: [],
      dogCounterInBreed: [],
      conuterOfAllDogs: 0,
      isBreedGroupButtonOpen: false,
      isBreedButtonOpen: false,
      isClassButtonOpen: false,
      deleteSuccessMessage: "",
      loaderActive: false,
      color: "#000",
      downIcon,
      upIcon,
    };
  },

  async created() {
    this.getFinalDogsForEvent();
    await this.$store.dispatch("setCategories");
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
  },

  methods: {
    backToEventProfile(): void {
      this.$router.push({
        path: "/eventProfile/" + this.$store.getters.getLastOpenedEventId,
      });
    },

    getFinalDogsForEvent(): void {
      this.loaderActive = true;
      axios
        .get(
          `http://localhost:8000/api/events/${this.$route.params.event_category_id}/getFinalDogs`,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "getFinalDogs");
          this.organizeEventData(
            response.data.dogsForEvent,
            response.data.breedGroups,
            response.data.breeds,
            response.data.dog_classes
          );
          this.loaderActive = false;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActive = false;
        });
    },

    organizeEventData(
      dogsForEvent: any,
      breedGroups: any,
      breeds: any,
      dog_classes: any
    ): void {
      for (let i = 0; i < breedGroups.length; i++) {
        this.eventData.push(breedGroups[i]);
        this.eventData[i].breeds = [];
        this.eventData[i].dogCounterInBreedGroup = 0;
        for (let j = 0; j < breeds.length; j++) {
          for (let k = 0; k < breeds[j].length; k++) {
            if (breeds[j][k].breed_group_id === breedGroups[i].id) {
              this.eventData[i].breeds.push(breeds[j][k]);
              this.eventData[i].breeds[k].dog_classes = [];
              this.eventData[i].breeds[k].dogCounterInBreed = 0;
              for (let l = 0; l < dog_classes.length; l++) {
                this.eventData[i].breeds[k].dog_classes.push({...dog_classes[l]});
                this.eventData[i].breeds[k].dog_classes[l].registeredDogs = [];
                this.eventData[i].breeds[k].dog_classes[l].dogCounterInClass = 0;
                for (let m = 0; m < dogsForEvent.length; m++) {
                  if (
                    dogsForEvent[m].breed_group_id === breedGroups[i].id &&
                    dogsForEvent[m].breed_id === this.eventData[i].breeds[k].id &&
                    dogsForEvent[m].dog_class_id === dog_classes[l].id
                  ) {
                    this.eventData[i].breeds[k].dog_classes[l].registeredDogs.push(dogsForEvent[m]);
                    this.dogCounterInBreedGroup[i]++;
                    this.eventData[i].breeds[k].dogCounterInBreed++;
                    this.eventData[i].breeds[k].dog_classes[l].dogCounterInClass++;
                    this.eventData[i].dogCounterInBreedGroup++;
                    this.conuterOfAllDogs++;
                  }
                }
              }
            }
          }
        }
      }
      console.log('eventData',this.eventData);
    },
  },
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
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

.underline {
  border-bottom: 1px solid #ccc;
}

.indent-1 {
  margin-left: 10px;
}

.indent-2 {
  margin-left: 20px;
}

.indent-3 {
  margin-left: 30px;
}

.light {
  background-color: #b9b7b7;
  border-radius: 5px;
}

.lighter {
  background-color: #dddddd;
  border-radius: 5px;
}

.most-light {
  background-color: #f3f3f3;
  border-radius: 5px;
}
</style>