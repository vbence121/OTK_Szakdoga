import { mount, VueWrapper } from "@vue/test-utils";
import PaginationComponent from "@/components/PaginationComponent.vue";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import axios from "axios";

jest.mock("axios");
const mockedAxios = axios as jest.Mocked<typeof axios>;

function mountPaginationComponent({
  perPage = 5,
  totalItems = 30,
  visible = true,
}: {
  perPage?: number;
  totalItems?: number;
  visible?: boolean;
} = {}): VueWrapper {
  return mount(PaginationComponent, {
    components: {
      ClipLoader,
    },
    props: {
      perPage,
      totalItems,
      visible,
    },
  });
}

describe("PaginationComponent Component tests.", () => {
  let wrapper: VueWrapper;

  test("Test for component visibility.", () => {
    wrapper = mountPaginationComponent({visible: false});

    const div = wrapper.find('div');

    expect(div.exists()).toBe(false);
  });
});
