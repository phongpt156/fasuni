import lazyLoading from './lazy-loading';
import authService from '@/shared/services/auth.service';
import guard from '@/shared/guards';
import store from '@/store';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('homepage/Homepage'),
  meta: {
    title: 'Homepage',
    layout: 'MainLayout'
  },
  beforeEnter(to, from, next) {
    authService.index()
      .then(response => {
        if (response.status === 401) {
          guard.removeToken();
          next({name: 'Login'});
        } else {
          store.commit('user/setUser', response.data);
          next();
        }
      });
  }
};
