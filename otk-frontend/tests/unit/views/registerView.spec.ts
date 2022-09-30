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
      },
      data() {
        return {
          username: 'asdasdads',
        }
      }
    });
  })

  test('Test for labels.', () => {
    const expectedLabels = REGISTER;
    
    expect((wrapper.vm as any).registerLabels).toBe(expectedLabels);
  });

  test('Test for submitting the form.', async () => {
    mockedAxios.post.mockResolvedValue({
      data: [
        'success',
      ],
    });
    //(wrapper.vm as any).submit = jest.fn();
    //await wrapper.get('.submit').trigger('click');

    const data = (wrapper.vm as any).submit();
    //expect(axios.post).toBeCalled();
    expect(axios.post).toHaveBeenCalledWith('http://127.0.0.1:8000/api/register');
  });
});
