import lazyLoading from './lazy-loading';

export default {
  name: 'LookbookArchive',
  path: '/archive/lookbook',
  component: lazyLoading('archive/Lookbook'),
  meta: {
    title: 'Lookbook Archive'
  }
};
