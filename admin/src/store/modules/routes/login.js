import lazyLoading from './lazy-loading';
import authService from '@/shared/services/auth.service';
import store from '@/store';

export default {
  name: 'Login',
  path: '/admin/login',
  component: lazyLoading('Login'),
  meta: {
    title: 'Login'
  },
  beforeEnter(to, from, next) {
    if (store.state.user.user) {
      next({name: 'Homepage'});
    } else {
      authService.index()
        .then(response => {
          if (!response || response.status === 401) {
            store.commit('auth/removeToken');
            next();
          } else {
            store.commit('user/setUser', response.data);
            next({name: 'Homepage'});
          }
        });
    }
  }
};
