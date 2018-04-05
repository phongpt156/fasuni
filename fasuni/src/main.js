// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import { sync } from 'vuex-router-sync';
import store from './store';

require('@/assets/scripts');

Vue.config.productionTip = false;

sync(store, router);

router.beforeEach(async (to, from, next) => {
  await store.dispatch('setTitle', to.meta.title);
  next();
});

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  components: { App },
  template: '<App/>'
});
