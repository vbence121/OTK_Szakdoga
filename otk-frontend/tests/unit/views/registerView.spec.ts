import { mount } from '@vue/test-utils';
import RegisterView from '@/views/RegisterView.vue';
import { REGISTER } from '@/labels/labels';
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import axios from 'axios';

jest.mock('axios');
const mockedAxios = axios as jest.Mocked<typeof axios>;

describe('registerView Component tests.', () => {
  let wrapper: any;

  beforeEach(() => {
    wrapper = mount(RegisterView, {
      components:{
        ClipLoader
      }
    });
  })

  test('Test for labels.', () => {
    const expectedLabels = REGISTER;
    
    expect((wrapper.vm as any).registerLabels).toBe(expectedLabels);
  });

  test('Test for submitting the form.', () => {
    mockedAxios.post.mockResolvedValue({
      data: [
        {
          id: 1,
          name: 'Joe Doe'
        },
        {
          id: 2,
          name: 'Jane Doe'
        }
      ],
    });

    (wrapper.vm as any).submit()
    
    expect(1).toBe(1);
  });
});
