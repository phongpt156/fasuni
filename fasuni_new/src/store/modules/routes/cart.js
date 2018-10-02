import lazyLoading from './lazy-loading';

export default {
  name: 'Cart',
  path: '/cart',
  component: lazyLoading('Cart'),
  meta: {
    title: 'Giỏ hàng',
  },
};
