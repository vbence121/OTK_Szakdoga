import { mount } from '@vue/test-utils';
import RegisterView from '@/views/RegisterView.vue';
import { REGISTER } from '@/labels/labels';

describe('registerView Component tests.', () => {
  let wrapper: any;

  beforeEach(() => {
    wrapper = mount(RegisterView);
  })

  test('Test for labels.', () => {
    const expectedLabels = REGISTER;
    
    expect((wrapper.vm as any).registerLabels).toBe(expectedLabels);
  });
});
