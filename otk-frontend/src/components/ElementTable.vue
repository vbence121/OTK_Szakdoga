<template>
    <div>
    <button
        :disabled="!previousPageAvailable"
        @click="previousPage"
    >
        előző
    </button>
    <button
        :disabled="!nextPageAvailable"
        @click="nextPage"
    >
        következő
    </button>
    <p
        v-for="element in pageElements"
        :key="element.id"
    >
        {{ element.name }}
    </p>
    </div>
</template>
<script setup lang="ts">
import axios from 'axios';
import { reactive, ref } from 'vue';
import { usePaginatedResource } from '@/utils/paginatedResource';

interface Element { // Element from the API
  id: number,
  name: string,
}

interface Params {
  // API-related params, should be passed into the composable params
  search: string,

  // page-related params, don't get passed into the composable params
  page: number,
  size: number,
}

const getElements = async (
  params: Params,
): Promise<{ total: number, elements: Array<Element> }> => {
    //const response = await axios.get('https://some.url/endpoint', { params });
    const response = {
        data: {
            total: 10,
            items: [{id:1, name: "asd"},{id:2, name: "yolo"},{id:3, name: "ascsad"},{id:4, name: "aafsdsdafsd"},{id:5, name: "eqwqwe"}]
        }
    }
    return { total: response.data.total, elements: response.data.items };
}

const page = ref(1);
const params = reactive({ search: 'some search' });

const previousPage = () => {
  page.value -= 1;
}

const nextPage = () => {
  page.value += 1;
}

const resetPage = () => {
  page.value = 1;
};



const {
  pageElements,
  previousPageAvailable,
  nextPageAvailable,
} = usePaginatedResource(getElements, page, resetPage, params);
</script>
