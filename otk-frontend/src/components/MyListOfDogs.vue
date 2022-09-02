<template>
  <div>
    <div class="inner-center">
      <h1>Saját kutyáim</h1>
      <span class="success">
        {{ this.deleteSuccessMessage }}
      </span>
      <div v-if="!myDogs.length && !loaderActiveForList" class="no-dogs">
        Még nem adott hozzá egy kutyát sem.
      </div>
      <div
        v-for="(dog, index) in myDogs"
        :key="dog.id"
        class="list-group-item align-content-center"
      >
        <router-link
          class="
            password-link
            d-flex
            justify-content-between
            align-content-center
          "
          :to="{ path: '/dogProfile/' + dog.id }"
        >
          <span>{{ index + 1 }}.</span>
          <span>{{ dog.name }}</span>
          <span>{{ dog.breed }}</span>
        </router-link>
      </div>
      <clip-loader
        :loading="loaderActiveForList"
        :color="color"
        class="loader"
      ></clip-loader>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";

export default defineComponent({
  name: "MyListOfDogs",
  components: { ClipLoader },
  props: {
    loaderActiveForList: Boolean,
    deleteSuccessMessage: String,
  },

  data() {
    return {
      errorMessage: "",
      color: "#000",
    };
  },

  computed: {
    myDogs() {
      return this.$store.getters.getMyDogs;
    },
  },

  created() {
    this.$emit("getUserDogs");
  },

  methods: {
    dateFormatter(date: string) {
      return date.split("T")[0];
    },
  },
});
</script>

<style scoped>
.no-dogs {
  text-align: center;
}

.info:hover {
  background-color: blue;
  border-radius: 5px;
}

.my-dogs {
  margin-right: 10vh;
  margin-top: 10vh;
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

.inner-center {
  position: relative;
  padding: 0px 50px;
  background: #fff;
  border-radius: 10px;
  width: 450px;
}

.inner-center h1 {
  font-size: 2em;
  border-left: 5px solid dodgerblue;
  padding: 10px;
  color: #000;
  letter-spacing: 5px;
  margin-bottom: 60px;
  font-weight: bold;
  padding-left: 10px;
}

.each-dog {
  display: flex;
  justify-content: space-between;
  background-color: rgb(245, 245, 245);
  margin: 2px;
  padding: 5px;
  border-radius: 5px;
}

.success {
  color: green;
  margin: auto;
  font-size: 1.5em;
}
</style>