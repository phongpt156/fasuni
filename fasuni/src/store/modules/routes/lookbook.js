import lazyLoading from './lazy-loading';

export default {
  name: 'Lookbook',
  path: '/lookbook/:gender/:year/:month',
  component: lazyLoading('lookbook/Lookbook'),
  meta: {
    title: 'Lookbook'
  }
};
