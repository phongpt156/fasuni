import Vue from 'vue';
import Router from 'vue-router';
import store from './store/';

import NotFound from '@/components/NotFound';

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    ...generateRoutes(store.state.routes),
    {
      path: '*', component: NotFound, meta: { title: '404 Not Found' }
    }
  ]
});

function generateRoutes(routeStores = {}) {
  const routes = [];

  for (const key of Object.keys(routeStores)) {
    routes.push(routeStores[key]);
  }

  return routes;
}
