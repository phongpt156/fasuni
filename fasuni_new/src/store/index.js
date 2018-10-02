import Vue from 'vue';
import Vuex from 'vuex';

import mutations from './mutations';
import routes from './modules/routes';
import auth from './modules/auth';
import cart from './modules/cart';
import products from './modules/products';

Vue.use(Vuex);

const state = {
  user: null
};

const store = new Vuex.Store({
  strict: true,
  state,
  mutations,
  modules: {
    routes,
    auth,
    cart,
    products
  }
});

export default store;
