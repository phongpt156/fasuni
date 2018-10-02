import lazyLoading from './lazy-loading';

export default {
  name: 'Checkout',
  path: '/checkout',
  component: lazyLoading('checkout/Checkout'),
  meta: {
    title: 'Thông tin giao hàng'
  },
  children: [
    {
      name: 'CheckoutLogin',
      path: 'login',
      component: lazyLoading('checkout/Login'),
      meta: {
        title: 'Đăng nhập',
        step: 0
      }
    },
    {
      name: 'CheckoutShipping',
      path: 'shipping',
      component: lazyLoading('checkout/Shipping'),
      meta: {
        title: 'Thông tin giao hàng',
        step: 1
      }
    },
    {
      name: 'CheckoutPayment',
      path: 'payment',
      component: lazyLoading('checkout/Payment'),
      meta: {
        title: 'Thanh toán',
        step: 2
      }
    },
    {
      name: 'CheckoutSuccess',
      path: 'success',
      component: lazyLoading('checkout/Success'),
      meta: {
        title: 'Đặt hàng thành công',
        step: 2
      }
    }
  ]
};
