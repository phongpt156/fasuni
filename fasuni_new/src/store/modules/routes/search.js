import lazyLoading from './lazy-loading';

export default {
  name: 'Search',
  path: '/search/:name/:type?',
  component: lazyLoading('Search'),
  meta: {
    title: 'Fasuni'
  }
};
