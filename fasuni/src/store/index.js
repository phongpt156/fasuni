import Vue from 'vue';
import Vuex from 'vuex';

import actions from './actions';
import auth from './modules/auth';
import constants from './modules/constants';
import http from './modules/http';
import routes from './modules/routes';
import services from './modules/services';

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  actions,
  modules: {
    auth,
    constants,
    http,
    routes,
    services
  }
});

export default store;
