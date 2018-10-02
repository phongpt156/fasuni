import lazyLoading from './lazy-loading';

export default {
  name: 'Category',
  path: '/category/:id/:type?',
  component: lazyLoading('Category'),
  meta: {
    title: 'Fasuni',
  },
};
