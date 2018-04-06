import Vue from 'vue';
import Vuex from 'vuex';

import actions from './actions';
import routes from './modules/routes';

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  actions,
  modules: {
    routes
  }
});

export default store;
