import lazyLoading from './lazy-loading';

export default {
  name: 'Login',
  path: '/login',
  component: lazyLoading('Login'),
  meta: {
    title: 'Đăng nhập'
  },
  beforeEnter(to, from, next) {
    next();
  }
};
