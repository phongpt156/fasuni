import lazyLoading from './lazy-loading';

export default {
  name: 'OrderHistory',
  path: '/order/history',
  component: lazyLoading('order/OrderHistory'),
  meta: {
    title: 'Fasuni'
  }
};
