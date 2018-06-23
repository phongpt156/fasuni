import lazyLoading from './lazy-loading';

export default {
  name: 'Checkout',
  path: '/checkout',
  component: lazyLoading('checkout/Checkout'),
  meta: {
    title: 'Thông tin giao hàng'
  },
  childrens: [
    {
      path: 'login',
      
    }
  ]
};
