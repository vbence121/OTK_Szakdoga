import { mount } from '@vue/test-utils';
import HomeView from '@/views/HomeView.vue';
import PaginationComponent from '@/components/PaginationComponent.vue';
import { REGISTER } from '@/labels/labels';
import ClipLoader from "vue-spinner/src/ClipLoader.vue";
import axios from 'axios';

jest.mock('axios');
const mockedAxios = axios as jest.Mocked<typeof axios>;

describe('HomeView Component tests.', () => {
  let wrapper: any;

  beforeEach(() => {
    mockedAxios.get.mockResolvedValue([]);
    wrapper = mount(HomeView, {
      components:{
        ClipLoader, PaginationComponent
      },
      /* data(){
        return {
            rings: [],
            posts: [],
            totalPosts: 0,
            loaderActive: false,
            loaderActiveForPosts: false,
          };
        } */
      /* data: () => ({
            rings: [],
            posts: [],
            totalPosts: 0,
            loaderActive: false,
            loaderActiveForPosts: false,
        }), */
    });
  })

  test.only('Test for labels.', () => {
    
    expect(1).toBe(1);
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