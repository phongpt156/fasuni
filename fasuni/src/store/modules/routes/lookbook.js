import lazyLoading from './lazy-loading';

export default {
  name: 'Lookbook',
  path: '/lookbook',
  component: lazyLoading('lookbook/Lookbook'),
  meta: {
    title: 'Lookbook'
  }
};
