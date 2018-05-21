import lazyLoading from './lazy-loading';

export default {
  name: 'Category',
  path: '/category/:type?',
  component: lazyLoading('category/Category'),
  meta: {
    title: 'Fasuni'
  }
};
