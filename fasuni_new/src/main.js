import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store/';
import { sync } from 'vuex-router-sync';
import './registerServiceWorker';

import '@/assets/scripts';
import '@/package/progress-bar';
import '@/package/scroll-reveal';
import '@/package/autosize';
import '@/package/head';

Vue.config.productionTip = false;

sync(store, router);

// fix incorrect old storage data format
const fixedDate = new Date('06/20/2018 10:17').toISOString();

if (localStorage.getItem('fixed')) {
  let oldFixedDate = new Date(localStorage.getItem('fixed'));

  if (oldFixedDate.toString() === 'Invalid Date' || oldFixedDate.toISOString() < fixedDate) {
    localStorage.clear();
    localStorage.setItem('fixed', fixedDate);
  }
} else {
  localStorage.clear();
  localStorage.setItem('fixed', fixedDate);
}

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app');
