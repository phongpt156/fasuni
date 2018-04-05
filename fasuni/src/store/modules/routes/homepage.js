import lazyLoading from './lazy-loading';
import store from './../..';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('homepage/Homepage'),
  meta: {
    title: 'Trang chủ'
  },
  beforeEnter(to, from, next) {
    store.dispatch('services/auth/index')
      .then(response => {
        if (response && response.status === 401) {
          next({'name': 'Login'});
        } else {
          next();
        }
      });
  }
};
