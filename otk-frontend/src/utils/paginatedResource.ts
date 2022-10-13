import { createPaginatedResourceComposable } from 'vue-paginated-resource';

export const usePaginatedResource = createPaginatedResourceComposable({
  frontend: {
    pageSize: 2,
  },
  backend: {
    pageSize: 100,
    requestKeys: {
      page: 'page',
      pageSize: 'size',
    },
  },
});