import Layout from 'app/components/layout';
import Domains from 'app/pages/Domains';
import Reports from 'app/pages/Reports';
import Settings from 'app/pages/Settings';
import Links from 'app/pages/Links';
import Login from 'app/pages/Login';
import NotFound from 'app/pages/NotFound';

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
