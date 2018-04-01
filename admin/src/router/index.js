import Vue from 'vue';
import Router from 'vue-router';

import store from './../store';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    ...generateRoutes(store.state.routes)
  ]
});

function generateRoutes(routeStores = {}) {
  const routes = [];
  for (const key of Object.keys(routeStores)) {
    routes.push(routeStores[key]);
  }

  return routes;
}
