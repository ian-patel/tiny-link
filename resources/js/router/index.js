/* eslint-disable no-underscore-dangle */
import Vue from 'vue';
import store from 'app/store';
import Router from 'vue-router';
import routes from './routes';

Vue.use(Router);

/**
 * Create a new router instance.
 *
 * @param  {Array} routes
 * @return {Router}
 */
const router = new Router({
  routes,
  mode: 'history',
});

// Hydrate initial state
if (window.__INITIAL_STATE__) {
  store.replaceState({
    ...store.state,
    ...window.__INITIAL_STATE__,
  });
}

// Change page title by using routes meta
router.beforeEach((to, from, next) => {
  // check auth

  const {
    isLoggedIn,
  } = store.getters;
  if (to.matched.some(route => route.meta.auth === false)) {
    if (isLoggedIn) {
      return next({
        name: 'dashboard',
      });
    }
  } else if (!isLoggedIn) {
    return next({
      name: 'login',
    });
  }

  // Page title
  if (to.meta.title) {
    document.title = to.meta.title;
  }
  next();
});

/**
 * Apply beforeEnter guard to the routes.
 *
 * @param  {Array} routes
 * @param  {Function} beforeEnter
 * @return {Array}
 */
function beforeEnter(routes, beforeEnter) {
  return routes.map(route => ({
    ...route,
    beforeEnter,
  }));
}

/**
 * @param  {Route} to
 * @param  {Route} from
 * @param  {Object|undefined} savedPosition
 * @return {Object}
 */
function scrollBehavior(to, from, savedPosition) {
  return savedPosition || {
    x: 0,
    y: 0,
  };
}

// sync(store, router);

export default router;
