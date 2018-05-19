import homePage from './homepage';
import login from './login';
import category from './category';
import product from './product';
import customer from './customer';
import collection from './collection';
import lookbook from './lookbook';

const state = {
  homePage,
  login,
  category,
  product,
  customer,
  collection,
  lookbook
};

export default {
  namespaced: true,
  state
};
