import lazyLoading from './lazy-loading';

export default {
  name: 'Category',
  path: '/category/:slug/:type?',
  component: lazyLoading('category/Category'),
  meta: {
    title: 'Fasuni'
  }
};
