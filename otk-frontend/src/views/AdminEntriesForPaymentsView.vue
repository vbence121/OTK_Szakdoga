<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Beérkező nevezési díjak</h1>
          <table v-if="!makeTableSmaller">
            <thead class="header-uline">
              <tr>
                <td class="text-center">új visszaigazolások</td>
                <td class="text-center">Kiállítás neve</td>
                <td class="text-center">Kategória</td>
              </tr>
            </thead>
            <tbody
              v-for="(event, index) in this.activeEvents"
              :key="event.id"
              class="each-entry"
              @click="showRelatedPayments(index, event)"
            >
              <tr class="event-dropdown">
                <td class="text-center">
                  ({{ event.registeredDogs?.length ?? 0 }})
                </td>
                <td class="text-center">{{ event.name }}</td>
                <td class="text-center">{{ event.categoryType }} <span v-if="event?.hobbyCategoryType">-</span> {{ event?.hobbyCategoryType }}</td>
              </tr>
            </tbody>
          </table>
          <div v-else>
            <div v-for="(event, index) in this.activeEvents"
              :key="event.id"
              class="each-entry smaller-table-each"
              @click="showRelatedPayments(index, event)">
              <div class="text-right">
                <div>új visszaigazolások:</div>
                <div>({{ event.registeredDogs?.length ?? 0 }})</div>
              </div>
              <div class="text-right">
                <div>Kiállítás neve:</div>
                <div>{{ event.name }}</div>
              </div>
              <div class="text-right">
                <div>Kategória:</div>
                <div>{{ event.categoryType }} <span v-if="event?.hobbyCategoryType">-</span> {{ event?.hobbyCategoryType }}</div>
              </div>
            </div>
          </div>
          <div
            v-if="
              !loaderActive &&
              !this.activeEvents.length
            "
            class="text-center m-4"
          >
            Jelenleg nincs Aktív esemény.
          </div>
          <clip-loader
            :loading="loaderActive"
            :color="color"
            class="loader mt-4"
          ></clip-loader>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import { ActiveEvent } from "../types/types";

export default defineComponent({
  name: "AdminEntriesForPaymentsView",
  components: {
    ClipLoader,
  },

  data() {
    return {
      activeEvents: [] as ActiveEvent[],
      isViewChanged: false,
      selectedEvent: {} as ActiveEvent,
      makeTableSmaller: false,

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      userDataLoading: false,
      color: "#000",
    };
  },

  computed: {
    categories() {
      return this.$store.getters.getCategories;
    },
  },

  async created() {
    window.addEventListener("resize", this.shouldConvertTable);
    this.assertScreenWidthLimit(screen.width);
    this.$store.dispatch("setCategories");
    await this.getRegisteredDogsForActiveEvents();
  },

  unmounted() {
    window.removeEventListener("resize", this.shouldConvertTable);
  },

  methods: {
    shouldConvertTable(e: any): void {
      this.assertScreenWidthLimit(e.currentTarget.screen.width);
    },

    assertScreenWidthLimit(actualScreenWidth: number): void {
      const screenWidthLimit = 700;
      if(actualScreenWidth < screenWidthLimit){
        this.makeTableSmaller = true;
      } else {
        this.makeTableSmaller = false;
      }
    },

    showRelatedPayments(index: number, event: any): void {
      this.$store.dispatch("setLastOpenedEventName", { name: event });
      this.$router.push({
        path: "/paymentsForEvent/" + this.activeEvents[index].id,
      });
    },

    actualCategory(index: number) {
      return this.$store.getters.getCategories.find(
        (category: any) => category.id === this.activeEvents[index].category_id
      );
    },

    getRegisteredDogsForActiveEvents(): void {
      this.loaderActive = true;
      axios
        .get(
          "http://localhost:8000/api/registeredDogs/getPaymentsForActiveEvents",
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response, "qwqweqew");
          this.activeEvents = response.data;
          for (let i = 0; i < this.activeEvents.length; i++) {
            this.activeEvents[i].showRelatedDogs = false;
          }
          console.log("active", this.activeEvents);
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

  thead {
    word-break: break-all;
  }
}

.smaller-table-each {
  background-color: #f4f5f7;
  border-radius: 10px;
  padding: 10px;
  margin-top: 10px;
}

.text-right {
  display: flex;
  justify-content: space-between;
}

.text-right > div:first-child {
  margin-right: 10px;
}
.text-right > div:last-child {
  text-align: right;
  word-break: break-all;
}

.each-row {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #dfe1e5;
  padding: 5px;
  color: #909090;
}

.registered-dog {
  cursor: pointer;
}

.registered-dog:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
  cursor: pointer;
}

.icon-wrapper {
  color: black;
}

.related-dogs {
  border-bottom: 1px solid rgb(177, 175, 175);
  padding: 2px;
  width: 100%;
}

.related-dogs:hover {
  color: rgb(66, 77, 233);
}

.related-dogs-wrapper {
  margin-left: 20px;
}

.header-uline {
  border-bottom: 1px solid black;
  margin-bottom: 10px;
  font-size: 23px;
}

a {
  margin: 0px;
}

.event-dropdown {
  padding: 5px;
  font-style: italic;
}

.event-dropdown:hover {
  color: rgb(66, 77, 233);
  background-color: #f4f5f7;
  cursor: pointer;
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
  min-width: 80%;
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

.no-events {
  text-align: center;
}

table {
  width: 100%;
}
</style>