import Vue from 'vue';
import Vuex from 'vuex';

import routes from './modules/routes';
import auth from './modules/auth';
import actions from './actions';

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  actions,
  modules: {
    routes,
    auth
  }
});

export default store;
