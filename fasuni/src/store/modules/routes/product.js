import lazyLoading from './lazy-loading';

export default {
  name: 'Product',
  path: '/product/:id',
  component: lazyLoading('Product'),
  meta: {
    title: 'Fasuni',
  },
};
