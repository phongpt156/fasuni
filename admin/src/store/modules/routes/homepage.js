import lazyLoading from './lazy-loading';
import authService from '@/shared/services/auth.service';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('Homepage'),
  meta: {
    title: 'Trang chủ'
  },
  beforeEnter(to, from, next) {
    authService.index()
      .then(response => {
        if (response.status === 401) {
          next({name: 'Login'});
        } else {
          next();
        }
      });
  }
};
