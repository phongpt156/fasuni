import lazyLoading from './lazy-loading';

export default {
  name: 'Lookbook',
  path: '/lookbook/:gender/:year/:month',
  component: lazyLoading('Lookbook'),
  meta: {
    title: 'Lookbook',
  },
};
