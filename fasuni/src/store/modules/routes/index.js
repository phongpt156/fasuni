import home from './home';
import category from './category';
import product from './product';
import lookbook from './lookbook';
import lookbookArchive from './lookbookArchive';
import collection from './collection';
import storeFinder from './store-finder';
import cart from './cart';
import search from './search';
import myWhistlist from './my-whistlist';
import checkout from './checkout';
import orderView from './order-view';
import orderHistory from './order-history';

const state = {
  home,
  category,
  product,
  lookbook,
  lookbookArchive,
  collection,
  storeFinder,
  cart,
  search,
  myWhistlist,
  checkout,
  orderView,
  orderHistory,
};

export default {
  namespaced: true,
  state,
};
