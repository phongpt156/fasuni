import homePage from './homepage';
import login from './login';
import category from './category';
import product from './product';
import customer from './customer';

const state = {
  homePage,
  login,
  category,
  product,
  customer
};

export default {
  namespaced: true,
  state
};
