import Layout from 'App/components/layout/Layout';
import Domains from 'App/pages/Domains';
import Reports from 'App/pages/Reports';
import Settings from 'App/pages/Settings';
import Links from 'App/pages/Links';
import Login from 'App/pages/Login';
import NotFound from 'App/pages/NotFound';

// routes
const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false,
    },
  },
  {
    path: '/',
    component: Layout,
    children: [
      {
        path: '/',
        name: 'dashboard',
        component: Links,
        meta: {
          title: 'Links',
        },
      },
      {
        path: '/links',
        name: 'links',
        component: Links,
        meta: {
          title: 'Links',
        },
      },
      {
        path: '/reports',
        name: 'reports',
        component: Reports,
        meta: {
          title: 'Reports',
        },
      },
      {
        path: '/domains',
        name: 'domains',
        component: Domains,
        meta: {
          title: 'Domains',
        },
      },
      {
        path: '/settings',
        name: 'settings',
        component: Settings,
        meta: {
          title: 'Settings',
        },
      },
    ],
  },
  {
    path: '*',
    name: '*',
    component: NotFound,
  },
];

export default routes;
