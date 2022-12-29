<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container">
          <h1>Nevezések és bírálatok</h1>
          <div v-if="!loaderActiveForName && !loaderActive" class="each-row text-right exhibition-name">
              <div>Kiállítás neve:</div>
              <div>
                {{ selectedExhibition.name }}
              </div>
            </div>
          <table v-if="!makeTableSmaller && !loaderActiveForName && !loaderActive">
            <tr class="header-uline">
              <td class="text-center">Rajtszám</td>
              <td class="text-center">Kutya neve</td>
              <td class="text-center">Fajta</td>
              <td class="text-center">Ketegória</td>
              <td class="text-center">Bírálat</td>
              <td class="text-center">Bírálat szövege</td>
            </tr>
            <tr v-for="(dog, index) in dogs" :key="index" class="each-entry">
              <td class="text-center">
                {{ dog.start_number ?? "-" }}
              </td>
              <td class="text-center">
                {{ dog.name }}
              </td>
              <td class="text-center">
                {{ dog.breedName }}
              </td>
              <td class="text-center">
                {{ dog.categoryType }}
              </td>
              <td class="text-center">
                {{ dog.award ?? "-" }}
              </td>
              <td class="text-center">
                {{ dog.judging_description ?? "-" }}
              </td>
            </tr>
          </table>
          <div v-if="makeTableSmaller && !loaderActiveForName && !loaderActive">
            <div
              v-for="(dog, index) in dogs"
              :key="index"
              class="each-entry smaller-table-each"
            >
              <div class="text-right">
                <div>Rajtszám:</div>
                <div>{{ dog.start_number ?? '-' }}</div>
              </div>
              <div class="text-right">
                <div>Kutya neve:</div>
                <div>{{ dog.name }}</div>
              </div>
              <div class="text-right">
                <div>Fajta:</div>
                <div>{{ dog.breedName }}</div>
              </div>
              <div class="text-right">
                <div>Kategória:</div>
                <div>{{ dog.categoryType }}</div>
              </div>
              <div class="text-right">
                <div>Bírálat:</div>
                <div>{{ dog.award ?? "-" }}</div>
              </div>
              <div class="text-right">
                <div>Bírálat szövege:</div>
                <div>{{ dog.judging_description ?? "-" }}</div>
              </div>
            </div>
            <div v-if="!loaderActive && !dogs.length" class="text-center m-4">
              Jelenleg nincsenek beérkezett nevezések.
            </div>
          </div>
          <clip-loader
            :loading="loaderActive || loaderActiveForName"
            :color="color"
            class="loader-for-data"
          ></clip-loader>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent } from "vue";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";

export default defineComponent({
  name: "ExhibitionEntriesView",
  components: { ClipLoader },

  data() {
    return {
      dogs: [],
      selectedExhibition: {},
      loaderActive: false,
      loaderActiveForName: false,
      color: "#000",
      makeTableSmaller: false,
    };
  },

  async created() {
    window.addEventListener("resize", this.shouldConvertTable);
    this.assertScreenWidthLimit(screen.width);
    await this.getExhibitionEntries();
  },

  async mounted() {
    this.getExhibitionById();
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
      if (actualScreenWidth < screenWidthLimit) {
        this.makeTableSmaller = true;
      } else {
        this.makeTableSmaller = false;
      }
    },

    getExhibitionEntries(): void {
      this.loaderActive = true;
      axios
        .get(
          `http://localhost:8000/api/registeredDogs/getRegisteredDogsForEventByExhibitionId/${this.$route.params.exhibition_id}`,
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          this.dogs = response.data;
          console.log(response, "dogs");
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

    getExhibitionById(): void {
      this.loaderActiveForName = true;
      const data = JSON.stringify({
        exhibition_id: this.$route.params.exhibition_id,
      });
      axios
        .post("http://localhost:8000/api/exhibitions/getExhibitionById", data, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          this.selectedExhibition = response.data.exhibition;
          console.log(response, 'exhibition?');
          this.loaderActiveForName = false;
        })
        .catch((error) => {
          console.error("There was an error!", error);
          this.loaderActiveForName = false;
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

.exhibition-name {
  margin-bottom: 30px;
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

.loader-for-data {
  margin-top: 30px;
}

.check-icon {
  filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(86deg)
    brightness(118%) contrast(119%);
}

.x-icon {
  filter: invert(10%) sepia(39%) saturate(8476%) hue-rotate(330deg)
    brightness(138%) contrast(419%);
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

.header-uline {
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
</style>