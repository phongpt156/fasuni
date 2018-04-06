import lazyLoading from './lazy-loading';
import userService from '@/shared/services/user.service';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('homepage/Homepage'),
  meta: {
    title: 'Trang chủ'
  },
  beforeEnter(to, from, next) {
    userService.index()
      .then(response => {
        if (response && response.status === 401) {
          next({'name': 'Login'});
        } else {
          next();
        }
      });
  }
};
