import Layout from 'App/components/layout/Layout';
import Dashboard from 'App/pages/Dashboard';
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
        component: Dashboard,
        meta: {
          title: 'Dashboard',
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
    ]
  },
  {
    path: '*',
    name: '*',
    component: NotFound
  },
];

export default routes;
