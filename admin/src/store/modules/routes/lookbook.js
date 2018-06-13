import lazyLoading from './lazy-loading';
import authService from '@/shared/services/auth.service';
import store from '@/store';

export default {
  path: '/admin/loobook',
  component: lazyLoading('lookbook/index'),
  children: [
    {
      name: 'Lookbook',
      path: '',
      component: lazyLoading('lookbook/Lookbook'),
      meta: {
        title: 'Lookbook',
        layout: 'MainLayout',
        parent: 'Lookbook'
      }
    },
    {
      name: 'AddLookbook',
      path: 'add',
      component: lazyLoading('lookbook/AddLookbook'),
      meta: {
        title: 'Add Lookbook',
        layout: 'MainLayout',
        parent: 'Lookbook'
      }
    }
  ],
  beforeEnter(to, from, next) {
    if (store.state.user.user) {
      next();
    } else {
      authService.index()
        .then(response => {
          if (!response || response.status === 401) {
            store.commit('auth/removeToken');
            next({name: 'Login'});
          } else {
            store.commit('user/setUser', response.data);
            next();
          }
        });
    }
  }
};
