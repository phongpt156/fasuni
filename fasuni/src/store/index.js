import Vue from 'vue';
import Vuex from 'vuex';

import mutations from './mutations';
import actions from './actions';
import routes from './modules/routes';
import auth from './modules/auth';

Vue.use(Vuex);

const state = {
  user: null
};

const store = new Vuex.Store({
  strict: true,
  state,
  mutations,
  actions,
  modules: {
    routes,
    auth
  }
});

export default store;
