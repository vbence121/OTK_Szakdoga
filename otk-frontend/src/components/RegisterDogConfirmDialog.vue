<template>
  <tr style="width: 100%" class="each-entry related-dogs" @click="showModal">
    <td class="text-center">
      {{ name }}
    </td>
    <td class="text-center">
      {{ breed }}
    </td>
    <td class="text-center">asdasd</td>

    <!-- If the option changed modal component the name
    <MyModal>
    -->
    <Modal v-model="isShow" :close="closeModal">
      <div class="asd">
        <div class="title">
          {{ dialogOptions.title }}
        </div>
        <div
          class="
            d-flex
            justify-content-between
            align-content-center
            dog-selected
          "
        >
          <span>{{ name }}</span>
          <span>{{ breed }}</span>
        </div>
        <div class="flex-buttons">
          <button @click="confirm" class="confirm-button">
            {{ dialogOptions.confirmButton }}
          </button>
          <button @click="closeModal" class="cancel-button">
            {{ dialogOptions.cancelButton }}
          </button>
        </div>
      </div>
    </Modal>
  </tr>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";

export default defineComponent({
  props: {
    dialogOptions: Object,
    index: Number,
    name: String,
    breed: String,
  },
  methods: {
    confirm(): void {
      this.isShow = false;
      this.$emit("confirm");
    },
  },
  setup() {
    const isShow = ref(false);

    function showModal() {
      isShow.value = true;
    }

    function closeModal() {
      isShow.value = false;
    }

    return {
      isShow,
      showModal,
      closeModal,
    };
  },
});
</script>

<style scoped>
.flex-buttons {
  display: flex;
  justify-content: right;
  align-items: center;
}

.asd {
  background-color: white;
  width: 350px;
  border-radius: 10px;
}

.title {
  padding: 20px;
  margin-bottom: 10px;
  font-size: 25px;
}

.confirm-button {
  margin: 20px 0px;
  background: dodgerblue;
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px 20px;
}

.confirm-button:hover {
  background: linear-gradient(45deg, greenyellow, dodgerblue);
}

.cancel-button {
  margin: 20px;
  background: rgb(134, 135, 136);
  color: #fff;
  border: #fff;
  border-radius: 10px;
  padding: 10px 20px;
}

.cancel-button:hover {
  background: linear-gradient(45deg, rgb(93, 94, 92), dodgerblue);
}

.value {
  width: 100%;
}

.dog-selected {
  background-color: aliceblue;
  padding: 5px 10px;
  border-radius: 5px;
  margin: 10px;
}

/* TABLE */

.related-dogs {
  padding: 2px;
  width: 100%;
}

.related-dogs:hover {
  color: rgb(66, 77, 233);
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
</style>