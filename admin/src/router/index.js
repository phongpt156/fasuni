import Vue from 'vue';
import Router from 'vue-router';

import NotFound from '@/components/NotFound';
import store from './../store';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    ...generateRoutes(store.state.routes),
    { path: '*', component: NotFound, meta: { title: '404 Not Found' } }
  ]
});

function generateRoutes(routeStores = {}) {
  const routes = [];
  for (const key of Object.keys(routeStores)) {
    routes.push(routeStores[key]);
  }

  return routes;
}
