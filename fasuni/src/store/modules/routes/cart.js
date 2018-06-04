import lazyLoading from './lazy-loading';

export default {
  name: 'Cart',
  path: '/cart',
  component: lazyLoading('cart/Cart'),
  meta: {
    title: 'Giỏ hàng'
  }
};
