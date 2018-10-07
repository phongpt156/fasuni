import lazyLoading from './lazy-loading';

export default {
  name: 'ViewOrder',
  path: '/order/view',
  component: lazyLoading('order/ViewOrder'),
  meta: {
    title: 'Fasuni',
  },
};
