import lazyLoading from './lazyloading';

export default {
  name: 'Login',
  path: '/login',
  component: lazyLoading('Login'),
  meta: {
    title: 'Đăng nhập'
  }
};
