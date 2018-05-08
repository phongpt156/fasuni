import lazyLoading from './lazy-loading';

export default {
  name: 'Login',
  path: '/login',
  component: lazyLoading('Login'),
  meta: {
    title: 'Login'
  },
  beforeEnter(to, from, next) {
    next();
  }
};
