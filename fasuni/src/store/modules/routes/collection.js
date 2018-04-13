import lazyLoading from './lazy-loading';

export default {
  name: 'Collection',
  path: '/collection',
  component: lazyLoading('collection/Collection'),
  meta: {
    title: 'Bộ sưu tập'
  }
};
