import Vue from 'vue';
import Router from 'vue-router';
import store from './../store';

import NotFound from '@/components/NotFound';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    ...generateRoutes(store.state.routes),
    { path: '*', component: NotFound, meta: { title: '404 Not Found' }, redirect: { name: 'Homepage' } }
  ]
});

function generateRoutes(routeStores = {}) {
  const routes = [];

  for (const key of Object.keys(routeStores)) {
    routes.push(routeStores[key]);
  }

  return routes;
}
