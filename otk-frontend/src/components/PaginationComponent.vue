<template>
  <div>
    <slot />
    <div v-if="visible" class="pagination-row">
      <button class="pagination-button" :disabled="isPreviousButtonDisabled" @click="getItems(-1)">
        Előző
      </button>
      <span v-if="isMorePreviousPages" class="pagination-dots">...</span>
      <span v-for="(item, index) in getNumberOfButtons()" :key="index" class="pagination-numbers">
        <button :class="[ item === pageNumber ? 'pagination-button selected' : 'pagination-button']" @click="getItems(0, item)">
          {{item + 1}}
        </button>
      </span>
      <span v-if="isMorePagesNext" class="pagination-dots">...</span>
      <button class="pagination-button" :disabled="isNextButtonDisabled" @click="getItems(1)">
          Következő
        </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "PaginationComponent",
  components: {},

  props: {
    totalItems: {
      type: Number,
      required: true,
    },
    perPage: {
      type: Number,
      required: true,
    },
    visible: {
      type: Boolean,
      required: false,
      default: true,
    },
  },

  computed: {
    numberOfPages(): number {
      return Math.ceil(this.totalItems / this.perPage);
    },
    isNextButtonDisabled(): boolean {
      return this.pageNumber + 1 >= this.numberOfPages;
    },
    isPreviousButtonDisabled(): boolean {
      return this.pageNumber <= 0;
    },
    isMorePagesNext(): boolean {
      const buttons = this.getNumberOfButtons();
      return buttons[buttons.length - 1] !== this.numberOfPages - 1;
    },
    isMorePreviousPages(): boolean {
      const buttons = this.getNumberOfButtons();
      const firstButton = 0;
      console.log()
      return buttons[0] !== firstButton;
    }
  },

  data() {
    return {
      pageNumber: 0,
      numberOfButtons: [] as number[],
      paginationButtonsAtOnce: 5, 
    };
  },

  methods: {
    getNumberOfButtons(): number[] {
      let start = 0;
      let end = 0;
      const buttonsAfterSelected = 3;
      if(this.pageNumber < buttonsAfterSelected){
        end = this.paginationButtonsAtOnce;
      } else if (this.pageNumber > this.numberOfPages - buttonsAfterSelected) {
        start = this.numberOfPages - this.paginationButtonsAtOnce;
        end = this.numberOfPages;
      } else {
        start = this.pageNumber - 2;
        end = start + this.paginationButtonsAtOnce;
      }
      return [...Array(Math.ceil(this.totalItems / this.perPage)).keys()].slice(start, end);
    },

    getItems(pageNumberToAdd: number, indexToJump?: number): void {
      if(indexToJump !== undefined){
        this.pageNumber = indexToJump;
      } else {
        this.pageNumber += pageNumberToAdd;
      }
      this.$emit('getItems', this.pageNumber);
    }
  }
});
</script>

<style scoped>
@media screen and (max-width: 500px) {
  .pagination-numbers, .pagination-dots {
    display:none;
  }
}

.selected {
  background-color: #909090;
}

.pagination-row {
  display: flex;
  justify-content: center;
}

.pagination-dots {
  margin: 2px;
  padding: 8px 0px;
}

.pagination-button {
  padding: 8px;
  margin: 2px;
  border-radius: 3px;
  font-size: 1em;
  cursor: pointer;
}
</style>