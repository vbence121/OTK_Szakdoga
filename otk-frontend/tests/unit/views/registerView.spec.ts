import { flushPromises, mount, VueWrapper } from "@vue/test-utils";
import RegisterView from "@/views/RegisterView.vue";
import { REGISTER } from "@/labels/labels";
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import axios from "axios";

jest.mock("axios");
const mockedAxios = axios as jest.Mocked<typeof axios>;

describe("registerView Component tests.", () => {
  let wrapper: VueWrapper;

  beforeEach(() => {
    wrapper = mount(RegisterView, {
      components: {
        ClipLoader,
      },
      data() {
        return {
          username: "asdasdads",
        };
      },
    });
  });
  
  test("Test for submitting the form.", async () => {
    const expectedErrorMessage = 'Hibás email cím!';
    mockedAxios.post.mockRejectedValue({
      response: {
        data: {
          errors: {
            email: [expectedErrorMessage],
          },
        },
      }
    });
    
    await (wrapper.vm as any).submit();
    await flushPromises();
    
    const errorMessage = wrapper.find('.error');
    expect(errorMessage.text()).toBe(expectedErrorMessage)
  });

  test("Test for labels.", () => {
    const expectedLabels = REGISTER;
  
    expect((wrapper.vm as any).registerLabels).toBe(expectedLabels);
  });
});
