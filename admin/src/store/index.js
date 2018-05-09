import Vue from 'vue';
import Vuex from 'vuex';

import actions from './actions';
import mutations from './mutation';

import routes from './modules/routes';
import user from './modules/user';
import auth from './modules/auth';

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  mutations,
  actions,
  modules: {
    routes,
    user,
    auth
  }
});

export default store;
