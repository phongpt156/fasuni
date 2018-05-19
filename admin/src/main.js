// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store';
import { sync } from 'vuex-router-sync';
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import Toasted from 'vue-toasted';

Vue.config.productionTip = false;

Vue.use(iView);
Vue.use(Toasted);

sync(store, router);

router.beforeEach((to, from, next) => {
  store.commit('setTitle', to.meta.title);
  next();
});

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
});
