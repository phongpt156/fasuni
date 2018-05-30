import lazyLoading from './lazy-loading';

export default {
  name: 'Product',
  path: '/product/:id',
  component: lazyLoading('product/Product'),
  meta: {
    title: 'Fasuni'
  }
};
