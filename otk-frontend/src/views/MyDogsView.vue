<template>
  <div class="container">
    <div>
      <div class="center">
        <h1>Új kutya hozzáadása</h1>
        <form>
          <div class="inputbox">
            <input type="text" required="required" v-model="name" />
            <span>Kutya neve</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="breed" />
            <span>Fajta</span>
          </div>
          <div class="hobby">
            <input type="checkbox" required="required" v-model="hobby" />
            <span>Hobbi (pipálja ki ha igen)</span>
          </div>
          <div class="inputbox">
            <input type="date" required="required" v-model="birthdate" />
            <span>Születési dátuma</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="breederName" />
            <span>Tenyésztő neve</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="motherName" />
            <span>Anyja neve</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="fatherName" />
            <span>Apja neve</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="category" />
            <span>Kategória</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="registerSernum" />
            <span>Törzskönyv/Chipszám</span>
          </div>
          <div class="inputbox">
            <input type="text" required="required" v-model="registerType" />
            <span>Regisztráció típusa</span>
          </div>
          <div class="inputbox">
            <input type="textarea" v-model="description" />
            <span>Egyéb leírás</span>
          </div>
          <div class="inputbox flex">
            <input
              type="button"
              value="Felvétel!"
              class="submit"
              @click="submit"
            />
            <clip-loader
              :loading="loaderActive"
              :color="color"
              class="loader"
            ></clip-loader>
            <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
            <div v-if="successMessage" class="success">
              {{ successMessage }}
            </div>
          </div>
        </form>
      </div>
    </div>
    <MyListOfDogs
      :loaderActiveForList="loaderActiveForList"
      @getUserDogs="getUserDogs"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import MyListOfDogs from "@/components/MyListOfDogs.vue";

export default defineComponent({
  name: "MyDogsView",
  components: { ClipLoader, MyListOfDogs },

  data() {
    return {
      name: "",
      breed: "",
      hobby: false,
      birthdate: "",
      breederName: "",
      description: "",
      motherName: "",
      fatherName: "",
      category: "",
      registerSernum: "",
      registerType: "",

      myDogs: [],

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      loaderActiveForList: false,
      color: "#000",
    };
  },

  methods: {
    getUserDogs() {
      if (!this.$store.getters.getIsDogsLoaded) {
        this.errorMessage = "";
        this.loaderActiveForList = true;
        axios
          .get("http://localhost:8000/api/mydogs", {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            withCredentials: true,
          })
          .then((response) => {
            console.log(response);
            //this.myDogs = response.data;
            this.$store.dispatch("setMyDogs", { myDogs: response.data });
            this.$store.dispatch("setIsDogsLoaded", { isDogsLoaded: true });
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
      const dogData = JSON.stringify({
        name: this.name,
        breed: this.breed,
        hobby: this.hobby,
        birthdate: this.birthdate,
        breederName: this.breederName,
        motherName: this.motherName,
        fatherName: this.fatherName,
        category: this.category,
        registerSernum: this.registerSernum,
        registerType: this.registerType,
        description: this.description,
      });
      axios
        .post("http://localhost:8000/api/store", dogData, {
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
            this.$store.dispatch("setIsDogsLoaded", { isDogsLoaded: false });
            this.getUserDogs();
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
            else if (error.response.data.errors.registerType)
              this.errorMessage = error.response.data.errors.registerType[0];
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
body {
  margin: 0px;
  height: 100vh;
  background-color: #f1f3f7;
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
  position: relative;
  padding: 50px 50px;
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
</style>