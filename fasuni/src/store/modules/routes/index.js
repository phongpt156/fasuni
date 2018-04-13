import homePage from './homepage';
import category from './category';
import product from './product';
import lookbook from './lookbook';
import lookbookArchive from './lookbookArchive';
import collection from './collection';

const state = {
  homePage,
  category,
  product,
  lookbook,
  lookbookArchive,
  collection
};

export default {
  namespaced: true,
  state
};
