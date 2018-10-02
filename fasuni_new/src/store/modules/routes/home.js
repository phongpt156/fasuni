import lazyLoading from './lazy-loading';

export default {
  name: 'Homepage',
  path: '/',
  component: lazyLoading('Home'),
  meta: {
    title: 'Trang chủ',
  },
};
