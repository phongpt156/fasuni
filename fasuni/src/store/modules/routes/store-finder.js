import lazyLoading from './lazy-loading';

export default {
  name: 'StoreFinder',
  path: '/store-finder',
  component: lazyLoading('store-finder/StoreFinder'),
  meta: {
    title: 'Store Finder'
  }
};
