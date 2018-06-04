// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import { sync } from 'vuex-router-sync';
import store from './store';

import '@/assets/scripts';
import '@/package/progress-bar';
import '@/package/scroll-reveal';

Vue.config.productionTip = false;

sync(store, router);

router.beforeEach(async (to, from, next) => {
  await store.dispatch('setTitle', to.meta.title);
  next();
});

/* eslint-disable no-new */
export default new Vue({
  el: '#app',
  store,
  router,
  components: { App },
  template: '<App/>'
});
