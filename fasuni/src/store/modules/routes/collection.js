import lazyLoading from './lazy-loading';

export default {
  name: 'Collection',
  path: '/collection/:id',
  component: lazyLoading('Collection'),
  meta: {
    title: 'Bộ sưu tập',
  },
};
