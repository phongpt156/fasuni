import lazyLoading from './lazy-loading';

export default {
  name: 'StoreFinder',
  path: '/store-finder',
  component: lazyLoading('StoreFinder'),
  meta: {
    title: 'Store Finder',
  },
};
