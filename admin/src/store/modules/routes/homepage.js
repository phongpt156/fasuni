import lazyLoading from './lazyloading';
import store from './../..';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('HelloWorld'),
  meta: {
    title: 'Trang chủ'
  },
  beforeEnter(to, from, next) {
    store.dispatch('auth/index')
      .then(response => {
        if (response.status === 401) {
          next({'name': 'Login'});
        } else {
          next();
        }
      });
  }
};
