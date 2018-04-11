import lazyLoading from './lazy-loading';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('homepage/Homepage'),
  meta: {
    title: 'Trang chủ'
  }
};
