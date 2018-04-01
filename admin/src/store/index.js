import Vue from 'vue';
import Vuex from 'vuex';

import actions from './actions';
import routes from './modules/routes';
import auth from './modules/auth';
import http from './modules/http';
import constants from './modules/contants';
import services from './modules/services';

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  actions,
  modules: {
    routes,
    auth,
    constants,
    http,
    services
  }
});

export default store;
