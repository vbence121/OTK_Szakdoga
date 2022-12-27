<template>
<div>

  <div class="outer-container" v-if="rings.length">
    <div class="info-container">
      <div class="wrapper">
        <div
          :class="[
            loaderActive
              ? 'inner-container loading-container'
              : 'inner-container',
          ]"
        >
          <h1>Ringek</h1>
          <div v-if="!loaderActive" class="rings-container">
            <div v-for="ring in rings" :key="ring.id" class="bg-gray">
              <h2 class="text-center">{{ ring.name }}</h2>
              <div v-if="ring?.actualDog.length">
                <div class="ring-row">
                  <div>Rajtszám:</div>
                  <div>{{ ring.actualDog[0].start_number }}</div>
                </div>
                <div class="ring-row">
                  <div>Nem:</div>
                  <div>{{ ring.actualDog[0].gender }}</div>
                </div>
                <div class="ring-row">
                  <div>Fajta:</div>
                  <div>{{ ring.actualDog[0].breedName }}</div>
                </div>
                <div class="ring-row">
                  <div>Kategória:</div>
                  <div>
                    {{ ring.actualDog[0].categoryType }}
                    <span v-if="ring?.actualDog[0]?.hobbyCategoryType">-</span>
                    {{ ring?.actualDog[0]?.hobbyCategoryType }}
                  </div>
                </div>
                <div class="ring-row">
                  <div>Osztály:</div>
                  <div>{{ ring.actualDog[0].classType }}</div>
                </div>
              </div>
              <div
                v-else
                class="d-flex align-items-center justify-content-center"
                style="height: 75%"
              >
                -
              </div>
            </div>
          </div>
          <div
            v-if="loaderActive"
            class="d-flex align-items-center justify-content-center"
            style="min-height: 100%"
          >
            <clip-loader
              :color="color"
            ></clip-loader>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div
          :class="[
            loaderActiveForPosts
              ? 'inner-container loading-container'
              : 'inner-container',
          ]"
        >
          <h1>Hírek</h1>
          <pagination-component 
            :visible="!loaderActiveForPosts" 
            :totalItems="totalPosts" 
            :perPage="5" 
            @getItems="getPosts"
          >
            <div>
              <div v-for="post in posts" :key="post.id">
                <h2>
                  {{post.title}}
                </h2>
                <div class="date">{{ dateFormatter(post.created_at) }}</div>
                <div class="date">
                  {{post.content}}
                </div>
              </div>
            </div>
          </pagination-component>
          <div
            v-if="loaderActiveForPosts"
            class="d-flex align-items-center justify-content-center"
            style="min-height: 100%"
          >
            <clip-loader
              :color="color"
            ></clip-loader>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent } from "vue";
import { Ring } from "../types/types";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import { dateFormatter } from "../utils/helpers";
import PaginationComponent from "../components/PaginationComponent.vue";

export default defineComponent({
  name: "HomeView",
  components: { ClipLoader, PaginationComponent },
  data() {
    return {
      rings: [] as Ring[],
      posts: [],
      totalPosts: 0,
      loaderActive: false,
      loaderActiveForPosts: false,
      color: "#000",
      dateFormatter,
    };
  },

  mounted() {
    // @ts-ignore
    window.Echo.channel("channel").listen("DogChange", (e) => {
      console.log(e);
      const newDog = e.dog;
      const ring_id = parseInt(e.ring_id);
      this.rings.filter((ring: Ring) => {
        if (ring.id === ring_id) {
          ring.actualDog = newDog;
        }
      });
    });
  },

  created() {
    this.getLoadedExhibition();
    this.getPosts(0);
  },

  methods: {
    getLoadedExhibition(): void {
      this.loaderActive = true;
      axios
        .get(
          "http://localhost:8000/api/exhibitions/getLoadedExhibitionWithRings",
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          console.log(response.data);
          this.rings = response.data;
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

    getPosts(pageNumber: number) {
      this.loaderActiveForPosts = true;
      axios
        .get(
          `${process.env.VUE_APP_WEBSITE_ROOT}/api/posts/get/${pageNumber}`,
          {
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
            },
            withCredentials: true,
          }
        )
        .then((response) => {
          this.posts = response.data.posts;
          this.totalPosts = response.data.totalPosts;
          this.loaderActiveForPosts = false;
          return response.data;
        })
        .catch((error) => {
          if (error.message === "Network Error") {
            //this.errorMessage = "Nincs kapcsolat!";
          } else if (error.response.data.errors !== undefined) {
            //this.errorMessage = "Hiba történt...";
          }
          console.error("There was an error!", error);
          this.loaderActiveForPosts = false;
          return [];
        });
      return [];
    },
  },
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@600&display=swap");
.loading-container {
  height: 80vh;
}

.bg-gray {
  background-color: #dddddd;
  border-radius: 10px;
  width: 40%;
  min-width: 250px;
  padding: 20px;
  margin: 20px;
  min-height: 210px;
  box-shadow: 5px 5px 7px rgb(0,0,0,0.4);
}

.rings-container {
  display: flex;
  justify-content: space-evenly;
  flex-wrap: wrap;
}

.ring-row {
  display: flex;
  justify-content: space-between;
  text-align: center;
}

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

.selected {
  color: rgb(66, 77, 233);
  background-color: #efeff1;
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
  margin-bottom: 0px;
}

.date {
  margin-bottom: 20px;
}

.outer-container {
  display: flex;
  justify-content: center;
}

.info-container {
  width: 100%;
  display: flex;
  justify-content: center;
  margin: 20px;
}

.wrapper {
  width: 100%;
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
.inputbox {
  width: 300px;
  margin-bottom: 25px;
  margin-top: 25px;
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
}
.inputbox:last-child {
  margin-bottom: 0;
}
.inputbox span {
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
.inputbox [type="button"] {
  width: 50%;
  background: dodgerblue;
  color: #fff;
  border: #fff;
}
.inputbox:hover [type="button"] {
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
  margin: 15px 0px 15px 0px;
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
  margin: 20px 20px 20px 0px;
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

h4,
.instruction {
  text-align: left;
  margin-bottom: 20px;
  margin-top: 20px;
  color: #0094ff;
}

[type="checkbox"] {
  width: 20px;
  height: 20px;
  cursor: pointer;
}

.new-ring {
  cursor: pointer;
  color: #0094ff;
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
</style>