import lazyLoading from './lazy-loading';

export default {
  name: 'MyWhistlist',
  path: '/my-whistlist',
  component: lazyLoading('my-whistlist/MyWhistlist'),
  meta: {
    title: 'Danh sách yêu thích'
  }
};
