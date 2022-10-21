<template>
  <div class="outer-container">
    <div class="info-container">
      <div class="wrapper">
        <div class="inner-container center">
          <div class="content-container">
            <div class="">
              <h1>Új kutya hozzáadása</h1>
              <form>
                <div class="inputbox d-flex gap">
                  <div>
                    <div>Kutya neve*</div>
                    <input
                      class="input-left"
                      type="text"
                      required="required"
                      v-model="name"
                    />
                  </div>
                  <div>
                    <div>Törzskönyv/Chipszám</div>
                    <input
                      type="text"
                      required="required"
                      v-model="registerSernum"
                    />
                  </div>
                </div>
                <div>
                    <div>Kutya neme*</div>
                    <select
                      required
                      name="category"
                      v-model="gender"
                    >
                      <option :value="null" disabled>Válasszon nemet!</option>
                      <option :value="'kan'">
                        Kan
                      </option>
                      <option :value="'szuka'">
                        Szuka
                      </option>
                    </select>
                  </div>
                  <div class="mt-3">
                    <input type="checkbox" required="required" v-model="hobby" @click="setHerdBookType()" />
                    <span> Hobbi (pipálja ki ha igen)</span>

                  </div>
                <div class="hobby d-flex align-content-center">
                  <div>Születési dátuma*</div>
                  <input
                    class="input-style"
                    type="date"
                    required="required"
                    v-model="birthdate"
                  />
                </div>
                <div class="inputbox">
                  <div>Tenyésztő neve</div>
                  <input
                    type="text"
                    required="required"
                    v-model="breederName"
                  />
                </div>
                <div class="inputbox">
                  <div>Anyja neve</div>
                  <input
                    type="text"
                    required="required"
                    v-model="motherName"
                  />
                </div>
                <div class="inputbox">
                  <div>Apja neve</div>
                  <input
                    type="text"
                    required="required"
                    v-model="fatherName"
                  />
                </div>
                <div class="inputbox d-flex gap">
                  <div>
                    <div>Fajtacsoport*</div>
                    <select
                      required
                      name="category"
                      v-model="breed_group"
                      @click="setHerdBookType()"
                    >
                      <option :value="null" disabled>
                        Válasszon csoportot!
                      </option>
                      <option
                        v-for="breedGroup in breedGroupsWithBreeds"
                        :key="breedGroup.id"
                        :value="breedGroup.id"
                        :disabled="hobby && breedGroup.id === 12"
                      >
                        {{ breedGroup.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <div>Fajta*</div>
                    <select
                      required
                      id="category"
                      name="category"
                      v-model="breed_id"
                    >
                      <option :value="null" disabled>Válasszon Fajtát!</option>
                      <option
                        v-for="breed in getBreedsById"
                        :key="breed.id"
                        :value="breed.id"
                      >
                        {{ breed.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="inputbox">
                  <div>Törzskönyv Típusa*</div>
                  <select
                    required
                    name="category"
                    v-model="herd_book_type_id"
                  >
                    <option :value="null" disabled>Válasszon típust!</option>
                    <option
                      v-for="herdBookType in herdBookTypes"
                      :key="herdBookType.id"
                      :value="herdBookType.id"
                      :disabled="calculateHerdBookType(herdBookType.id)"
                    >
                      {{ herdBookType.type }}
                    </option>
                  </select>
                </div>
                <div class="inputbox">
                  <div>Egyéb leírás</div>
                  <input
                    type="textarea"
                    v-model="description"
                  />
                </div>
                <div class="inputbox flex">
                  <input
                    type="button"
                    value="Mentés!"
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
import { BreedGroupWithBreeds, HerdBookTypeId } from "../types/types";

export default defineComponent({
  name: "MyDogsView",
  components: { ClipLoader },

  data() {
    return {
      name: "",
      hobby: false,
      birthdate: "",
      gender: null,
      breederName: "",
      description: "",
      motherName: "",
      fatherName: "",
      breed_group: null,
      breed_id: -1,
      registerSernum: "",
      herd_book_type_id: null as HerdBookTypeId,

      errorMessage: "",
      successMessage: "",
      loaderActive: false,
      color: "#000",
    };
  },

  async created() {
    await this.$store.dispatch("setDataForCreatingNewDog");
    setTimeout(() => {
      console.log(this.$store.getters.getBreedGroupsWithBreeds, "qwe");
    }, 4000);
  },

  computed: {
    herdBookTypes() {
      return this.$store.getters.getHerdBookTypes;
    },
    breedGroupsWithBreeds() {
      return this.$store.getters.getBreedGroupsWithBreeds;
    },
    getBreedsById() {
      const selectedBreedGroup =
        this.$store.getters.getBreedGroupsWithBreeds.find(
          (breedGroup: BreedGroupWithBreeds) =>
            breedGroup.id === this.breed_group
        );
      return selectedBreedGroup?.breeds;
    },
  },

  methods: {
    calculateHerdBookType(herdBookId: number): boolean {
      if(!this.hobby && this.breed_group !== null && this.breed_group === 12 && herdBookId === 3){
        return false;
      }
      return this.hobby && herdBookId !== 3 || 
      !this.hobby && herdBookId === 3 ||
      !this.hobby && this.breed_group !== null && this.breed_group > 10 && herdBookId === 1 ||
      !this.hobby && this.breed_group !== null && this.breed_group !== 11 && herdBookId === 2 ||
      !this.hobby && this.breed_group !== null && this.breed_group !== 11 && herdBookId === 3;
    },
    setHerdBookType(): void {
      this.herd_book_type_id = null;
    },
    async submit(): Promise<void> {
      this.errorMessage = "";
      this.successMessage = "";
      this.loaderActive = true;
      if(this.herd_book_type_id !== 3 && this.registerSernum === (null || '')){
        this.errorMessage = "adja meg a törzskönyv/chipszámot!";
        this.loaderActive = false;
        return;
      }
      const dogData = JSON.stringify({
        name: this.name,
        hobby: this.hobby,
        gender: this.gender,
        birthdate: this.birthdate,
        breederName: this.breederName,
        motherName: this.motherName,
        fatherName: this.fatherName,
        breed_id: this.breed_id,
        registerSernum: this.registerSernum,
        herd_book_type_id: this.herd_book_type_id,
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
            this.$router.push({
              name: "MyListOfDogs",
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
            else if (error.response.data.errors.breed)
              this.errorMessage = error.response.data.errors.breed[0];
            else if (error.response.data.errors.gender)
              this.errorMessage = error.response.data.errors.gender[0];
            else if (error.response.data.errors.birthdate)
              this.errorMessage = error.response.data.errors.birthdate[0];
            else if (error.response.data.errors.breederName)
              this.errorMessage = error.response.data.errors.breederName[0];
            else if (error.response.data.errors.motherName)
              this.errorMessage = error.response.data.errors.motherName[0];
            else if (error.response.data.errors.fatherName)
              this.errorMessage = error.response.data.errors.fatherName[0];
            else if (error.response.data.errors.breed_id)
              this.errorMessage = error.response.data.errors.breed_id[0];
            else if (error.response.data.errors.registerSernum)
              this.errorMessage = error.response.data.errors.registerSernum[0];
            else if (error.response.data.errors.herd_book_type_id)
              this.errorMessage =
                error.response.data.errors.herd_book_type_id[0];
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

.gap {
  gap: 10px;
}

.myspan {
  vertical-align: middle;
}

.input-left {
  margin-right: 10px;
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
  margin-bottom: 15px;
}
.input-style,
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
.center .inputbox [type="button"]:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.submit:hover {
  cursor: pointer;
}

#category {
    min-width: 330px;
  }

@media (max-width: 600px) {
  .inputbox {
    flex-direction: column;
  }

  .hobby {
    flex-direction: column;
  }
  .wrapper {
  width: 90%;
}

  .info-container {
    margin: 0px;
  }

  #category {
    min-width: 0px;
  }
}
</style>