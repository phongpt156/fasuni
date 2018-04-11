import lazyLoading from './lazy-loading';

export default {
  name: 'Product',
  path: '/product',
  component: lazyLoading('product/Product'),
  meta: {
    title: 'Fasuni'
  }
};
