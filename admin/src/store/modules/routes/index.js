import homePage from './homepage';
import login from './login';
import category from './category';
import product from './product';

const state = {
  homePage,
  login,
  category,
  product
};

export default {
  namespaced: true,
  state
};
