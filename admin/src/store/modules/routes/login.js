import lazyLoading from './lazy-loading';
import store from './../..';

export default {
  name: 'Login',
  path: '/login',
  component: lazyLoading('Login'),
  meta: {
    title: 'Đăng nhập'
  },
  beforeEnter(to, from, next) {
    store.dispatch('services/auth/index')
      .then(response => {
        if (response && response.status === 200) {
          next({'name': 'Homepage'});
        } else {
          next();
        }
      });
  }
};
