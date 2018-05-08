import lazyLoading from './lazy-loading';

export default {
  name: 'Category',
  path: '/category',
  component: lazyLoading('category/Category'),
  meta: {
    title: 'Category',
    layout: 'MainLayout'
  }
};
